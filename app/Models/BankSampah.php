<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSampah extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    public function detailJenisSampah()
    {
        return $this->hasMany(BankSampah::class, 'user_id', 'user_id')->where('status', 'pending');
    }


    public function tabungan()
    {
        return $this->hasMany(Tabungan::class, 'bank_sampah_id');
    }
}
