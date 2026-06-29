<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@kadubeureum.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\JenisSurat::insert([
            ['nama_surat' => 'Surat Izin Usaha Mikro Kecil (IUMK)', 'deskripsi' => 'Surat izin untuk pelaku usaha mikro dan kecil'],
            ['nama_surat' => 'Surat Keterangan Ahli Waris', 'deskripsi' => 'Surat keterangan penetapan ahli waris dari almarhum/almarhumah'],
            ['nama_surat' => 'Surat Keterangan Belum Kawin', 'deskripsi' => 'Surat keterangan bahwa yang bersangkutan belum pernah menikah'],
            ['nama_surat' => 'Surat Keterangan Berkelakuan Baik', 'deskripsi' => 'Surat keterangan kelakuan baik dari kelurahan'],
            ['nama_surat' => 'Surat Keterangan Domisili', 'deskripsi' => 'Surat keterangan domisili/tempat tinggal warga'],
            ['nama_surat' => 'Surat Keterangan Janda/Duda', 'deskripsi' => 'Surat keterangan status janda atau duda'],
            ['nama_surat' => 'Surat Keterangan Kelahiran', 'deskripsi' => 'Surat keterangan kelahiran bayi dari kelurahan'],
            ['nama_surat' => 'Surat Keterangan Kematian', 'deskripsi' => 'Surat keterangan meninggal dunia dari kelurahan'],
            ['nama_surat' => 'Surat Keterangan Kepemilikan Tanah', 'deskripsi' => 'Surat keterangan kepemilikan lahan/tanah di wilayah kelurahan'],
            ['nama_surat' => 'Surat Keterangan KTP/KK Sementara', 'deskripsi' => 'Surat keterangan pengganti KTP/KK sementara'],
            ['nama_surat' => 'Surat Keterangan Penghasilan Orang Tua', 'deskripsi' => 'Surat keterangan penghasilan orang tua untuk beasiswa/sekolah'],
            ['nama_surat' => 'Surat Keterangan Pindah', 'deskripsi' => 'Surat keterangan pindah domisili ke wilayah lain'],
            ['nama_surat' => 'Surat Keterangan Tidak Mampu', 'deskripsi' => 'Surat keterangan tidak mampu secara ekonomi'],
            ['nama_surat' => 'Surat Keterangan Usaha', 'deskripsi' => 'Surat keterangan memiliki usaha di wilayah kelurahan'],
            ['nama_surat' => 'Surat Pengantar Izin Keramaian', 'deskripsi' => 'Surat pengantar untuk izin keramaian/hajatan ke kepolisian'],
            ['nama_surat' => 'Surat Pengantar Nikah (NA)', 'deskripsi' => 'Surat pengantar nikah untuk pengurusan ke KUA'],
            ['nama_surat' => 'Surat Pengantar Pembuatan KTP', 'deskripsi' => 'Surat pengantar untuk pembuatan/perekaman KTP elektronik'],
            ['nama_surat' => 'Surat Pengantar SKCK', 'deskripsi' => 'Surat pengantar untuk pengurusan SKCK di kepolisian'],
            ['nama_surat' => 'Surat Pernyataan Tanggung Jawab Mutlak', 'deskripsi' => 'Surat pernyataan tanggung jawab penuh atas kebenaran data'],
        ]);
    }
}
