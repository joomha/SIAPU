<x-app-layout>
    <x-slot name="header">Pengaturan Sistem</x-slot>

    <div class="card">
        <div class="card-header">
            <h3>Pengaturan Global Sistem</h3>
        </div>

        @if (session('success'))
            <div style="background:#10B981;color:white;padding:12px 20px;border-radius:8px;margin:20px 20px 0;">
                {{ session('success') }}
            </div>
        @endif

        <div style="padding: 20px;">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tab Navigation (Simple CSS Tabs or just stacked for now, we'll stack them for simplicity since Bootstrap JS isn't loaded) -->
                <div style="margin-bottom: 24px;">
                    <h4 style="margin-bottom: 16px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">Profil Desa</h4>
                    
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Nama Desa</label>
                        <input type="text" class="form-input" name="desa_nama" value="{{ $settings['desa_nama'] ?? 'Kadubeureum' }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Nama Kecamatan</label>
                        <input type="text" class="form-input" name="kecamatan" value="{{ $settings['kecamatan'] ?? 'Pabuaran' }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Alamat Desa</label>
                        <textarea class="form-input" name="desa_alamat" rows="2">{{ $settings['desa_alamat'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Nama Kepala Desa</label>
                        <input type="text" class="form-input" name="kades_nama" value="{{ $settings['kades_nama'] ?? '' }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">NIP Kepala Desa</label>
                        <input type="text" class="form-input" name="kades_nip" value="{{ $settings['kades_nip'] ?? '' }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Logo Desa</label><br>
                        @if(isset($settings['logo']))
                            <img src="{{ asset('storage/'.$settings['logo']) }}" alt="Logo" width="100" style="margin-bottom: 10px; border-radius: 8px;">
                        @endif
                        <input type="file" style="display:block;" name="logo" accept="image/*">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Kop Surat (Gambar)</label><br>
                        @if(isset($settings['kop_surat']))
                            <img src="{{ asset('storage/'.$settings['kop_surat']) }}" alt="Kop Surat" width="300" style="margin-bottom: 10px; border-radius: 8px;">
                        @endif
                        <input type="file" style="display:block;" name="kop_surat" accept="image/*">
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <h4 style="margin-bottom: 16px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">Email (SMTP)</h4>
                    
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" class="form-input" name="smtp_host" value="{{ $settings['smtp_host'] ?? config('mail.mailers.smtp.host') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">SMTP Port</label>
                        <input type="text" class="form-input" name="smtp_port" value="{{ $settings['smtp_port'] ?? config('mail.mailers.smtp.port') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">SMTP Username</label>
                        <input type="text" class="form-input" name="smtp_username" value="{{ $settings['smtp_username'] ?? config('mail.mailers.smtp.username') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" class="form-input" name="smtp_password" value="{{ $settings['smtp_password'] ?? config('mail.mailers.smtp.password') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Email Pengirim (From Address)</label>
                        <input type="email" class="form-input" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? config('mail.from.address') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Nama Pengirim (From Name)</label>
                        <input type="text" class="form-input" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? config('mail.from.name') }}">
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <h4 style="margin-bottom: 16px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">WhatsApp (Fonnte)</h4>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Fonnte Token (WhatsApp Gateway)</label>
                        <input type="text" class="form-input" name="fonnte_token" value="{{ $settings['fonnte_token'] ?? env('FONNTE_TOKEN') }}">
                        <p style="font-size: 13px; color: #64748B; margin-top: 5px;">Dapatkan token dari <a href="https://fonnte.com" target="_blank" style="color: #3B82F6;">fonnte.com</a></p>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
