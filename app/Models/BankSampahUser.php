<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankSampahUser extends Model
{
    use HasFactory;

    protected $table = 'banksampahusers';
    protected $primaryKey = 'banksampah_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'banksampah_id',
        'created_by',
        'username',
        'password',
        'nama_bank_sampah',
        'alamat',
        'kecamatan',
        'jam_operasional',
        'nomor_telepon',
        'deskripsi',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tiketSetorSampah()
    {
        return $this->hasMany(TiketSetorSampah::class, 'banksampah_id', 'banksampah_id');
    }

    public function tiketTukarPoin()
    {
        return $this->hasMany(TiketTukarPoin::class, 'banksampah_id', 'banksampah_id');
    }
}
