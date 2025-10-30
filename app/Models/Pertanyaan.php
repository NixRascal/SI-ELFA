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
