@extends('layouts.dashboard')

@section('content')

<style>
:root {
    --maroon-prime: #8b0000;
    --maroon-light: #b22222;
    --maroon-soft: #ffe5e5;
}

body {
    background: #f8f9fa;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ── Stat cards ── */
.stat-card {
    border-radius: 16px;
    padding: 22px 20px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .12);
    transition: transform .25s;
}

.stat-card:hover {
    transform: translateY(-4px);
}

.stat-card .stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: rgba(255, 255, 255, .2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}

.stat-card .stat-val {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
}

.stat-card .stat-lbl {
    font-size: .8rem;
    opacity: .85;
    margin-top: 2px;
}

/* ── Pinjaman accordion ── */
.pinjaman-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, .07);
    overflow: hidden;
    margin-bottom: 20px;
}

.pinjaman-header {
    padding: 18px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
    transition: background .2s;
}

.pinjaman-header:hover {
    background: #f3f4f6;
}

/* ── Cicilan table ── */
.cicilan-table th {
    background: var(--maroon-prime);
    color: #fff;
    font-size: .83rem;
}

.cicilan-table td {
    vertical-align: middle;
    font-size: .88rem;
}

/* ── Badge status ── */
.badge-belum {
    background: #fef3c7;
    color: #92400e;
}

.badge-sudah {
    background: #d1fae5;
    color: #065f46;
}

.badge-terlambat {
    background: #fee2e2;
    color: #991b1b;
}

.badge-konfirmasi {
    background: #dbeafe;
    color: #1e40af;
}

.badge-status {
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: .78rem;
}

