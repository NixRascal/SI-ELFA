<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';

    protected $fillable = [
        'kuesioner_id',
        'teks_pertanyaan',
        'jenis_pertanyaan',
        'opsi_jawaban',
        'urutan',
        'wajib_diisi',
        'kategori',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'wajib_diisi' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Dapatkan atribut opsi_jawaban.
     * Tangani JSON yang diformat dengan benar dan JSON yang di-encode ganda.
     */
    public function getOpsiJawabanAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        // Jika sudah berupa array (dari cache atau setelah mutator), kembalikan
        if (is_array($value)) {
            return $value;
        }

        // Coba decode sekali
        $decoded = json_decode($value, true);

        // Jika decode gagal atau hasilnya string, coba double-decode (untuk data lama)
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return $decoded;
    }

    /**
     * Set atribut opsi_jawaban.
     * Pastikan kita selalu menyimpan JSON yang diformat dengan benar.
     */
    public function setOpsiJawabanAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['opsi_jawaban'] = null;
            return;
        }

        // Jika sudah berupa string JSON, decode dulu untuk menghindari double encoding
        if (is_string($value)) {
            $value = json_decode($value, true) ?? $value;
        }

        // Sekarang encode dengan benar
        $this->attributes['opsi_jawaban'] = json_encode($value);
    }

    /**
     * Dapatkan kuesioner yang memiliki pertanyaan ini.
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }

    /**
     * Dapatkan jawaban untuk pertanyaan ini.
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'pertanyaan_id');
    }
}
