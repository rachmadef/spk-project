# 🚀 Panduan Instalasi Project SPK Prediksi Kinerja Siswa

Panduan ini disusun untuk memudahkan pengujian dan pengerjaan bersama rekan tim dalam menjalankan aplikasi **Sistem Pendukung Keputusan (SPK) Prediksi Kinerja Siswa SD Negeri Jarak 2** berbasis Laravel 13, Livewire 4, dan Metode **Simple Additive Weighting (SAW)**.

---

## 💻 Kebutuhan Sistem Minimum (System Requirements)

- **PHP**: `>= 8.3` atau `PHP 8.4`
- **Ekstensi PHP Wajib**: `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`
- **Database**: MySQL / MariaDB (Disarankan menggunakan **Laragon** atau **XAMPP**)
- **Composer**: `v2.x`
- **Node.js & NPM**: Node `v18+` / `v20+`

---

## 🔑 Konfigurasi Penting File `.env`

Buat file bernama `.env` pada folder utama proyek (bisa disalin dari `.env.example`). Pastikan baris konfigurasi basis data disesuaikan seperti berikut:

```env
APP_NAME="SPK SD Negeri Jarak 2"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# ----------------------------------------------------------------------
# KONFIGURASI BASIS DATA (MYSQL) - SANGAT PENTING
# ----------------------------------------------------------------------
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_project
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
CACHE_STORE=database
```

> ⚠️ **Catatan Penting Database**:
> 1. Pastikan Service **MySQL** di Laragon / XAMPP sudah dinyalakan.
> 2. Buat database baru bernama `spk_project` di phpMyAdmin / HeidiSQL / DBeaver sebelum menjalankan migrasi.

---

## 🛠️ Langkah-Langkah Instalasi (Step-by-Step)

Buka terminal (Command Prompt / PowerShell / Git Bash) di folder project `spk-project`, lalu jalankan perintah berikut secara berurutan:

### 1. Copy File Environment
```bash
cp .env.example .env
```
*(Atau salin manual file `.env.example` lalu ubah namanya menjadi `.env`)*

### 2. Install Dependency PHP (Composer)
```bash
composer install
```

### 3. Generate Application Key Laravel
```bash
php artisan key:generate
```

### 4. Eksekusi Migrasi Tabel Database & Seeder Data Default
```bash
php artisan migrate:fresh --seed
```
*(Perintah ini akan otomatis membuat seluruh tabel database dan mengisikan data default kriteria C1-C4, data sampel siswa, serta akun user penguji)*

### 5. Install & Build Dependency Frontend (Vite & Tailwind CSS)
```bash
npm install
npm run build
```

### 6. Jalankan Local Server
```bash
php artisan serve
```
Buka browser Anda dan akses alamat:
👉 **[http://localhost:8000](http://localhost:8000)** atau **[http://localhost:8000/login](http://localhost:8000/login)**

---

## 👥 Akun Demo Login Penguji

Setelah proses `migrate:fresh --seed` selesai, Anda dapat langsung login menggunakan akun default berikut:

| Role / Peran | Email Login | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Wali Kelas** | `walikelas@sdnjarak2.sch.id` | `password` | Input nilai siswa, hitung SPK SAW, cetak PDF |
| **Admin Utama** | `admin@sdnjarak2.sch.id` | `password` | Kelola master kriteria, bobot, siswa, & user |
| **Kepala Sekolah** | `kepsek@sdnjarak2.sch.id` | `password` | Pantau dashboard grafik & cetak laporan PDF |

---

## ❓ Troubleshooting (Penanganan Masalah Umum)

### 1. Error `could not find driver` (PDO MySQL)
- **Penyebab**: Ekstensi `pdo_mysql` di PHP belum aktif.
- **Solusi**:
  - Buka file `php.ini` di folder PHP Laragon/XAMPP Anda.
  - Hapus tanda titik koma `;` pada baris: `;extension=pdo_mysql` menjadi `extension=pdo_mysql`.
  - Restart web server Laragon / Apache / MySQL.

### 2. Error `Vite manifest not found`
- **Penyebab**: Asset Tailwind & JS belum di-compile.
- **Solusi**: Jalankan perintah `npm run build` pada terminal.

### 3. Membersihkan Cache Laravel jika Mengalami Error Perubahan
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---
*Dokumen ini dibuat untuk mempermudah pengerjaan dan pengujian kolaboratif team.*
