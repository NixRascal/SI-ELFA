<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'responden';

    protected $fillable = [
        'kuesioner_id',
        'nama',
        'npm',
        'email',
        'jenis_responden',
        'fakultas',
        'jurusan',
        'sesi_token',
        'waktu_pengisian'
    ];

    protected $casts = [
        'usia' => 'integer',
    ];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'responden_id');
    }
}
