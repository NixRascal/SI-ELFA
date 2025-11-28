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
     * Get the opsi_jawaban attribute.
     * Handle both correctly formatted JSON and double-encoded JSON.
     */
    public function getOpsiJawabanAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }

        // If it's already an array (from cache or after mutator), return it
        if (is_array($value)) {
            return $value;
        }

        // Try to decode once
        $decoded = json_decode($value, true);

        // If decode failed or result is a string, try double-decode (for legacy data)
        if (is_string($decoded)) {
            $decoded = json_decode($decoded, true);
        }

        return $decoded;
    }

    /**
     * Set the opsi_jawaban attribute.
     * Ensure we always store properly formatted JSON.
     */
    public function setOpsiJawabanAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['opsi_jawaban'] = null;
            return;
        }

        // If it's already a JSON string, decode it first to avoid double encoding
        if (is_string($value)) {
            $value = json_decode($value, true) ?? $value;
        }

        // Now encode it properly
        $this->attributes['opsi_jawaban'] = json_encode($value);
    }

    /**
     * Get the questionnaire that owns this question.
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }

    /**
     * Get the answers for this question.
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'pertanyaan_id');
    }
}
