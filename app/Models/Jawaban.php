<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    protected $fillable = [
        'responden_id',
        'pertanyaan_id',
        'isi_jawaban',
        'nilai_likert',
    ];

    protected $casts = [
        'nilai_likert' => 'integer',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function responden()
    {
        return $this->belongsTo(Responden::class, 'responden_id');
    }
    
}
