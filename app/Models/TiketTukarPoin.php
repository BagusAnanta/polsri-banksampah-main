<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TiketTukarPoin extends Model
{
    use HasFactory;

    protected $table = 'tikettukarpoins';
    protected $primaryKey = 'tiketpoin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tiketpoin_id',
        'tiketpoin_inc',
        'masyarakat_id',
        'banksampah_id',
        'poin',
        'qr_code_id',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if (empty($model->tiketpoin_inc)) {
                $model->tiketpoin_inc = (static::max('tiketpoin_inc') ?? 0) + 1;
            }
        });
    }

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'masyarakat_id', 'masyarakat_id');
    }

    public function bankSampahUser()
    {
        return $this->belongsTo(BankSampahUser::class, 'banksampah_id', 'banksampah_id');
    }
}
