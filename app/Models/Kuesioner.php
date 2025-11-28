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
     * Get the active status based on date period and manual status.
     */
    public function getIsActiveAttribute(): bool
    {
        if (!$this->status_aktif) {
            return false;
        }

        return $this->is_period_valid;
    }

    /**
     * Check if the current date is within the start and end dates.
     */
    public function getIsPeriodValidAttribute(): bool
    {
        $now = now();
        $start = \Carbon\Carbon::parse($this->tanggal_mulai)->startOfDay();
        $end = \Carbon\Carbon::parse($this->tanggal_selesai)->endOfDay();

        return $now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end);
    }

    /**
     * Scope a query to only include active questionnaires.
     */
    public function scopeActive(Builder $query): Builder
    {
        $now = now();
        return $query->where('status_aktif', true)
            ->whereDate('tanggal_mulai', '<=', $now)
            ->whereDate('tanggal_selesai', '>=', $now);
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

    /**
     * Sync the active status in the database based on the current date.
     * This ensures the status_aktif column reflects the actual period validity.
     */
    public static function syncActiveStatus(): void
    {
        $now = now();

        // Set status to false if outside of period (expired or not started)
        static::where('status_aktif', true)
            ->where(function ($query) use ($now) {
                $query->whereDate('tanggal_selesai', '<', $now)
                    ->orWhereDate('tanggal_mulai', '>', $now);
            })
            ->update(['status_aktif' => false]);

        // Set status to true if inside period (and currently false)
        // Note: This enforces "Date rules all". If manual off is desired, this overrides it.
        // Based on user request: "otomatis aktif jika masa periodenya aktif"
        static::where('status_aktif', false)
            ->whereDate('tanggal_mulai', '<=', $now)
            ->whereDate('tanggal_selesai', '>=', $now)
            ->update(['status_aktif' => true]);
    }
}
