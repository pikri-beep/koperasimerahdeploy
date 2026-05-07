@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --primary: #e63946;
        --primary-dark: #d62839;
        --bg: #f8fafc;
    }

    .request-card {
        border-radius: 24px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        padding: 1.75rem;
        background: #ffffff;
        border-left: 6px solid #e63946;
    }

    .request-card span {
        display: block;
        color: #94a3b8;
        font-size: 0.8rem;
        margin-bottom: 0.75rem;
    }

    .request-card h3 {
        font-size: 2rem;
        margin: 0;
        color: #0f172a;
    }

    .btn-request {
        background: var(--primary);
        border: none;
        color: white;
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
    }

    .btn-request:hover {
        background: var(--primary-dark);
    }
</style>

@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    $totalRequests = $data->count();
    $pendingRequests = $data->where('status', 'pending')->count();
    $approvedRequests = $data->where('status', 'approved')->count();
    $rejectedRequests = $data->where('status', 'rejected')->count();
@endphp

<section class="py-10">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5">
            <div>
                <h1 class="h3 fw-bold">Pengajuan Modal</h1>
                <p class="text-muted mb-0">Ajukan modal baru dari halaman ini. Hanya admin yang bisa menyetujui permintaan.</p>
            </div>
            @if(!$isAdmin)
                <button class="btn-request" data-bs-toggle="modal" data-bs-target="#addModal">Ajukan Modal Baru</button>
            @endif
        </div>

        <div class="row g-4 mb-6">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="request-card" style="border-left-color: #e63946;">
                    <span>Total Pengajuan</span>
                    <h3>{{ $totalRequests }}</h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="request-card" style="border-left-color: #f59e0b;">
                    <span>Pending</span>
                    <h3>{{ $pendingRequests }}</h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="request-card" style="border-left-color: #22c55e;">
                    <span>Disetujui</span>
                    <h3>{{ $approvedRequests }}</h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="request-card" style="border-left-color: #6b7280;">
                    <span>Ditolak</span>
                    <h3>{{ $rejectedRequests }}</h3>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Daftar Pengajuan</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pokok</th>
                                <th>Wajib</th>
                                <th>Sementara</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-danger">Rp {{ number_format($item->simpanan_pokok,0,',','.') }}</td>
                                <td class="text-success">Rp {{ number_format($item->simpanan_wajib,0,',','.') }}</td>
                                <td class="text-primary">Rp {{ number_format($item->simpanan_sementara,0,',','.') }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($item->status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada pengajuan modal.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!$isAdmin)
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-sm">
            <form action="{{ route('modal.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title">Ajukan Modal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Simpanan Pokok</label>
                        <input type="number" name="simpanan_pokok" class="form-control" placeholder="Masukkan Simpanan Pokok" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Simpanan Wajib</label>
                        <input type="number" name="simpanan_wajib" class="form-control" placeholder="Masukkan Simpanan Wajib" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Simpanan Sementara</label>
                        <input type="number" name="simpanan_sementara" class="form-control" placeholder="Masukkan Simpanan Sementara" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Agar admin memahami kebutuhan modal Anda"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection