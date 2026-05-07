<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TbModal extends Model
{
    protected $table = 'tbmodals';

    protected $fillable = [
        'user_id',
        'simpanan_pokok',
        'simpanan_wajib',
        'simpanan_sementara',
        'status',
        'is_request',
        'keterangan',
    ];

    protected $casts = [
        'is_request' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}