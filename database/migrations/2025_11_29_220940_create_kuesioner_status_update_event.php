<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop event jika sudah ada
        DB::statement('DROP EVENT IF EXISTS update_kuesioner_status_deactivate');
        DB::statement('DROP EVENT IF EXISTS update_kuesioner_status_activate');

        // Buat event untuk matikan kuesioner yang expired
        DB::unprepared("
            CREATE EVENT update_kuesioner_status_deactivate
            ON SCHEDULE EVERY 10 SECOND
            STARTS CURRENT_TIMESTAMP
            DO
                UPDATE kuesioner
                SET status_aktif = 0
                WHERE status_aktif = 1
                AND (
                    DATE(tanggal_selesai) < CURDATE()
                    OR DATE(tanggal_mulai) > CURDATE()
                )
        ");

        // Buat event untuk nyalakan kuesioner auto yang dalam periode
        DB::unprepared("
            CREATE EVENT update_kuesioner_status_activate
            ON SCHEDULE EVERY 10 SECOND
            STARTS CURRENT_TIMESTAMP
            DO
                UPDATE kuesioner
                SET status_aktif = 1
                WHERE is_manual = 0
                AND status_aktif = 0
                AND DATE(tanggal_mulai) <= CURDATE()
                AND DATE(tanggal_selesai) >= CURDATE()
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP EVENT IF EXISTS update_kuesioner_status_deactivate');
        DB::unprepared('DROP EVENT IF EXISTS update_kuesioner_status_activate');
    }
};
