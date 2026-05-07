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

    .nav-tabs .nav-link {
        border: none;
        color: #64748b;
        padding: 0.75rem 1.5rem;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 3px solid var(--primary);
        color: var(--primary);
    }
</style>

<section class="py-10">
    <div class="container-fluid px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5">
            <div>
                <h1 class="h3 fw-bold">Kelola Modal & Simpanan</h1>
                <p class="text-muted mb-0">Kelola pengajuan modal dari user dan data simpanan yang sudah disetujui.</p>
            </div>
            <button class="btn-request" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Simpanan Manual</button>
        </div>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="modalTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab">
                    <i class="bi bi-inbox me-2"></i>Pengajuan Pending
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                    <i class="bi bi-check2-circle me-2"></i>Sudah Disetujui
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Pengajuan Pending Tab -->
            <div class="tab-pane fade show active" id="requests" role="tabpanel">
                <div class="row g-4 mb-6">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #f59e0b;">
                            <span>Pengajuan Pending</span>
                            <h3>{{ $requests->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #22c55e;">
                            <span>Total Disetujui</span>
                            <h3>{{ $requests->where('status', 'approved')->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #ef4444;">
                            <span>Total Ditolak</span>
                            <h3>{{ $requests->where('status', 'rejected')->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #8b5cf6;">
                            <span>Total Pengajuan</span>
                            <h3>{{ $requests->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Daftar Pengajuan Modal</h5>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Pokok</th>
                                        <th>Wajib</th>
                                        <th>Sementara</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $item->user ? $item->user->name : 'Unknown' }}</td>
                                        <td>{{ $item->user ? $item->user->email : '-' }}</td>
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
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</td>
                                        <td>
                                            @if($item->status === 'pending')
                                                <form action="{{ route('admin.modal.approve', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success me-2">
                                                        <i class="bi bi-check-circle"></i> Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.modal.reject', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-x-circle"></i> Tolak
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.modal.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">Tidak ada pengajuan pending.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sudah Disetujui Tab -->
            <div class="tab-pane fade" id="approved" role="tabpanel">
                <div class="row g-4 mb-6">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #e63946;">
                            <span>Total Pokok</span>
                            <h3>Rp {{ number_format($data->sum('simpanan_pokok'),0,',','.') }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #10b981;">
                            <span>Total Wajib</span>
                            <h3>Rp {{ number_format($data->sum('simpanan_wajib'),0,',','.') }}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="request-card" style="border-left-color: #3b82f6;">
                            <span>Total Sementara</span>
                            <h3>Rp {{ number_format($data->sum('simpanan_sementara'),0,',','.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Data Simpanan yang Disetujui</h5>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pokok</th>
                                        <th>Wajib</th>
                                        <th>Sementara</th>
                                        <th>Tipe</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-danger fw-bold">Rp {{ number_format($item->simpanan_pokok,0,',','.') }}</td>
                                        <td class="text-success fw-bold">Rp {{ number_format($item->simpanan_wajib,0,',','.') }}</td>
                                        <td class="text-primary fw-bold">Rp {{ number_format($item->simpanan_sementara,0,',','.') }}</td>
                                        <td>
                                            @if($item->is_request)
                                                <span class="badge bg-info">Dari User</span>
                                            @else
                                                <span class="badge bg-secondary">Manual</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.modal.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow-sm">
                                                <form action="{{ route('admin.modal.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title">Edit Simpanan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Simpanan Pokok</label>
                                                            <input type="number" class="form-control" name="simpanan_pokok" value="{{ $item->simpanan_pokok }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Simpanan Wajib</label>
                                                            <input type="number" class="form-control" name="simpanan_wajib" value="{{ $item->simpanan_wajib }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Simpanan Sementara</label>
                                                            <input type="number" class="form-control" name="simpanan_sementara" value="{{ $item->simpanan_sementara }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Belum ada data simpanan yang disetujui.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-sm">
            <form action="{{ route('admin.modal.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title">Tambah Simpanan Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Simpanan Pokok</label>
                        <input type="number" class="form-control" name="simpanan_pokok" placeholder="Masukkan jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Simpanan Wajib</label>
                        <input type="number" class="form-control" name="simpanan_wajib" placeholder="Masukkan jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Simpanan Sementara</label>
                        <input type="number" class="form-control" name="simpanan_sementara" placeholder="Masukkan jumlah" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
