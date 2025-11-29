<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;

class Kuesioner extends Model
{
    protected $table = 'kuesioner';

    protected $fillable = [
        'judul',
        'deskripsi',
        'icon',
        'target_responden',
        'status_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
        'dibuat_oleh',
    ];

    protected $casts = [
        'target_responden' => 'array',
        'status_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Dapatkan admin yang membuat kuesioner ini.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'dibuat_oleh');
    }

    /**
     * Dapatkan pertanyaan untuk kuesioner ini.
     */
    public function pertanyaan(): HasMany
    {
        return $this->hasMany(Pertanyaan::class, 'kuesioner_id');
    }

    /**
     * Dapatkan responden unik yang menjawab pertanyaan dari kuesioner ini.
     */
    public function responden()
    {
        return Responden::whereHas('jawaban.pertanyaan', function ($query) {
            $query->where('kuesioner_id', $this->id);
        })->distinct();
    }

    /**
     * Dapatkan semua jawaban untuk kuesioner ini melalui pertanyaan.
     */
    public function jawaban(): HasManyThrough
    {
        return $this->hasManyThrough(
            Jawaban::class,
            Pertanyaan::class,
            'kuesioner_id',
            'pertanyaan_id'
        );
    }

    /**
     * Accessor: Cek apakah kuesioner aktif berdasarkan periode tanggal.
     * Status ditentukan secara dinamis tanpa perlu kolom is_manual.
     */
    public function getIsActiveAttribute(): bool
    {
        $today = today();

        // Aktif jika hari ini berada di antara tanggal_mulai dan tanggal_selesai
        return $this->tanggal_mulai <= $today && $this->tanggal_selesai >= $today;
    }

    /**
     * Accessor: Dapatkan alasan status kuesioner.
     */
    public function getStatusReasonAttribute(): string
    {
        $today = today();

        if ($today < $this->tanggal_mulai) {
            return 'Belum Dimulai';
        } elseif ($today > $this->tanggal_selesai) {
            return 'Sudah Berakhir';
        } else {
            return 'Aktif';
        }
    }

    /**
     * Scope: Filter kuesioner yang aktif berdasarkan periode tanggal.
     */
    public function scopeActive(Builder $query): Builder
    {
        $today = today();

        return $query->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today);
    }

    /**
     * Scope query untuk hanya menyertakan kuesioner dalam periode saat ini.
     */
    public function scopeCurrentPeriod(Builder $query, string $date): Builder
    {
        return $query->where('tanggal_mulai', '<=', $date)
            ->where('tanggal_selesai', '>=', $date);
    }

    /**
     * Scope query untuk mencari kuesioner.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }
}
