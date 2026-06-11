<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_sampah_id',
        'user_id',
        'tanggal',
        'debit',
        'kredit',
        'sisa_saldo',
    ];

    public function bankSampah()
    {
        return $this->belongsTo(BankSampah::class, 'bank_sampah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
