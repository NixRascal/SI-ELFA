<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'dibuat_oleh');
    }

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'kuesioner_id');
    }

    public function responden()
    {
        return $this->hasMany(Responden::class, 'kuesioner_id');
    }

    public function jawaban()
    {
        return $this->hasManyThrough(Jawaban::class, Responden::class, 'kuesioner_id', 'responden_id');
    }
}
