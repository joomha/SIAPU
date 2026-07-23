<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
        }
        $wargas = $query->latest()->paginate(10);
        return view('admin.warga.index', compact('wargas'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:wargas',
            'email' => 'required|email|unique:wargas,email|unique:users,email',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|string|max:255',
        ]);

        $warga = Warga::create($validated);

        // Auto-generate User account for Warga
        $password = \Carbon\Carbon::parse($warga->tanggal_lahir)->format('dmY');
        User::create([
            'name' => $warga->nama,
            'email' => $warga->email,
            'username' => $warga->nik,
            'password' => Hash::make($password),
            'role' => 'warga',
            'warga_id' => $warga->id
        ]);

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan beserta akun login-nya.');
    }

    public function show(Warga $warga)
    {
        return view('admin.warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:wargas,nik,' . $warga->id,
            'email' => 'required|email|unique:wargas,email,' . $warga->id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|string|max:255',
        ]);

        $warga->update($validated);
        
        if ($warga->user) {
            $warga->user->update([
                'name' => $warga->nama,
                'email' => $warga->email
            ]);
        }

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        
        if ($xlsx = \Shuchkin\SimpleXLSX::parse($file->path())) {
            $rows = $xlsx->rows();
            
            // Assume row 1 is header
            $headers = array_shift($rows);
            
            $imported = 0;
            $updated = 0;

            foreach ($rows as $row) {
                // Ensure array has enough elements
                if (count($row) < 10) continue;
                
                $nik = $row[0];
                $nama = $row[1];
                $tempat_lahir = $row[2];
                $tanggal_lahir = $row[3]; // format YYYY-MM-DD
                $jenis_kelamin = $row[4];
                $alamat = $row[5];
                $rt = $row[6];
                $rw = $row[7];
                $pekerjaan = $row[8];
                $status_perkawinan = $row[9];
                
                // Email is optional in excel, default to NIK@desa.local
                $email = !empty($row[10]) ? $row[10] : $nik . '@desa.local';

                // Skip if NIK is empty
                if (empty($nik)) continue;

                $warga = Warga::where('nik', $nik)->first();
                $isNew = false;
                
                if (!$warga) {
                    $warga = new Warga();
                    $warga->nik = $nik;
                    $isNew = true;
                }

                $warga->nama = $nama;
                $warga->tempat_lahir = $tempat_lahir;
                $warga->tanggal_lahir = $tanggal_lahir;
                $warga->jenis_kelamin = $jenis_kelamin;
                $warga->alamat = $alamat;
                $warga->rt = $rt;
                $warga->rw = $rw;
                $warga->pekerjaan = $pekerjaan;
                $warga->status_perkawinan = $status_perkawinan;
                $warga->email = !empty($warga->email) ? $warga->email : $email;
                $warga->save();

                // Auto-provisioning User Account
                if (!User::where('username', $nik)->exists()) {
                    $passwordStr = \Carbon\Carbon::parse($tanggal_lahir)->format('dmY');
                    User::create([
                        'name' => $nama,
                        'email' => $warga->email,
                        'username' => $nik,
                        'password' => Hash::make($passwordStr),
                        'role' => 'warga',
                        'warga_id' => $warga->id
                    ]);
                }

                if ($isNew) {
                    $imported++;
                } else {
                    $updated++;
                }
            }
            
            activity()
                ->causedBy(auth()->user())
                ->log("Admin mengimport data warga. $imported baru, $updated diperbarui.");

            return back()->with('success', "Import berhasil: $imported data ditambahkan, $updated data diperbarui.");
        } else {
            return back()->with('error', \Shuchkin\SimpleXLSX::parseError());
        }
    }

    public function downloadTemplate()
    {
        $data = [
            ['NIK', 'Nama Lengkap', 'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'Jenis Kelamin (Laki-Laki/Perempuan)', 'Alamat', 'RT', 'RW', 'Pekerjaan', 'Status Perkawinan', 'Email (Opsional)'],
            ['1600000000000001', 'John Doe', 'Serang', '1990-01-01', 'Laki-Laki', 'Kp. Kadubeureum', '001', '002', 'Petani', 'Kawin', 'johndoe@email.com']
        ];

        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($data);
        $xlsx->downloadAs('template_import_warga.xlsx');
        exit;
    }
}
