<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakats';
    protected $primaryKey = 'masyarakat_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'masyarakat_id',
        'user_id',
        'nik',
        'approved_by',
        'identity_photo',
        'gender',
        'verification',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function tiketSetorSampah()
    {
        return $this->hasMany(TiketSetorSampah::class, 'masyarakat_id', 'masyarakat_id');
    }

    public function tiketTukarPoin()
    {
        return $this->hasMany(TiketTukarPoin::class, 'masyarakat_id', 'masyarakat_id');
    }
}
