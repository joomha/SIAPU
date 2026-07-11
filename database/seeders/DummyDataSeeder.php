<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. Warga
        $wargaIds = [];
        for ($i = 0; $i < 30; $i++) {
            $wargaIds[] = DB::table('wargas')->insertGetId([
                'nik' => $faker->unique()->numerify('160#############'),
                'nama' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'jenis_kelamin' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
                'alamat' => $faker->address,
                'rt' => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 5), 3, '0', STR_PAD_LEFT),
                'pekerjaan' => $faker->jobTitle,
                'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Fetch Jenis Surat
        $jenisSurats = DB::table('jenis_surats')->pluck('id')->toArray();
        if (empty($jenisSurats)) return;

        // 2. Pengajuan Surat & Surat & Arsip
        $statuses = ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'];
        
        foreach ($wargaIds as $wargaId) {
            // Each warga makes 1-3 requests
            $numRequests = rand(1, 3);
            for ($i = 0; $i < $numRequests; $i++) {
                $status = $faker->randomElement($statuses);
                
                $pengajuanId = DB::table('pengajuan_surats')->insertGetId([
                    'warga_id' => $wargaId,
                    'jenis_surat_id' => $faker->randomElement($jenisSurats),
                    'tanggal_pengajuan' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                    'status' => $status,
                    'catatan' => $status == 'Ditolak' ? 'Dokumen tidak lengkap' : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // If processed or finished, maybe create a Surat
                if ($status == 'Diproses' || $status == 'Selesai') {
                    $suratStatus = $status == 'Selesai' ? 'Disetujui' : 'Menunggu Validasi';
                    $suratId = DB::table('surats')->insertGetId([
                        'nomor_surat' => '140/' . $faker->unique()->randomNumber(4) . '/2024',
                        'warga_id' => $wargaId,
                        'jenis_surat_id' => $faker->randomElement($jenisSurats),
                        'tanggal_surat' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                        'status' => $suratStatus,
                        'file_surat' => $status == 'Selesai' ? 'dummy.pdf' : null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // If Finished, create Arsip
                    if ($status == 'Selesai') {
                        DB::table('arsips')->insert([
                            'surat_id' => $suratId,
                            'lokasi_file' => 'arsip/dummy.pdf',
                            'tanggal_arsip' => Carbon::now()->format('Y-m-d'),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }

        // 3. BLT
        for ($i = 0; $i < 20; $i++) {
            DB::table('blts')->insert([
                'warga_id' => $faker->randomElement($wargaIds),
                'periode' => $faker->randomElement(['Januari 2024', 'Februari 2024', 'Maret 2024']),
                'nominal' => $faker->randomElement([300000, 600000]),
                'status_penerima' => $faker->randomElement(['Aktif', 'Dicabut']),
                'keterangan' => 'BLT Dana Desa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
