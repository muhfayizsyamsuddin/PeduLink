# PeduLink — Donation Platform

PeduLink adalah aplikasi donasi berbasis web yang menghubungkan donatur dengan kampanye penggalangan dana. Aplikasi ini menyediakan pengelolaan kampanye, pencatatan donasi, dan integrasi pembayaran melalui Xendit.

Proyek ini dikembangkan sebagai proyek pembelajaran **API Integration** menggunakan Laravel.

## Features

- **Campaign Management** — Membuat, melihat, memperbarui, dan menghapus kampanye.
- **Donation Flow** — Formulir donasi dengan informasi donatur, nominal, pesan, dan opsi anonim.
- **Xendit Payment Integration** — Membuat invoice pembayaran dan mengarahkan donatur ke halaman checkout.
- **Payment Verification** — Memverifikasi status pembayaran melalui Xendit API.
- **Webhook Integration** — Memproses notifikasi pembayaran secara otomatis, termasuk status `PAID`, `SETTLED`, dan `EXPIRED`.
- **Donation Progress** — Menampilkan total donasi lunas, jumlah transaksi lunas, dan persentase pencapaian target kampanye.
- **Admin Authentication** — Autentikasi API menggunakan Laravel Sanctum dan pembatasan akses berdasarkan role admin.
- **Donor Management** — Mengelola data donatur melalui endpoint yang dilindungi autentikasi admin.
- **Automated Testing** — Pengujian fitur autentikasi, akses admin, visibilitas kampanye, dan webhook pembayaran.

## Tech Stack

- **Backend:** PHP, Laravel 12
- **Database:** MySQL
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Build Tool:** Vite
- **Authentication:** Laravel Sanctum
- **Payment Gateway:** Xendit Invoice API
- **Testing:** PHPUnit / Laravel test runner

## Requirements

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau lebih baru
- Composer
- MySQL atau MariaDB
- Node.js dan npm
- Git

## Payment Flow

1. Donatur memilih kampanye aktif.
2. Donatur mengisi formulir dan nominal donasi.
3. PeduLink membuat record donasi dengan status awal `pending`.
4. Backend membuat invoice melalui Xendit Invoice API.
5. Donatur diarahkan ke halaman checkout Xendit.
6. Xendit mengirim notifikasi pembayaran ke endpoint webhook PeduLink.
7. Backend memvalidasi callback dan memperbarui status donasi.
8. Halaman hasil donasi memverifikasi status invoice melalui Xendit API.

Hanya donasi dengan status `paid` yang dihitung dalam progres dana kampanye.

## Repository

GitHub: [muhfayizsyamsuddin/PeduLink](https://github.com/muhfayizsyamsuddin/PeduLink)
