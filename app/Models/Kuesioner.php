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
        'is_manual',
        'tanggal_mulai',
        'tanggal_selesai',
        'dibuat_oleh',
    ];

    protected $casts = [
        'target_responden' => 'array',
        'status_aktif' => 'boolean',
        'is_manual' => 'boolean',
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
     * Dapatkan status aktif berdasarkan periode tanggal dan status manual.
     */
    public function getIsActiveAttribute(): bool
    {
        if (!$this->status_aktif) {
            return false;
        }

        return $this->is_period_valid;
    }

    /**
     * Cek apakah tanggal saat ini berada dalam tanggal mulai dan selesai.
     */
    public function getIsPeriodValidAttribute(): bool
    {
        $now = now();
        $start = \Carbon\Carbon::parse($this->tanggal_mulai)->startOfDay();
        $end = \Carbon\Carbon::parse($this->tanggal_selesai)->endOfDay();

        return $now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end);
    }

    /**
     * Scope query untuk hanya menyertakan kuesioner aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        $now = now();
        return $query->where('status_aktif', true)
            ->whereDate('tanggal_mulai', '<=', $now)
            ->whereDate('tanggal_selesai', '>=', $now);
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
