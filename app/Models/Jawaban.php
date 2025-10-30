<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    protected $fillable = [
        'responden_id',
        'kuesioner_id',
        'pertanyaan_id',
        'isi_jawaban',
        'nilai_likert',
    ];

    protected $casts = [
        'nilai_likert' => 'integer',
    ];

    /**
     * Get the question that owns this answer.
     */
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    /**
     * Get the respondent that owns this answer.
     */
    public function responden(): BelongsTo
    {
        return $this->belongsTo(Responden::class, 'responden_id');
    }

    /**
     * Get the questionnaire that owns this answer.
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }
}
