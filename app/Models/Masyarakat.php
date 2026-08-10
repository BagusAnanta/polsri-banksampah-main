<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
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
        'nik_hash',
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

    /*
    This method name is accessor method, this method uniq because we can call this method without fullname and using attribute name 

    this method content :
    - get = accessor method flag
    - DecryptNik = attribute name, this method will be called when we call $model->decrypted_nik (see reference at v2/user/masyarakat/masyarakat-profile.blade.php for example in frontend used) or $model->decrypted_nik in controller (masyarakat controller reference)
    - Attribute = accessor method flag
    */
    public function getDecryptedNikAttribute()
    {
        if (empty($this->nik)) {
            return null;
        }

        try {
            return Crypt::decryptString($this->nik);
        } catch (\Throwable $e) {
            return $this->nik;
        }
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
