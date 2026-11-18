# Restoe Boemi POS

**Sistem Informasi Point of Sale (POS) dan Manajemen Operasional Restoran**

Restoe Boemi POS merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan operasional restoran dalam satu sistem terintegrasi. Aplikasi ini mencakup pengelolaan menu, pemesanan melalui QR Digital Menu, transaksi kasir, pemantauan pesanan dapur, hingga laporan penjualan.

Aplikasi ini juga dilengkapi AI Business Assistant yang memanfaatkan Ollama untuk membantu pemilik restoran memahami data operasional dan memperoleh rekomendasi bisnis.

## Fitur Utama

- **Dashboard Owner** — Ringkasan aktivitas dan performa operasional restoran.
- **Manajemen Menu** — Pengelolaan menu, kategori, harga, dan ketersediaan.
- **QR Digital Menu** — Pelanggan dapat melihat menu dan melakukan pemesanan melalui QR Code tanpa membuat akun.
- **Manajemen Meja** — Pengelolaan meja dan status ketersediaannya.
- **Kasir** — Pengelolaan pesanan dan proses pembayaran.
- **Kitchen Display** — Pemantauan pesanan yang telah dibayar oleh kasir.
- **Manajemen Pengguna** — Pengelolaan akun internal berdasarkan hak akses.
- **Manajemen Pelanggan** — Penyimpanan dan pengelolaan data pelanggan.
- **Laporan** — Penyajian informasi transaksi dan penjualan.
- **AI Business Assistant** — Asisten berbasis AI untuk membantu analisis data operasional restoran.

## Hak Akses Pengguna

| Role | Hak Akses |
|---|---|
| Owner | Mengelola seluruh operasional dan pengguna internal |
| Cashier | Mengelola pesanan dan pembayaran |
| Kitchen | Melihat dan memperbarui status pesanan dapur |
| Customer | Melakukan pemesanan melalui QR Digital Menu tanpa login |

## Teknologi yang Digunakan

- PHP 8.2+
- Laravel 12
- MySQL
- Tailwind CSS
- Alpine.js
- Vite
- Spatie Laravel Permission
- Endroid QR Code
- Ollama
- Llama 3.2:1b
- Git dan GitHub

## Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau lebih baru
- Composer
- MySQL
- Node.js dan NPM
- Git

Ollama diperlukan jika ingin menggunakan fitur AI Business Assistant.

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/anangabduhmajid/restoe-boemi-pos.git
cd restoe-boemi-pos
```

### 2. Install Dependency

```bash
composer install
npm ci
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Buka file `.env`, kemudian sesuaikan konfigurasi database MySQL:

```env
APP_NAME="Restoe Boemi POS"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restoe_boemi
DB_USERNAME=root
DB_PASSWORD=
```

Buat database dengan nama `restoe_boemi` melalui phpMyAdmin atau MySQL sebelum melanjutkan.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Migrasi Database

```bash
php artisan migrate
```

Perintah ini membuat tabel-tabel yang diperlukan aplikasi.

### 6. Buat Role Pengguna

Jalankan seeder khusus role:

```bash
php artisan db:seed --class=RoleSeeder
```

Seeder ini akan membuat empat role: owner, cashier, kitchen, dan customer.

### 7. Buat Akun Owner Pertama

Buat akun Owner melalui Laravel Tinker:

```bash
php artisan tinker
```

Di dalam Tinker, jalankan:

```php
$user = \App\Models\User::create([
    'name' => 'Nama Owner',
    'email' => 'owner@example.com',
    'password' => 'GANTI_DENGAN_PASSWORD_KUAT',
    'is_active' => true,
]);

$user->assignRole('owner');
```

Ganti nama, email, dan password contoh dengan informasi akun milik sendiri. Gunakan password unik dan kuat.

Keluar dari Tinker:

```php
exit
```

**Catatan:** Jangan menggunakan `php artisan migrate --seed` untuk instalasi ini. `DatabaseSeeder` bawaan project masih membuat akun Test User dengan password default. Gunakan langkah migrasi dan pembuatan role di atas.

### 8. Buat Storage Link

```bash
php artisan storage:link
```

### 9. Build Frontend

```bash
npm run build
```

### 10. Jalankan Aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000
```

Login menggunakan akun Owner yang telah dibuat sebelumnya.

## Konfigurasi AI Business Assistant

Fitur AI Business Assistant menggunakan Ollama secara lokal.

### 1. Install Ollama

Unduh dan install Ollama melalui:

https://ollama.com/

### 2. Unduh Model

Jalankan:

```bash
ollama pull llama3.2:1b
```

### 3. Jalankan Ollama

Pastikan layanan Ollama aktif dan dapat diakses melalui:

```text
http://127.0.0.1:11434
```

Konfigurasi model pada aplikasi saat ini menggunakan:

- Model: `llama3.2:1b`
- Endpoint: `http://127.0.0.1:11434`

AI Business Assistant merupakan fitur tambahan. Ollama tidak diperlukan untuk menjalankan fitur POS utama.

## Penggunaan QR Digital Menu

Pelanggan dapat memindai QR Code pada meja untuk membuka halaman menu, memilih produk, dan mengirim pesanan tanpa harus membuat akun atau login.

Untuk mengakses menu melalui perangkat lain dalam jaringan lokal, sesuaikan `PUBLIC_MENU_URL` pada `.env` dengan alamat IP komputer yang menjalankan aplikasi, termasuk port yang digunakan.

## Pengembang

**Anang Abduh Majid**

Dikembangkan sebagai proyek pengembangan sistem informasi berbasis web dengan fokus pada digitalisasi dan integrasi operasional restoran.

## Repository

GitHub: https://github.com/anangabduhmajid/restoe-boemi-pos

---

© 2026 Anang Abduh Majid. All rights reserved.