/* ── Upload modal ── */
.preview-img {
    max-height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

/* ── Progress bar ── */
.cicilan-progress {
    height: 10px;
    border-radius: 10px;
}
</style>

<div class="container-fluid px-2 px-md-4">

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color:var(--maroon-prime)">
                <i class="bi bi-calendar-check me-2"></i>Cicilan Saya
            </h3>
            <small class="text-muted">Kelola & bayar cicilan pinjaman Anda</small>
        </div>
        <a href="{{ route('pinjaman') }}" class="btn btn-outline-danger btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Pinjaman
        </a>
    </div>

    {{-- ── ALERT ──────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
        <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ── STAT CARDS ─────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#6366f1,#8b5cf6)">
                <div class="stat-icon"><i class="bi bi-list-check"></i></div>
                <div>
                    <div class="stat-val">{{ $totalCicilan }}</div>
                    <div class="stat-lbl">Total Cicilan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#059669)">
                <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <div class="stat-val">{{ $sudahBayar }}</div>
                    <div class="stat-lbl">Sudah Bayar</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706)">
                <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
                <div>
                    <div class="stat-val">{{ $belumBayar }}</div>
                    <div class="stat-lbl">Belum Bayar</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg,#ef4444,#dc2626)">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <div class="stat-val">{{ $terlambat }}</div>
                    <div class="stat-lbl">Terlambat</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── DAFTAR PINJAMAN + CICILAN ───────────────────────── --}}
    @forelse($pinjamans as $pinjaman)
    @php
    $totalCicilanPinjaman = $pinjaman->cicilans->count();
    $selesai = $pinjaman->cicilans->whereIn('status', ['dikonfirmasi'])->count();
    $progress = $totalCicilanPinjaman > 0 ? round(($selesai / $totalCicilanPinjaman) * 100) : 0;
    @endphp

    <div class="pinjaman-card">
        {{-- Header pinjaman --}}
        <div class="pinjaman-header" data-bs-toggle="collapse" data-bs-target="#pinjaman-{{ $pinjaman->id }}"
            aria-expanded="false">
            <div>
                <div class="fw-bold text-dark">
                    <i class="bi bi-bank me-2 text-danger"></i>
                    Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                    <small class="text-muted fw-normal">({{ $pinjaman->tenor }} bulan)</small>
                </div>
                <small class="text-muted">
                    Diajukan: {{ $pinjaman->tanggal_pinjam->format('d M Y') }} &bull;
                    Tujuan: {{ $pinjaman->tujuan_pinjaman }}
                </small>
                {{-- Progress --}}
                <div class="mt-2" style="min-width:200px">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.75rem">
                        <span class="text-muted">Lunas {{ $selesai }}/{{ $totalCicilanPinjaman }}</span>
                        <span class="fw-semibold text-success">{{ $progress }}%</span>
                    </div>
                    <div class="progress cicilan-progress">
                        <div class="progress-bar bg-success" style="width:{{ $progress }}%"></div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                @if($pinjaman->status === 'lunas')
                <span class="badge bg-success rounded-pill">Lunas</span>
                @else
                <span class="badge bg-warning text-dark rounded-pill">Berjalan</span>
                @endif
                <div class="mt-1"><i class="bi bi-chevron-down text-muted"></i></div>
            </div>
        </div>

        {{-- Tabel cicilan --}}
        <div class="collapse" id="pinjaman-{{ $pinjaman->id }}">
            <div class="p-3">
                @if($pinjaman->cicilans->count() === 0)
                <div class="text-center text-muted py-4">
                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                    Jadwal cicilan belum dibuat. Hubungi admin.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table cicilan-table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">Ke-</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Pokok</th>
                                <th class="text-end">Bunga</th>
                                <th class="text-end">Denda</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjaman->cicilans as $cicilan)
                            <tr
                                class="{{ $cicilan->status === 'terlambat' ? 'table-danger' : ($cicilan->status === 'dikonfirmasi' ? 'table-success' : '') }}">
                                <td class="text-center fw-bold">{{ $cicilan->bulan_ke }}</td>
                                <td>
                                    {{ $cicilan->tanggal_jatuh_tempo->format('d M Y') }}
                                    @if($cicilan->status === 'terlambat')
                                    <br><small class="text-danger fw-semibold">⚠ Terlambat</small>
                                    @endif
                                </td>
                                <td class="text-end">Rp {{ number_format($cicilan->pokok, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($cicilan->bunga, 0, ',', '.') }}</td>
                                <td class="text-end text-danger">
                                    {{ $cicilan->denda > 0 ? 'Rp ' . number_format($cicilan->denda, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($cicilan->jumlah_cicilan + $cicilan->denda, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($cicilan->status === 'belum_bayar')
                                    <span class="badge-status badge-belum">Belum Bayar</span>
                                    @elseif($cicilan->status === 'sudah_bayar')
                                    <span class="badge-status badge-sudah">Menunggu Konfirmasi</span>
                                    @elseif($cicilan->status === 'terlambat')
                                    <span class="badge-status badge-terlambat">Terlambat</span>
                                    @elseif($cicilan->status === 'dikonfirmasi')
                                    <span class="badge-status badge-konfirmasi">✓ Dikonfirmasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(in_array($cicilan->status, ['belum_bayar', 'terlambat']))
                                    <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#modalBayar-{{ $cicilan->id }}">
                                        <i class="bi bi-upload me-1"></i>Bayar
                                    </button>
                                    @elseif($cicilan->status === 'sudah_bayar')
                                    @if($cicilan->foto_bukti)
                                    <a href="{{ asset('storage/' . $cicilan->foto_bukti) }}"
                                        data-fancybox="bukti-{{ $cicilan->id }}"
                                        class="btn btn-outline-secondary btn-sm rounded-pill">
                                        <i class="bi bi-eye me-1"></i>Lihat Bukti
                                    </a>
                                    @endif
                                    @elseif($cicilan->status === 'dikonfirmasi')
                                    <span class="text-success fw-semibold"><i class="bi bi-patch-check-fill"></i>
                                        Lunas</span>
                                    @endif

                                    {{-- Catatan dari admin --}}
                                    @if($cicilan->catatan && $cicilan->status === 'belum_bayar')
                                    <div class="mt-1">
                                        <small class="text-danger"><i class="bi bi-info-circle"></i>
                                            {{ $cicilan->catatan }}</small>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── MODAL UPLOAD BUKTI (per cicilan) ─────────────────── --}}
    @foreach($pinjaman->cicilans as $cicilan)
    @if(in_array($cicilan->status, ['belum_bayar', 'terlambat']))
    <div class="modal fade" id="modalBayar-{{ $cicilan->id }}" tabindex="-1"
        aria-labelledby="labelBayar-{{ $cicilan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0"
                    style="background: linear-gradient(135deg,var(--maroon-prime),var(--maroon-light)); border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title text-white fw-bold" id="labelBayar-{{ $cicilan->id }}">
                        <i class="bi bi-credit-card me-2"></i>Upload Bukti Bayar Cicilan Ke-{{ $cicilan->bulan_ke }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info rounded-3 py-2 mb-3" style="font-size:.85rem">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Total yang harus dibayar:</strong>
                        Rp {{ number_format($cicilan->jumlah_cicilan + $cicilan->denda, 0, ',', '.') }}
                        @if($cicilan->denda > 0)
                        <br><span class="text-danger">(termasuk denda Rp
                            {{ number_format($cicilan->denda, 0, ',', '.') }})</span>
                        @endif
                    </div>

                    <form action="{{ route('cicilan.bukti', $cicilan->id) }}" method="POST"
                        enctype="multipart/form-data" id="formBayar-{{ $cicilan->id }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Bukti Transfer / Struk</label>
                            <input type="file" name="foto_bukti" class="form-control" accept="image/*"
                                id="inputBukti-{{ $cicilan->id }}"
                                onchange="previewBukti(this, 'preview-{{ $cicilan->id }}')" required>
                            <div class="form-text">Format JPG/PNG/WEBP, maks 2MB</div>
                        </div>
                        <div class="mb-3 text-center d-none" id="previewWrap-{{ $cicilan->id }}">
                            <img id="preview-{{ $cicilan->id }}" src="#" class="preview-img" alt="Preview">
                        </div>
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold">
                            <i class="bi bi-cloud-upload me-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

    @empty
    {{-- Kosong --}}
    <div class="text-center py-5">
        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Belum ada pinjaman yang disetujui</h5>
        <p class="text-muted small">Ajukan pinjaman terlebih dahulu dan tunggu persetujuan admin.</p>
        <a href="{{ route('pinjaman.pengajuan') }}" class="btn btn-danger rounded-pill px-4">
            <i class="bi bi-plus-circle me-2"></i>Ajukan Pinjaman
        </a>
    </div>
    @endforelse

</div>

<script>
function previewBukti(input, previewId) {
    const wrap = document.getElementById('previewWrap-' + previewId.split('-').slice(1).join('-'));
    const img = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection