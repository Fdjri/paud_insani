# PAUD Insani Management

Ini adalah proyek sistem informasi berbasis web yang dibangun untuk PAUD Insani. Aplikasi ini bertujuan untuk membantu pengelolaan data dan informasi di sekolah.

## 📜 Tentang Proyek

Proyek ini dikembangkan sebagai sistem informasi untuk mengelola berbagai aspek administrasi dan akademik di PAUD Insani. Dibangun menggunakan framework Laravel, aplikasi ini menyediakan fondasi yang kuat untuk pengembangan lebih lanjut.

## ✨ Fitur Utama

- Manajemen Data Siswa

- Manajemen Data Guru

- Manajemen Keuangan

- Pengelolaan Kelas & Absensi

- Sistem Informasi Akademik

## 🛠️ Teknologi yang Digunakan
Proyek ini dibangun dengan menggunakan teknologi modern, antara lain:

Backend: PHP dengan Laravel Framework

Frontend: Blade, Tailwind CSS, Vite

Database: (Sebutkan database yang Anda gunakan, misal: MySQL, PostgreSQL)

Dependency Manager: Composer & NPM

## 🚀 Panduan Instalasi
Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

### Prasyarat
Pastikan Anda sudah menginstal perangkat lunak berikut di komputer Anda:

PHP (versi 8.1 atau lebih baru direkomendasikan)

Composer

Node.js & NPM

Web Server server bawaan Laravel

Database (misal: MySQL, MariaDB)

### Langkah-langkah Instalasi
#### 1. Clone repositori ini:
``` 
git clone https://github.com/Fdjri/paud_insani.git
cd paud_insani
```
#### 2. Instal dependensi PHP menggunakan Composer:
```
composer install
```
#### 3. Salin file .env.example menjadi .env:
```
cp .env.example .env
```
#### 4. Buat kunci aplikasi (Application Key):
```
php artisan key:generate
```
#### 5. Konfigurasi database Anda:
Buka file .env dan sesuaikan pengaturan database sesuai dengan konfigurasi lokal Anda.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=user_database_anda
DB_PASSWORD=password_anda
```
#### 6. Jalankan migrasi database:
Perintah ini akan membuat semua tabel yang diperlukan di database Anda.
```
php artisan migrate
```
_Opsional: Jika Anda memiliki seeder, jalankan juga perintah php artisan db:seed._

#### 7. Instal dependensi frontend menggunakan NPM:
```
npm install
```
#### 8. Jalankan Vite untuk kompilasi aset frontend:
Untuk lingkungan pengembangan:
```
npm run dev
```
Untuk production:
```
npm run build
```
#### 9. Jalankan server pengembangan Laravel:
```
php artisan serve
```
Aplikasi Anda sekarang akan berjalan di 
```
http://127.0.0.1:8000.
