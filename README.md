# Laravel Mahasiswa API

API untuk manajemen data mahasiswa menggunakan Laravel dengan dokumentasi OpenAPI/Swagger.

## Fitur

- CRUD Mahasiswa (Create, Read)
- Validasi Input
- Error Handling
- Dokumentasi API dengan OpenAPI/Swagger
- Database Seeder

## Endpoints

- `GET /api/mahasiswa` - Mendapatkan daftar semua mahasiswa
- `POST /api/mahasiswa` - Menambah mahasiswa baru
- `GET /api/mahasiswa/{id}` - Mendapatkan detail mahasiswa berdasarkan ID

## Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd api-project
```

2. Install dependencies
```bash
composer install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database
```bash
# Update database credentials di .env file
php artisan migrate --seed
```

5. Generate dokumentasi API
```bash
php artisan l5-swagger:generate
```

6. Jalankan server
```bash
php artisan serve
```

## Struktur Data

### Mahasiswa

- `id` (integer) - ID mahasiswa
- `nama` (string) - Nama mahasiswa
- `nim` (string) - Nomor Induk Mahasiswa
- `email` (string) - Email mahasiswa
- `jurusan` (string) - Jurusan mahasiswa

## Dokumentasi API

Akses dokumentasi API Swagger di: `/api/documentation`

## Validasi

### Create Mahasiswa
- nama: Required, string, max 255 chars
- nim: Required, unique, string, max 20 chars
- email: Required, unique, valid email, max 255 chars
- jurusan: Required, string, max 255 chars

## Error Handling

- 400 Bad Request - Invalid input data
- 404 Not Found - Resource tidak ditemukan
