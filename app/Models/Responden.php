<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Responden extends Model
{
    protected $table = 'responden';

    protected $fillable = [
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
        'waktu_pengisian' => 'datetime',
    ];

    /**
     * Get the answers for this respondent.
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'responden_id');
    }

    /**
     * Cek apakah responden sudah mengisi kuesioner tertentu
     * 
     * @param int $kuisionerId
     * @return bool
     */
    public function sudahMengisiKuesioner($kuisionerId): bool
    {
        return $this->jawaban()
            ->where('kuesioner_id', $kuisionerId)
            ->exists();
    }

    /**
     * Get daftar ID kuesioner yang sudah diisi oleh responden
     * 
     * @return array
     */
    public function kuesionerYangSudahDiisi(): array
    {
        return $this->jawaban()
            ->distinct()
            ->pluck('kuesioner_id')
            ->toArray();
    }
}
