<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Warga;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendWhatsAppJob;

class ApprovalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create Admin
        $this->admin = User::factory()->create(['role' => 'admin']);
        
        // Create Kades
        $this->kades = User::factory()->create(['role' => 'kades']);
        
        // Create Warga User
        $this->wargaUser = User::factory()->create(['role' => 'warga']);
        $this->warga = Warga::create([
            'user_id' => $this->wargaUser->id,
            'nik' => '1234567890123456',
            'nama' => 'Budi Warga Test',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Karyawan',
            'alamat' => 'Jl. Test No 1',
            'rt_rw' => '01/01',
            'telepon' => '08123456789'
        ]);

        // Connect user to warga
        $this->wargaUser->warga_id = $this->warga->id;
        $this->wargaUser->save();

        // Create Jenis Surat
        $this->jenisSurat = JenisSurat::create([
            'kode_surat' => '470',
            'nama_surat' => 'Surat Keterangan Test',
            'jenis_validasi' => 'tte_kades',
            'format_nomor' => '[KODE]/[NOMOR]/DS/[TAHUN]',
        ]);
    }

    public function test_warga_can_submit_pengajuan()
    {
        $response = $this->actingAs($this->wargaUser)->post(route('warga.pengajuan.store'), [
            'jenis_surat_id' => $this->jenisSurat->id,
            'data_isian' => ['keperluan' => 'Untuk melamar kerja']
        ]);

        $response->assertRedirect(route('warga.dashboard'));
        $this->assertDatabaseHas('pengajuan_surats', [
            'warga_id' => $this->warga->id,
            'status' => 'Menunggu'
        ]);
    }

    public function test_admin_can_validate_and_forward_to_kades()
    {
        Queue::fake();

        $pengajuan = PengajuanSurat::create([
            'warga_id' => $this->warga->id,
            'jenis_surat_id' => $this->jenisSurat->id,
            'tanggal_pengajuan' => today(),
            'status' => 'Menunggu'
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.pengajuan-surat.validasi', $pengajuan->id), [
            'status' => 'Menunggu Kades',
            'catatan_admin' => 'Berkas lengkap'
        ]);

        $response->assertRedirect(route('admin.pengajuan-surat.index'));
        $this->assertDatabaseHas('pengajuan_surats', [
            'id' => $pengajuan->id,
            'status' => 'Menunggu Kades'
        ]);
        
        Queue::assertPushed(SendWhatsAppJob::class);
    }

    public function test_kades_can_approve_and_generate_qr()
    {
        Queue::fake();

        $pengajuan = PengajuanSurat::create([
            'warga_id' => $this->warga->id,
            'jenis_surat_id' => $this->jenisSurat->id,
            'tanggal_pengajuan' => today(),
            'status' => 'Menunggu Kades'
        ]);

        $response = $this->actingAs($this->kades)->post(route('kades.approve', $pengajuan->id), [
            'action' => 'Setujui',
            'passphrase' => '123456'
        ]);

        $response->assertRedirect();
        
        $pengajuan->refresh();
        $this->assertEquals('Selesai', $pengajuan->status);
        $this->assertNotNull($pengajuan->nomor_surat);
        $this->assertNotNull($pengajuan->kode_verifikasi);
        
        Queue::assertPushed(SendWhatsAppJob::class);
    }

    public function test_public_can_verify_qr_code()
    {
        $pengajuan = PengajuanSurat::create([
            'warga_id' => $this->warga->id,
            'jenis_surat_id' => $this->jenisSurat->id,
            'tanggal_pengajuan' => today(),
            'status' => 'Selesai',
            'kode_verifikasi' => 'ABC123XYZ'
        ]);

        $response = $this->get('/verify/ABC123XYZ');
        
        $response->assertStatus(200);
        $response->assertSee('Valid');
        $response->assertSee($this->warga->nama);
    }
}
