# SPK Prediksi Kinerja Siswa SD Negeri Jarak 2 (Metode SAW)

Sistem Pendukung Keputusan (SPK) berbasis web untuk memprediksi kinerja peserta didik di SD Negeri Jarak 2 Tahun Pelajaran 2025/2026 menggunakan metode **Simple Additive Weighting (SAW)**.

Built with **Laravel 13**, **Livewire 4**, **Tailwind CSS**, and **FontAwesome 6**.

---

## 📖 Panduan Lengkap Instalasi & Setup

Panduan langkah demi langkah cara menginstal project ini dan konfigurasi file `.env` di laptop rekan/penguji dapat dilihat pada file:

👉 **[PANDUAN_INSTALASI.md](file:///c:/laragon/www/spk-project/PANDUAN_INSTALASI.md)**

---

## ⚡ Quick Start Command Summary

```bash
# 1. Salin environment config
cp .env.example .env

# 2. Install PHP packages
composer install

# 3. Generate key & setup database
php artisan key:generate
php artisan migrate:fresh --seed

# 4. Install & build frontend assets
npm install
npm run build

# 5. Jalankan local server
php artisan serve
```

## 🔑 Akun Login Demo

- **Wali Kelas**: `walikelas@sdnjarak2.sch.id` | Password: `password`
- **Admin**: `admin@sdnjarak2.sch.id` | Password: `password`
- **Kepala Sekolah**: `kepsek@sdnjarak2.sch.id` | Password: `password`
