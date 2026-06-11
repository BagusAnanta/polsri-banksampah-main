<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'box_sampah_id',
        'user_id',
        'catatan',
    ];

    public function boxSampah()
    {
        return $this->belongsTo(BoxSampah::class, 'box_sampah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
