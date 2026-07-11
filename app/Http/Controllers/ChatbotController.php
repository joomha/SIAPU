<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $reply = "Maaf, saya belum mengerti pertanyaan Anda. Sebagai Asisten Virtual SIAPU, saya bisa memberikan informasi terkait <b>Layanan Surat</b>, <b>Persyaratan</b>, atau <b>Cara Cek Status</b>.";

        if (str_contains($message, 'surat') || str_contains($message, 'buat')) {
            $reply = "Untuk membuat surat, silakan klik tombol <b>Buat Pengajuan</b> di atas. Kami menyediakan 19 jenis surat online yang bisa diproses dengan cepat.";
        } elseif (str_contains($message, 'status') || str_contains($message, 'cek') || str_contains($message, 'lacak')) {
            $reply = "Anda dapat mengecek status surat Anda kapan saja dengan mengeklik tombol <b>Cek Status Saya</b> dan memasukkan NIK Anda.";
        } elseif (str_contains($message, 'syarat') || str_contains($message, 'persyaratan') || str_contains($message, 'berkas')) {
            $reply = "Persyaratan detail bisa Anda temukan di bagian <b>Persyaratan Pengajuan Surat</b> di halaman ini. Biasanya Anda hanya perlu KTP dan Kartu Keluarga.";
        } elseif (str_contains($message, 'halo') || str_contains($message, 'hai') || str_contains($message, 'pagi') || str_contains($message, 'siang') || str_contains($message, 'malam') || str_contains($message, 'sore')) {
            $reply = "Halo! Selamat datang di SIAPU Desa Kadubeureum. Ada yang bisa saya bantu terkait layanan desa hari ini?";
        } elseif (str_contains($message, 'jam') || str_contains($message, 'buka') || str_contains($message, 'operasional') || str_contains($message, 'kantor')) {
            $reply = "Layanan digital SIAPU online 24 jam sehari! Untuk operasional fisik Kantor Desa adalah Senin - Jumat, 08:00 - 15:00 WIB.";
        } elseif (str_contains($message, 'terima kasih') || str_contains($message, 'makasih') || str_contains($message, 'ok') || str_contains($message, 'baik')) {
            $reply = "Sama-sama! Senang bisa membantu Anda. Jika ada pertanyaan lain, ketik saja di sini.";
        }

        usleep(800000); // 0.8s delay for realistic typing

        return response()->json(['reply' => $reply]);
    }
}
