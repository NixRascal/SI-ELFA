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
        'status_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Get the admin who created this questionnaire.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'dibuat_oleh');
    }

    /**
     * Get the questions for this questionnaire.
     */
    public function pertanyaan(): HasMany
    {
        return $this->hasMany(Pertanyaan::class, 'kuesioner_id');
    }

    /**
     * Get unique respondents who answered questions from this questionnaire.
     */
    public function responden()
    {
        return Responden::whereHas('jawaban.pertanyaan', function ($query) {
            $query->where('kuesioner_id', $this->id);
        })->distinct();
    }

    /**
     * Get all answers for this questionnaire through questions.
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
     * Scope a query to only include active questionnaires.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status_aktif', true);
    }

    /**
     * Scope a query to only include questionnaires in current period.
     */
    public function scopeCurrentPeriod(Builder $query, string $date): Builder
    {
        return $query->where('tanggal_mulai', '<=', $date)
                    ->where('tanggal_selesai', '>=', $date);
    }

    /**
     * Scope a query to search questionnaires.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }
}
