# Kembara — Local Partners (Fase 6)

Halaman landing "Tumbuh Bersama Kembara Local Partners" + form pengajuan
kemitraan UMKM. **Bisa diakses tanpa login** (publik), karena UMKM yang
mau daftar belum tentu punya akun Kembara.

## ⚠️ Belum ada dashboard admin
Data pengajuan tersimpan rapi di tabel `partner_applications` (status
`pending`), tapi **belum ada halaman untuk admin meninjau/menyetujuinya**.
Untuk sekarang, cek data lewat:
```powershell
php artisan tinker
```
```php
\App\Models\PartnerApplication::latest()->get();
```
Atau pakai DB client seperti HeidiSQL/TablePlus/phpMyAdmin kalau pakai MySQL,
atau buka `database/database.sqlite` kalau pakai SQLite.

Membangun dashboard admin sungguhan (approve/reject, lihat semua pengajuan)
adalah pengembangan terpisah — dulu sempat disinggung Filament cocok untuk
ini kalau mau dikerjakan nanti.

## 1. Salin file
```powershell
robocopy app       kembara\app       /E
robocopy database  kembara\database  /E
robocopy resources kembara\resources /E
```
Ini menimpa `navbar.blade.php`. Menambah baru: `LocalPartnerController.php`,
`PartnerApplication.php`, 2 view, migration.

## 2. Tambah route (TIDAK perlu di dalam blok `auth`, karena halaman ini publik)
Di `routes/web.php`, tambahkan di luar blok `Route::middleware('auth')`:
```php
use App\Http\Controllers\LocalPartnerController;

Route::get('/local-partners', [LocalPartnerController::class, 'index'])->name('local-partners.index');
Route::get('/local-partners/form', [LocalPartnerController::class, 'form'])->name('local-partners.form');
Route::post('/local-partners/form', [LocalPartnerController::class, 'store'])->name('local-partners.store');
```

## 3. Migrasi
```powershell
php artisan migrate
```

## 4. Cek
1. Buka `/local-partners` **dalam keadaan logout** → halaman harus tetap
   bisa diakses (tidak diarahkan ke login).
2. Klik "Ajukan Kerja Sama Sekarang" atau "Mulai Pengisian Form" → masuk
   ke form dengan 9 kolom sesuai yang kamu minta.
3. Coba submit form kosong → muncul pesan error validasi di tiap kolom
   yang wajib diisi (semua wajib kecuali "Instagram/Website/Link Bisnis").
4. Isi lengkap, submit → redirect ke halaman landing dengan pesan sukses
   hijau di atas.
5. Cek datanya masuk lewat `php artisan tinker` seperti di atas.
