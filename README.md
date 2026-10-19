# FINTEGRITA Platform

**Financial Integrity & Integrated Solutions**  
*Know Your Numbers. Grow Your Business.*

Sistem Terpadu Ekosistem Bisnis Digital FINTEGRITA: Web Perusahaan, Toko Produk Digital, Portal Pelanggan, dan ERP Akuntansi/Keuangan Internal berbasis **Laravel 12** dan **Filament v3**.

---

## 3 Pilar Sistem Utama
1. **Corporate Website & Showcase:** Profil resmi lembaga, portofolio terverifikasi, artikel edukasi bisnis & akuntansi (*Insight*), serta form pemesanan jasa kustom (RFQ).
2. **Digital Store & Customer Portal (`/portal`):** Katalog produk digital (software, template Excel pembukuan, e-book, kalkulator bisnis), alur checkout/invoicing otomatis, aktivasi lisensi software, serta tracking progres kelas & proyek klien.
3. **Internal Operations & Accounting ERP (`/admin`):** Dashboard manajemen terpadu dengan pembukuan berpasangan (*double-entry journal*), Chart of Accounts (COA) standar, buku besar, neraca saldo, arus kas, laporan laba rugi, serta alur approval pengeluaran bertingkat.

---

## 6 Lini Bisnis FINTEGRITA
- **FINTEGRITA Finance:** Aplikasi keuangan personal & UMKM, pembukuan harian, dan template laporan keuangan.
- **FINTEGRITA Tech:** Rekayasa sistem web & software khusus (SIM Koperasi Simpan Pinjam, Sistem Pendidikan/Sekolah, POS Kasir Retail, Integrasi API).
- **FINTEGRITA Intelligence:** Dashboard analitik kinerja bisnis, Business Intelligence (BI), dan otomasi laporan.
- **FINTEGRITA Academy:** Pelatihan literasi keuangan, akuntansi UMKM, bimtek lembaga, dan coding anak.
- **FINTEGRITA Advisory:** Layanan konsultasi keuangan, evaluasi SOP pembukuan, dan pendampingan bisnis.
- **FINTEGRITA Knowledge:** Modul panduan praktis, e-book berlisensi, dan worksheet bisnis.

---

## Struktur Role & Hak Akses (RBAC)
- **Super Admin:** Konfigurasi penuh sistem, database, dan seluruh modul.
- **Direktur:** Dashboard eksekutif, laporan keuangan komprehensif, approval pengeluaran limit tinggi.
- **Finance & Accounting:** Pencatatan jurnal, rekonsiliasi kas/bank, verifikasi pembayaran, tutup buku periode fiskal.
- **Project Manager:** Manajemen kontrak, milestone, deliverables, dan tracking anggaran biaya proyek.
- **Academy Admin:** Pengelolaan kelas, jadwal sesi, materi pembelajaran, dan sertifikasi peserta.
- **Sales / CS:** Pengelolaan prospek (CRM Leads), follow-up penawaran, dan customer ticketing.
- **Customer / Pelanggan:** Akses unduhan produk digital, key lisensi, invoice pembayaran, dan progres kelas di `/portal`.

---

## Arsitektur Teknis & Docker
- **Backend:** Laravel 12 (PHP 8.3)
- **Admin & Portal Engine:** Filament v3 (Livewire 3 + Alpine.js + Tailwind CSS)
- **Database:** MySQL 8.0 / PostgreSQL
- **Containerization:** Docker Multi-stage (Alpine 3.21, Nginx, PHP-FPM, Supervisor)
- **Port Alokasi:** `8082` (Web App) & `3308` (MySQL DB)

### Menjalankan via Docker
```bash
# Salin konfigurasi environment
cp .env.example .env

# Jalankan container
docker compose up -d --build

# Jalankan migrasi dan seeder awal
docker exec fintegrita_app php artisan migrate --seed
```

### Akun Awal Default Seeder:
- **Super Admin:** `admin@fintegrita.com` / `password` (Panel: `/admin`)
- **Direktur:** `director@fintegrita.com` / `password` (Panel: `/admin`)
