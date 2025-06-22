<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalTayang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'film_id',
        'studio_id',
        'tanggal',
        'jam',
        'jumlah_tiket', // Ini adalah kolom baru yang kita tambahkan
    ];

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class);
    }
}