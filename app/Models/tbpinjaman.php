<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tbcicilan;

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
        'foto_bukti',
    ];

    protected $casts = [
        'jumlah_pinjaman'     => 'decimal:2',
        'tanggal_pinjam'      => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cicilans()
    {
        return $this->hasMany(Tbcicilan::class, 'pinjaman_id')->orderBy('bulan_ke');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: Generate jadwal cicilan otomatis
    | Dipanggil saat admin menyetujui pinjaman
    |--------------------------------------------------------------------------
    */

    /**
     * Buat jadwal cicilan bulanan (flat 2% per bulan dari pokok).
     * Tidak akan membuat duplikat jika sudah pernah dipanggil.
     */
    public function generateCicilan(): void
    {
        // Jangan buat ulang jika sudah ada
        if ($this->cicilans()->count() > 0) {
            return;
        }

        $tenor    = (int) $this->tenor;
        $pokok    = (float) $this->jumlah_pinjaman / $tenor;
        $bunga    = (float) $this->jumlah_pinjaman * 0.02;   // 2% flat dari total pinjaman
        $cicilan  = $pokok + $bunga;
        $mulai    = $this->tanggal_pinjam ?? now();

        for ($i = 1; $i <= $tenor; $i++) {
            Tbcicilan::create([
                'pinjaman_id'         => $this->id,
                'user_id'             => $this->user_id,
                'bulan_ke'            => $i,
                'pokok'               => round($pokok, 2),
                'bunga'               => round($bunga, 2),
                'jumlah_cicilan'      => round($cicilan, 2),
                'denda'               => 0,
                'tanggal_jatuh_tempo' => $mulai->copy()->addMonths($i),
                'status'              => 'belum_bayar',
            ]);
        }
    }
}