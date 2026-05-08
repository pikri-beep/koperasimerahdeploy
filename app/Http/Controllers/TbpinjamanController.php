<?php

namespace App\Http\Controllers;

use App\Models\TbPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TbpinjamanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $stats = TbPinjaman::where('user_id', Auth::id())
            ->selectRaw("
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN status = 'disetujui' THEN 1 END) as disetujui,
                COUNT(CASE WHEN status = 'ditolak' THEN 1 END) as ditolak
            ")
            ->first();

        return view('dashboard.pinjaman', [
            'total'     => $stats->total ?? 0,
            'pending'   => $stats->pending ?? 0,
            'disetujui' => $stats->disetujui ?? 0,
            'ditolak'   => $stats->ditolak ?? 0,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | USER & ADMIN LIST
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        // ADMIN
        if (request()->is('admin*')) {

            $search = request('search');

            $pinjaman = TbPinjaman::when($search, function ($q, $search) {
                    $q->where('nama_lengkap', 'like', "%$search%")
                      ->orWhere('nik', 'like', "%$search%")
                      ->orWhere('tujuan_pinjaman', 'like', "%$search%");
                })
                ->orderBy('tanggal_pinjam', 'desc')
                ->paginate(12)
                ->withQueryString();

            return view('admin.pinjaman', [
                'pinjaman'        => $pinjaman,
                'totalPinjaman'   => TbPinjaman::count(),
                'totalPending'    => TbPinjaman::where('status', 'pending')->count(),
                'totalApproved'   => TbPinjaman::where('status', 'disetujui')->count(),
                'totalLunas'      => TbPinjaman::where('status', 'lunas')->count(),
            ]);
        }

        // USER
        $pinjaman = TbPinjaman::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pinjaman.riwayat', compact('pinjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('pinjaman.pengajuan');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nik'              => 'required|string|size:16',
            'no_hp'            => 'required|string|max:15',
            'alamat'           => 'required|string',
            'jumlah_pinjaman'  => 'required|numeric|min:50000',
            'tenor'            => 'required|integer|min:1|max:60',
            'tujuan_pinjaman'  => 'required|string',
            'metode_pencairan' => 'required|in:transfer,tunai,e-wallet',
            'foto_ktp'         => 'required|image|max:2048',
            'selfie_ktp'       => 'required|image|max:2048',
        ]);

        $tenor = (int) $validated['tenor'];

        TbPinjaman::create([
            'user_id'             => Auth::id(),
            'nama_lengkap'        => $validated['nama_lengkap'],
            'nik'                 => $validated['nik'],
            'no_hp'               => $validated['no_hp'],
            'alamat'              => $validated['alamat'],
            'jumlah_pinjaman'     => $validated['jumlah_pinjaman'],
            'tenor'               => $tenor,
            'tujuan_pinjaman'     => $validated['tujuan_pinjaman'],
            'metode_pencairan'    => $validated['metode_pencairan'],
            'foto_ktp'            => $request->file('foto_ktp')->store('ktp/foto', 'public'),
            'selfie_ktp'          => $request->file('selfie_ktp')->store('ktp/selfie', 'public'),
            'tanggal_pinjam'      => now(),
            'tanggal_jatuh_tempo' => now()->addMonths($tenor),
            'status'              => 'pending',
        ]);

        return redirect()->route('pinjaman.riwayat')
            ->with('success', 'Pengajuan berhasil dikirim');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $pinjaman = TbPinjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pinjaman.edit', compact('pinjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (🔥 SUDAH FIX FOTO)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $pinjaman = TbPinjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nik'              => 'required|string|size:16',
            'no_hp'            => 'required|string|max:15',
            'alamat'           => 'required|string',
            'jumlah_pinjaman'  => 'required|numeric|min:50000',
            'tenor'            => 'required|integer|min:1|max:60',
            'tujuan_pinjaman'  => 'required|string',
            'metode_pencairan' => 'required|in:transfer,tunai,e-wallet',
            'foto_ktp'         => 'nullable|image|max:2048',
            'selfie_ktp'       => 'nullable|image|max:2048',
        ]);

        $tenor = (int) $validated['tenor'];

        // FOTO KTP
        if ($request->hasFile('foto_ktp')) {

            if ($pinjaman->foto_ktp && Storage::disk('public')->exists($pinjaman->foto_ktp)) {
                Storage::disk('public')->delete($pinjaman->foto_ktp);
            }

            $validated['foto_ktp'] = $request->file('foto_ktp')
                ->store('ktp/foto', 'public');
        }

        // SELFIE
        if ($request->hasFile('selfie_ktp')) {

            if ($pinjaman->selfie_ktp && Storage::disk('public')->exists($pinjaman->selfie_ktp)) {
                Storage::disk('public')->delete($pinjaman->selfie_ktp);
            }

            $validated['selfie_ktp'] = $request->file('selfie_ktp')
                ->store('ktp/selfie', 'public');
        }

        $pinjaman->update([
            'nama_lengkap'        => $validated['nama_lengkap'],
            'nik'                 => $validated['nik'],
            'no_hp'               => $validated['no_hp'],
            'alamat'              => $validated['alamat'],
            'jumlah_pinjaman'     => $validated['jumlah_pinjaman'],
            'tenor'               => $tenor,
            'tujuan_pinjaman'     => $validated['tujuan_pinjaman'],
            'metode_pencairan'    => $validated['metode_pencairan'],
            'tanggal_jatuh_tempo' => now()->addMonths($tenor),

            'foto_ktp'   => $validated['foto_ktp']   ?? $pinjaman->foto_ktp,
            'selfie_ktp' => $validated['selfie_ktp'] ?? $pinjaman->selfie_ktp,
        ]);

        return redirect()->route('pinjaman.riwayat')
            ->with('success', 'Data berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $pinjaman = TbPinjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // hapus file
        if ($pinjaman->foto_ktp) {
            Storage::disk('public')->delete($pinjaman->foto_ktp);
        }

        if ($pinjaman->selfie_ktp) {
            Storage::disk('public')->delete($pinjaman->selfie_ktp);
        }

        $pinjaman->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN ACTION
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
       $pinjaman = TbPinjaman::findOrFail($id);
       $pinjaman->update(['status' => 'disetujui']);
       $pinjaman->generateCicilan();

        return back()->with('status', 'Pinjaman disetujui');
    }

    public function deny($id)
    {
        TbPinjaman::findOrFail($id)
            ->update(['status' => 'ditolak']);

        return back()->with('status', 'Pinjaman ditolak');
    }
}