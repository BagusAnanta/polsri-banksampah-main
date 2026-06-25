<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TiketSetorSampah extends Model
{
    use HasFactory;

    protected $table = 'tiketsetorsampahs';
    protected $primaryKey = 'tiketsampah_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tiketsampah_id',
        'tiketsampah_inc',
        'masyarakat_id',
        'banksampah_id',
        'berat_sampah',
        'berat_sampah_actual',
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
            if (empty($model->tiketsampah_inc)) {
                $model->tiketsampah_inc = (static::max('tiketsampah_inc') ?? 0) + 1;
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
