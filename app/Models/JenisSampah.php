<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JenisSampah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getQtyAttribute($jenis_sampah_id, $user_id)
    {
        $query = BankSampah::where('jenis_sampah_id', $jenis_sampah_id)
            ->where('user_id', $user_id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        return $query ? $query->qty : 0;
    }

}
