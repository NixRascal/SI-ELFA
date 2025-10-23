<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';

    protected $fillable = [
        'kuesioner_id',
        'teks_pertanyaan',
        'tipe_pertanyaan',
        'opsi_jawaban',
        'wajib_diisi',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'wajib_diisi' => 'boolean',
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'pertanyaan_id');
    }
}
