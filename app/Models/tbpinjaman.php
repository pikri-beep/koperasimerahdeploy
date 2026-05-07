<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TbPinjaman extends Model
{
    use HasFactory;

    protected $table = 'tbpinjaman';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'no_hp',
        'alamat',
        'jumlah_pinjaman',
        'tenor',
        'tujuan_pinjaman',
        'metode_pencairan',
        'foto_ktp',
        'selfie_ktp',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status',
        'jenis_pinjaman',
        'foto_bukti'
    ];

    protected $casts = [
        'jumlah_pinjaman' => 'decimal:2',
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
