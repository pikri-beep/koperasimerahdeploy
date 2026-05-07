<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TbModal;

class TbmodalController extends Controller
{
    public function index()
    {
        $data = TbModal::where('status', 'approved')->latest()->get();
        $requests = TbModal::where('is_request', true)->latest()->get();

        return view('admin.modal', compact('data', 'requests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
            'simpanan_sementara' => 'required|numeric|min:0',
        ]);

        TbModal::create(array_merge($validated, [
            'status' => 'approved',
            'is_request' => false,
        ]));

        return redirect()->route('admin.modal')->with('success', 'Data berhasil ditambahkan!');
    }

    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
            'simpanan_sementara' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        TbModal::create([
            'user_id' => auth()->id(),
            'simpanan_pokok' => $validated['simpanan_pokok'],
            'simpanan_wajib' => $validated['simpanan_wajib'],
            'simpanan_sementara' => $validated['simpanan_sementara'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'pending',
            'is_request' => true,
        ]);

        return redirect()->route('modal')->with('success', 'Pengajuan modal berhasil dikirim. Tunggu persetujuan admin.');
    }

    public function update(Request $request, $id)
    {
        $data = TbModal::findOrFail($id);

        $validated = $request->validate([
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
            'simpanan_sementara' => 'required|numeric|min:0',
        ]);

        $data->update($validated);

        return redirect()->route('admin.modal')->with('success', 'Data berhasil diupdate!');
    }

    public function approve($id)
    {
        $data = TbModal::findOrFail($id);
        $data->update(['status' => 'approved']);

        return redirect()->route('admin.modal')->with('success', 'Pengajuan modal disetujui.');
    }

    public function reject($id)
    {
        $data = TbModal::findOrFail($id);
        $data->update(['status' => 'rejected']);

        return redirect()->route('admin.modal')->with('success', 'Pengajuan modal ditolak.');
    }

    public function destroy($id)
    {
        TbModal::findOrFail($id)->delete();

        return redirect()->route('admin.modal')->with('success', 'Data berhasil dihapus!');
    }
}