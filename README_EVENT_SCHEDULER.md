# MySQL Event Scheduler - Setup untuk Server Hosting

## Masalah di Shared Hosting

Migration tidak bisa mengaktifkan Event Scheduler otomatis karena memerlukan privilege `SUPER` yang biasanya tidak tersedia di shared hosting.

## Solusi: Minta Hosting Provider Aktifkan Event Scheduler

### Langkah 1: Hubungi Support Hosting

Kirim tiket support dengan pesan berikut:

```
Subject: Request to Enable MySQL Event Scheduler

Hi Support Team,

Saya memerlukan MySQL Event Scheduler untuk diaktifkan di database saya.

Database: [nama_database_anda]
Username: [username_database_anda]

Mohon jalankan command berikut:
SET GLOBAL event_scheduler = ON;

Event scheduler diperlukan untuk automatic background tasks di aplikasi saya.

Terima kasih.
```

### Langkah 2: Verifikasi Event Scheduler Aktif

Setelah support mengaktifkan, verifikasi dengan query:

```sql
SHOW VARIABLES LIKE 'event_scheduler';
```

Hasilnya harus: `event_scheduler | ON`

### Langkah 3: Jalankan Migration

Setelah Event Scheduler aktif, jalankan migration:

```bash
php artisan migrate
```

## Alternatif: Jika Event Scheduler Tidak Bisa Diaktifkan

Jika hosting provider tidak bisa/tidak mau mengaktifkan Event Scheduler, Anda punya 2 opsi:

### Opsi 1: Gunakan Cron Job (Recommended)

1. Restore Laravel Command Scheduler dari git history
2. Setup cron job di cPanel:
   ```bash
   * * * * * cd /path/to/public_html && php artisan schedule:run >> /dev/null 2>&1
   ```

### Opsi 2: Manual Trigger via Endpoint

Buat endpoint yang dipanggil oleh external cron service (seperti cron-job.org):

1. Buat route di `routes/web.php`:
   ```php
   Route::get('/cron/update-kuesioner-status', function() {
       // Update logic here
       return response()->json(['status' => 'success']);
   });
   ```

2. Setup di cron-job.org untuk hit endpoint setiap 10 detik

## Status Saat Ini

✅ Migration sudah diperbaiki untuk tidak memerlukan SUPER privilege
✅ Events akan dibuat otomatis saat migration
⚠️ Event Scheduler harus diaktifkan oleh hosting provider
⚠️ Jika tidak bisa, gunakan alternatif di atas

## Cara Cek Event Sudah Berjalan

```sql
-- Cek event scheduler status
SHOW VARIABLES LIKE 'event_scheduler';

-- Cek events yang ada
SHOW EVENTS;

-- Cek events spesifik
SHOW EVENTS WHERE Name LIKE 'update_kuesioner_status%';
```

## Troubleshooting

**Q: Event tidak berjalan meskipun sudah dibuat?**
A: Pastikan Event Scheduler aktif (`ON`). Jika `OFF`, minta hosting provider aktifkan.

**Q: Hosting tidak support Event Scheduler?**
A: Gunakan alternatif Cron Job atau external cron service.

**Q: Error "Access denied" saat migration?**
A: Normal di shared hosting. Migration tetap akan membuat events, tapi scheduler harus diaktifkan manual oleh hosting provider.
