@extends('layouts.dashboard')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pinjaman - Koperasi MP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --maroon-prime: #8b0000;
        --maroon-light: #b22222;
    }

    body {
        background: #f8f9fa;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
    width: 270px;
    background: #fff;
    min-height: 100vh;
    padding: 30px 20px;
    border-right: 1px solid #eee;
    position: sticky;
    top: 0;
}

/* WRAPPER PROFIL */
.sidebar .text-center {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* AVATAR OUTER (FIX BIAR TIDAK RUSAK) */
.avatar-outer {
    width: 140px;
    height: 140px;
    padding: 6px;
    background: linear-gradient(135deg, #8b0000, #b22222);
    border-radius: 50%;
    box-shadow: 0 12px 25px rgba(139,0,0,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
}

.avatar-outer:hover {
    transform: scale(1.05);
}

/* FOTO PROFIL (INI YANG SERING RUSAK) */
.profile-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    display: block;
}

/* NAMA & EMAIL */
.profile-details {
    text-align: center;
}

.profile-details h3 {
    font-size: 1.25rem;
    font-weight: 800;
    margin-top: 10px;
    margin-bottom: 3px;
    color: #111;
}

.profile-details small {
    color: #6b7280;
    font-size: 0.85rem;
}

/* MENU */
.menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 12px;
    color: #444;
    text-decoration: none;
    margin-bottom: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.menu a:hover {
    background: #ffe5e5;
    color: #8b0000;
    transform: translateX(6px);
}

.menu a.active {
    background: linear-gradient(135deg, #8b0000, #b22222);
    color: #fff;
    box-shadow: 0 10px 20px rgba(139,0,0,0.2);
}
    /* ================= CONTENT ================= */
    .content {
        flex: 1;
        padding: 35px 45px;
    }

    .header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1f1f1f;
        margin: 0;
    }

    .subtitle {
        color: #6b7280;
        font-size: 1.02rem;
        margin: 0;
    }

    .btn-main {
        background: linear-gradient(135deg, var(--maroon-prime), var(--maroon-light));
        color: white;
        padding: 12px 28px;
        border-radius: 9999px;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 8px 25px rgba(139, 0, 0, 0.28);
        text-decoration: none;
    }

    .loan-card {
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        margin-bottom: 22px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .loan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .loan-card.active {
        box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.15);
    }

    .card-content {
        padding: 22px 24px;
    }

    .top-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .left-side {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .profile-avatarr {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffe5e5;
    }

    .amount {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--maroon-prime);
    }

    .status-chip {
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        color: #fff;
    }

    .detail-box {
        display: none;
        padding-top: 22px;
        border-top: 1px dashed #ddd;
    }

    .loan-card.active .detail-box {
        display: block;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .detail-item {
        background: #fafafa;
        padding: 13px 16px;
        border-radius: 12px;
    }

    .detail-item small {
        color: #6b7280;
        font-size: 0.76rem;
        margin-bottom: 5px;
        display: block;
    }

    .detail-item strong {
        font-size: 0.98rem;
        color: #222;
    }

    .alamat-item {
        background: #fafafa;
        padding: 13px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .alamat-item small {
        color: #6b7280;
        font-size: 0.76rem;
        margin-bottom: 5px;
        display: block;
    }

    .foto-section {
        margin-top: 22px;
    }

    .foto-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 14px;
    }

    .foto-item img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #eee;
        cursor: pointer;
    }

    .foto-item small {
        display: block;
        margin-bottom: 7px;
        font-weight: 500;
        color: #555;
    }

    .action-buttons {
        margin-top: 28px;
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 26px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-width: 150px;
        justify-content: center;
        transition: all 0.3s;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
    }
    .btn-edit:hover {
        background: #d97706;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #dc2626;
        color: white;
    }
    .btn-delete:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }
    </style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="text-center mb-5">
            <div class="avatar-outer mx-auto">
                <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('sbadmin2/img/undraw_profile.svg') }}"
                     class="profile-avatar" alt="Foto Profil">
            </div>
            <div class="profile-details mt-3">
                <h3>{{ auth()->user()->name }}</h3>
                <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <hr>

        <div class="menu">
            <a href="{{ route('pinjaman') }}"><i class="bi bi-house-door me-2"></i> Beranda</a>
            <a href="{{ route('pinjaman.riwayat') }}" class="active"><i class="bi bi-clock-history me-2"></i> Riwayat Pengajuan</a>
            <a href="{{ route('dashboard') }}"><i class="bi bi-person-circle me-2"></i> Profil Saya</a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">

        <div class="header-box">
            <div>
                <h1 class="title">Riwayat Pinjaman</h1>
                <p class="subtitle mb-0">Semua pengajuan pinjaman yang pernah kamu ajukan</p>
            </div>
            <a href="{{ route('pinjaman.pengajuan') }}" class="btn-main">
                <i class="bi bi-plus-circle"></i> Ajukan Pinjaman Baru
            </a>
        </div>

        @forelse($pinjaman as $p)
        <div class="loan-card" onclick="toggleCard(this)">

            <div class="card-content">

                <div class="top-section">
                    <div class="left-side">
                        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('sbadmin2/img/undraw_profile.svg') }}"
                             class="profile-avatarr" alt="Foto">

                        <div>
                            <div class="meta text-muted small">{{ $p->created_at->format('d M Y H:i') }}</div>
                            <div class="name fw-bold fs-5">{{ $p->nama_lengkap }}</div>
                            <div class="tenor small text-muted">{{ $p->tenor }} bulan • Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="text-end">
                        <div class="amount">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</div>
                        @if($p->status == 'pending')
                            <span class="status-chip bg-warning">Pending</span>
                        @elseif($p->status == 'disetujui')
                            <span class="status-chip bg-success">Disetujui</span>
                        @elseif($p->status == 'ditolak')
                            <span class="status-chip bg-danger">Ditolak</span>
                        @else
                            <span class="status-chip bg-secondary">Lunas</span>
                        @endif
                    </div>
                </div>

                <!-- DETAIL SECTION -->
                <div class="detail-box">

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>NIK</small>
                            <strong>{{ $p->nik }}</strong>
                        </div>
                        <div class="detail-item">
                            <small>No HP</small>
                            <strong>{{ $p->no_hp }}</strong>
                        </div>
                        <div class="detail-item">
                            <small>Tgl Pinjam</small>
                            <strong>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</strong>
                        </div>
                        <div class="detail-item">
                            <small>Jatuh Tempo</small>
                            <strong>{{ \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->format('d M Y') }}</strong>
                        </div>
                    </div>

                    <div class="alamat-item">
                        <small>Alamat Lengkap</small>
                        <strong>{{ $p->alamat }}</strong>
                    </div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>Tujuan Pinjaman</small>
                            <strong>{{ $p->tujuan_pinjaman }}</strong>
                        </div>
                        <div class="detail-item">
                            <small>Metode Pencairan</small>
                            <strong>{{ $p->metode_pencairan }}</strong>
                        </div>
                    </div>

                    <div class="foto-section">
                        <small class="text-muted d-block mb-3">Dokumen Pendukung</small>
                        <div class="foto-grid">
                            <div class="foto-item">
                                <small>Foto KTP</small>
                                <img src="{{ asset('storage/' . $p->foto_ktp) }}"
                                     onclick="window.open(this.src, '_blank')" alt="Foto KTP">
                            </div>
                            <div class="foto-item">
                                <small>Selfie dengan KTP</small>
                                <img src="{{ asset('storage/' . $p->selfie_ktp) }}"
                                     onclick="window.open(this.src, '_blank')" alt="Selfie KTP">
                            </div>
                        </div>
                    </div>

                    @if($p->status == 'pending')
                    <div class="action-buttons">
                        <a href="{{ route('pinjaman.edit', $p->id) }}"
                           onclick="event.stopImmediatePropagation();"
                           class="btn btn-action btn-edit">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <button onclick="hapus({{ $p->id }}); event.stopImmediatePropagation();"
                                class="btn btn-action btn-delete">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </div>

                    <!-- Form Delete -->
                    <form id="form-delete-{{ $p->id }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif

                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h5 class="mt-3">Belum Ada Riwayat Pinjaman</h5>
        </div>
        @endforelse

    </div>
</div>

<script>
function toggleCard(el) {
    document.querySelectorAll('.loan-card').forEach(card => {
        if (card !== el) card.classList.remove('active');
    });
    el.classList.toggle('active');
}

function hapus(id) {
    if (confirm('Yakin ingin menghapus pengajuan pinjaman ini?\n\nData dan dokumen pendukung akan dihapus secara permanen.')) {
        let form = document.getElementById('form-delete-' + id);
        form.action = `/dashboard/pinjaman/${id}`;
        form.submit();
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection
