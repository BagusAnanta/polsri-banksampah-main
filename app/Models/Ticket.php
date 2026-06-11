<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tiket',
        'tanggal',
        'judul',
        'deskripsi',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function findUser($id)
    {
        $user = User::find($id);
        return $user ? ucfirst($user->name) . ' - ('. $user->getRoleNames()[0] .')': null;

    }

    public function uploadDoc()
    {
        return $this->hasMany(UploadDocTicket::class);
    }
    
    public function uploadDocTrouble()
    {
        return $this->hasMany(UploadDocTrouble::class);
    }
}
