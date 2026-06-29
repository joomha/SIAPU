PROJECT BRIEF
Nama Produk

SIAPU

Sistem Informasi Administrasi Pelayanan Umum Berbasis Web

Instansi

Kelurahan Kadubeureum

Latar Belakang

Proses administrasi masih dilakukan menggunakan Microsoft Office dan arsip fisik.

Permasalahan utama:

Data warga tidak terintegrasi
Pembuatan surat masih manual
Arsip sulit dicari
Risiko kehilangan dokumen
Duplikasi data sering terjadi
Transparansi BLT masih rendah
Pelayanan membutuhkan waktu lama
VISI PRODUK

Membangun sistem administrasi desa/kelurahan berbasis web yang terintegrasi untuk meningkatkan:

Efisiensi pelayanan
Akurasi data
Transparansi BLT
Kecepatan pembuatan surat
Pengarsipan digital
TUJUAN SISTEM
Mengelola data warga secara terpusat.
Mempermudah pembuatan surat.
Menyediakan arsip digital.
Menyediakan informasi BLT yang transparan.
Mengurangi kesalahan administrasi.
AKTOR SISTEM
Admin / Petugas Kelurahan

Hak akses:

Login
Kelola data warga
Kelola surat
Cetak surat
Kelola arsip
Validasi surat
Lihat laporan
Masyarakat

Hak akses:

Ajukan pembuatan surat
Melihat informasi BLT
Melihat status pengajuan
Pejabat Berwenang

Hak akses:

Validasi surat
Melihat laporan
FITUR UTAMA
Autentikasi
Login
Logout
Data Warga

CRUD Data Warga

Field minimum:

NIK
Nama
Tempat Lahir
Tanggal Lahir
Jenis Kelamin
Alamat
RT
RW
Status Perkawinan
Pekerjaan
Surat Administrasi

Jenis surat:

Surat Keterangan
Surat Pengantar
Surat Administrasi Lainnya

Fitur:

Generate otomatis
Nomor surat otomatis
Cetak PDF
Riwayat surat
Arsip Digital

Fitur:

Penyimpanan surat digital
Pencarian arsip
Filter tanggal
Download ulang
Bantuan Langsung Tunai (BLT)

Fitur:

Data penerima
Riwayat bantuan
Status penerima
Transparansi publik
Laporan

Jenis laporan:

Data warga
Surat masuk
Surat keluar
Statistik pelayanan
Data BLT
USER FLOW
Pembuatan Surat
Login
↓
Cari Data Warga
↓
Pilih Jenis Surat
↓
Generate Surat
↓
Validasi
↓
Cetak PDF
↓
Arsip Otomatis
Pengajuan Surat Oleh Warga
Warga Ajukan Surat
↓
Petugas Verifikasi
↓
Validasi
↓
Surat Selesai
↓
Warga Download/Cetak
ENTITAS DATABASE
users
id
name
username
password
role
warga
id
nik
nama
tempat_lahir
tanggal_lahir
jenis_kelamin
alamat
rt
rw
pekerjaan
status_perkawinan
jenis_surat
id
nama_surat
template
surat
id
nomor_surat
warga_id
jenis_surat_id
tanggal
status
pdf_file
arsip
id
surat_id
created_at
blt
id
warga_id
periode
jumlah
status
pengajuan_surat
id
warga_id
jenis_surat_id
tanggal
status
catatan
RELASI
Warga
 ├── Surat
 ├── Pengajuan Surat
 └── BLT

Jenis Surat
 └── Surat

Surat
 └── Arsip
KEBUTUHAN FUNGSIONAL
Sistem harus dapat
Login
Logout
CRUD warga
CRUD jenis surat
Generate surat otomatis
Cetak PDF
Arsip digital
Pencarian data
Pengajuan surat online
Validasi surat
Transparansi BLT
Laporan
KEBUTUHAN NON FUNGSIONAL
Performance
Respon < 3 detik
Security
Password Hash
Session Management
Role Based Access Control
Availability
Web Based
Multi User
Usability
Mudah digunakan petugas kelurahan
METODOLOGI PENELITIAN

Metode Pengembangan:

Waterfall

Tahapan:

Analisis
Design
Coding
Testing
Maintenance
UML YANG HARUS DIBUAT

Berdasarkan isi skripsi:

Use Case Diagram
Activity Diagram
Sequence Diagram
Class Diagram
-< dalam format mermaid JS saja

