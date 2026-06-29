# TECHNICAL_SPEC.md

## Project Information

### Project Name

Sistem Informasi Administrasi Pelayanan Umum (SIAPU)

### Organization

Kelurahan Kadubeureum – Pabuaran

### Project Type

Web-Based Information System

### Development Methodology

Waterfall

---

# System Objective

Membangun sistem informasi administrasi pelayanan umum berbasis web yang mampu:

* Mengelola data warga secara terpusat
* Mempermudah pembuatan surat administrasi
* Menyediakan arsip digital
* Mendukung transparansi data BLT
* Mengurangi kesalahan dan duplikasi data

---

# Architecture

## Architecture Style

Monolithic Web Application

### Reason

* Sesuai kebutuhan kelurahan
* Jumlah pengguna relatif kecil
* Mudah dipelihara
* Biaya implementasi rendah
* Sesuai pendekatan Waterfall

---

# User Roles

## Administrator / Petugas Kelurahan

Permissions:

* Login
* Kelola data warga
* Kelola surat
* Cetak surat
* Kelola arsip
* Kelola data BLT
* Lihat laporan

---

## Masyarakat

Permissions:

* Mengajukan surat
* Melihat status pengajuan
* Melihat informasi BLT

---

## Validator / Pejabat Berwenang

Permissions:

* Memvalidasi surat
* Melihat laporan

---

# Functional Modules

## Authentication Module

Features:

* Login
* Logout
* Session Management

Validation:

* Username wajib
* Password wajib

---

## Citizen Management Module

Features:

* Tambah warga
* Edit warga
* Hapus warga
* Cari warga
* Detail warga

Validation:

* NIK unik
* NIK 16 digit
* Nama wajib diisi

---

## Administrative Letter Module

Features:

* Kelola jenis surat
* Generate surat otomatis
* Nomor surat otomatis
* Cetak surat PDF
* Riwayat surat

Supported Letter Types:

* Surat Keterangan
* Surat Pengantar
* Surat Domisili
* Surat Administrasi Umum

---

## Archive Module

Features:

* Arsip surat digital
* Pencarian arsip
* Filter arsip
* Download arsip

---

## BLT Module

Features:

* Data penerima BLT
* Riwayat penerimaan BLT
* Status penerima BLT
* Informasi publik BLT

Objectives:

* Transparansi
* Akuntabilitas
* Validitas data penerima

---

## Report Module

Reports:

* Data warga
* Surat administrasi
* Data BLT
* Statistik pelayanan

Output:

* PDF
* Print

---

# Database Specification

## Table: users

Fields:

* id
* username
* password
* full_name
* role
* created_at
* updated_at

---

## Table: warga

Fields:

* id
* nik
* nama
* tempat_lahir
* tanggal_lahir
* jenis_kelamin
* alamat
* rt
* rw
* pekerjaan
* status_perkawinan
* created_at
* updated_at

Constraints:

* nik UNIQUE

---

## Table: jenis_surat

Fields:

* id
* nama_surat
* deskripsi
* template_surat

---

## Table: surat

Fields:

* id
* nomor_surat
* warga_id
* jenis_surat_id
* tanggal_surat
* status
* file_surat
* created_at

Status:

* Draft
* Menunggu Validasi
* Disetujui
* Ditolak

---

## Table: pengajuan_surat

Fields:

* id
* warga_id
* jenis_surat_id
* tanggal_pengajuan
* status
* catatan

---

## Table: arsip

Fields:

* id
* surat_id
* lokasi_file
* tanggal_arsip

---

## Table: blt

Fields:

* id
* warga_id
* periode
* nominal
* status_penerima
* keterangan

---

# Database Relationships

users
└── manages system

warga
├── surat
├── pengajuan_surat
└── blt

jenis_surat
└── surat

surat
└── arsip

---

# Business Rules

## Data Warga

* NIK tidak boleh duplikat
* Warga harus terdaftar sebelum surat dibuat

---

## Surat

* Surat hanya dapat dibuat dari data warga valid
* Nomor surat harus unik
* Surat harus melalui validasi

---

## Arsip

* Setiap surat yang selesai otomatis masuk arsip

---

## BLT

* Data penerima harus berasal dari data warga
* Riwayat penerimaan tidak boleh dihapus

---

# User Flow

## Login

User
→ Input Username
→ Input Password
→ Validasi
→ Dashboard

---

## Pembuatan Surat

Petugas
→ Cari Data Warga
→ Pilih Jenis Surat
→ Generate Surat
→ Validasi
→ Cetak
→ Arsip Otomatis

---

## Pengajuan Surat

Masyarakat
→ Ajukan Surat
→ Verifikasi
→ Validasi
→ Selesai

---

# Security Specification

## Authentication

* Session Based Authentication

## Authorization

* Role Based Access Control (RBAC)

## Password

* Password Hashing

## Data Protection

* Validasi seluruh input
* Sanitasi input pengguna

---

# Performance Requirement

Response Time:

* Maksimal 3 detik

Concurrent User:

* 20–50 pengguna

Availability:

* Jam operasional kantor

---

# Testing Specification

## Testing Method

Black Box Testing

---

## Test Coverage

Authentication

* Login berhasil
* Login gagal

Data Warga

* Tambah data
* Ubah data
* Hapus data

Surat

* Generate surat
* Cetak surat

BLT

* Tambah data
* Tampilkan data

Arsip

* Simpan arsip
* Cari arsip

---

# Deployment Specification

Environment:

* Local Server / VPS

Web Server:

* Apache

Programming Language:

* PHP

Database:

* MySQL

Browser Support:

* Chrome
* Edge
* Firefox

---

# Non Functional Requirements

Usability

* Mudah digunakan aparatur kelurahan

Reliability

* Data tersimpan konsisten

Maintainability

* Mudah dikembangkan

Scalability

* Mendukung pertumbuhan data warga

Security

* Hak akses berbasis peran
* Password terenkripsi
* Validasi input
