<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function tabungans()
    {
        return $this->hasMany(Tabungan::class);
    }

    public function masyarakat()
    {
        return $this->hasOne(Masyarakat::class, 'user_id');
    }

    public function admin_banksampah()
    {
        return $this->hasOne(BankSampahUser::class, 'created_by');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function getRoleNameAttribute()
    {
        return $this->roles->first()->name ?? null;
    }
}
