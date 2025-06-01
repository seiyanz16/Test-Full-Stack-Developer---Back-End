# 🧪 Test Full Stack Developer – Back End (Laravel)

Repositori ini berisi API RESTful untuk aplikasi manajemen transaksi sederhana, dibangun menggunakan **PHP (Laravel)**. API ini menyediakan autentikasi berbasis token, operasi **CRUD penuh** untuk entitas **Users** dan **Transactions**, serta pencatatan otomatis ke tabel **Logs** untuk keperluan audit.

API ini dirancang agar dapat terintegrasi dengan aplikasi frontend secara terpisah.

---

## ✅ Fitur Utama

- Manajemen Pengguna (**CRUD**)
- Manajemen Transaksi dengan **perhitungan total otomatis** (berdasarkan amount dan discount)
- Autentikasi menggunakan **Laravel Sanctum**
- Validasi data komprehensif untuk semua endpoint
- Penanganan error yang konsisten
- Logging aktivitas transaksi ke dalam tabel **logs**

---

## 💻 Persyaratan Sistem

Pastikan sistem Anda memiliki prasyarat berikut:

- PHP >= 8.2
- Composer
- MySQL (disarankan versi 5.7+)
- Web Server (Apache/Nginx) atau PHP built-in server

---

## 🧰 Instalasi

```bash
# Clone repositori
git clone https://github.com/seiyanz16/Test-Full-Stack-Developer---Back-End.git
cd Test-Full-Stack-Developer---Back-End

# Install dependensi menggunakan Composer
composer install

# Salin file .env contoh
cp .env.example .env

```

---

## ⚙️ Konfigurasi
🔐 Generate Application Key
Jalankan perintah berikut untuk menghasilkan kunci aplikasi Laravel:

```bash
php artisan key:generate
```

---

## 🗃️ Database
### 1. Konfigurasi `.env`
Edit file `.env` dan sesuaikan bagian konfigurasi database seperti berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Buat Database
Buat database secara manual di **MySQL**:

```sql
CREATE DATABASE your_database;
```

### 3. Jalankan Migrasi
Untuk membuat tabel-tabel yang dibutuhkan oleh aplikasi:

```bash
php artisan migrate
```

### 4. Instal Sanctum (Jika Belum)
Jika Anda menggunakan Laravel Sanctum, Anda mungkin perlu menjalankan:

```bash
php artisan sanctum:install
```
Dan pastikan konfigurasi terkait di config/auth.php dan config/sanctum.php sudah sesuai.

---

## 🚀 Menjalankan Aplikasi
Jalankan server local development:

```bash
php artisan serve
```
Aplikasi API akan berjalan di:
`http://127.0.0.1:8000`

---

## 📡 Struktur Endpoint API

**Dokumentasi lengkap tersedia di:**  
🔗 [Dokumentasi Postman](https://documenter.getpostman.com/view/29623755/2sB2qgeJUz)

### 🔄 Ringkasan Endpoint:

| Metode | URL                         | Deskripsi                                                                 |
|--------|-----------------------------|---------------------------------------------------------------------------|
| POST   | /api/login                  | Autentikasi dan mendapatkan token                                         |
| POST   | /api/register               | Mendaftarkan pengguna baru                                                |
| GET    | /api/users                  | Mendapatkan daftar pengguna                                               |
| POST   | /api/users                  | Membuat pengguna baru                                                     |
| GET    | /api/users/{id}             | Mendapatkan detail pengguna berdasarkan ID                                |
| PUT    | /api/users/{id}             | Memperbarui data pengguna berdasarkan ID                                  |
| DELETE | /api/users/{id}             | Menghapus pengguna berdasarkan ID                                         |
| GET    | /api/transactions           | Mendapatkan daftar transaksi                                              |
| POST   | /api/transactions           | Membuat transaksi baru (otomatis hitung total dari amount dan discount)  |
| PUT    | /api/transactions/{id}      | Memperbarui transaksi berdasarkan ID                                      |
| DELETE | /api/transactions/{id}      | Menghapus transaksi berdasarkan ID                                        |