<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pinjaman - KOPERASI MP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .navbar .nav-link {
            color: #f8f9fa;
            transition: all 0.3s;
        }
        .navbar .nav-link:hover {
            color: #dc3545;
            transform: translateY(-2px);
        }

        .sidebar {
            width: 260px;
            height: calc(100vh - 60px);
            position: fixed;
            top: 60px;
            left: 0;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 25px 20px;
            overflow-y: auto;
        }

        .sidebar-logo img {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .nav-link {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: #f3f4f6;
            color: #4f46e5;
            transform: translateX(8px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: #4f46e5;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
        }

        .main {
            margin-left: 270px;
            margin-top: 80px;
            padding: 30px;
        }

        .hero {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.25);
        }

        .dashboard-card {
            background: white;
            border-radius: 20px;
            padding: 28px 24px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }

        .dashboard-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            height: 6px;
            width: 100%;
        }

        .card-total::before { background: linear-gradient(to right, #0d6efd, #3b82f6); }
        .card-pending::before { background: linear-gradient(to right, #ffc107, #fbbf24); }
        .card-approved::before { background: linear-gradient(to right, #198754, #22c55e); }
        .card-rejected::before { background: linear-gradient(to right, #dc3545, #ef4444); }

        .dashboard-icon {
            font-size: 2.8rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .dashboard-value {
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .foto-profil {
            width: 170px;
            height: 170px;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .foto-ktp {
            width: 100%;
            max-height: 200px;
            object-fit: contain;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
        }

        .foto-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin: 25px 0;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-university me-2 fs-4"></i>KOPERASI MP
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.cicilan') }}">Cicilan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.modal') }}">Modal</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.penarikan') }}">Penarikan</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.pinjaman') }}">Pinjaman</a></li>
                <li class="nav-item d-none d-lg-block mx-2 text-secondary">|</li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm px-4 rounded-pill fw-bold">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5 class="text-center fw-bold text-indigo mb-4">Menu Utama</h5>

    <div class="nav flex-column nav-pills">
        <button class="nav-link active" id="btn-beranda" data-bs-toggle="tab" data-bs-target="#beranda">
            🏠 Beranda
        </button>
        <button class="nav-link" id="btn-pengajuan" data-bs-toggle="tab" data-bs-target="#pengajuan">
            📄 Pengajuan
        </button>
        <button class="nav-link" id="btn-riwayat" data-bs-toggle="tab" data-bs-target="#riwayat">
            📊 Riwayat
        </button>
        <button class="nav-link" id="btn-profil" data-bs-toggle="tab" data-bs-target="#profil">
            👤 Profil
        </button>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="tab-content">

        {{-- BERANDA --}}
        <div class="tab-pane fade show active" id="beranda">
            <div class="hero mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Selamat Datang, {{ auth()->user()->name }}</h4>
                        <p class="opacity-75 mb-4">Kelola pinjaman koperasi dengan cepat dan aman</p>
                        <button class="btn btn-light btn-lg px-4 rounded-pill fw-semibold" id="lihat-pengajuan-btn">
                            Lihat Daftar Pengajuan
                        </button>
                    </div>
                    <div class="text-end">
                        <h1 class="display-4 fw-bold mb-0">{{ $totalPinjaman }}</h1>
                        <p class="mb-0 opacity-75">Total Pengajuan</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="dashboard-card card-total h-100">
                        <div class="dashboard-icon text-primary">📁</div>
                        <div class="dashboard-title">Total Pengajuan</div>
                        <div class="dashboard-value">{{ $totalPinjaman }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card card-pending h-100">
                        <div class="dashboard-icon text-warning">⏳</div>
                        <div class="dashboard-title">Pending</div>
                        <div class="dashboard-value">{{ $totalPending }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card card-approved h-100">
                        <div class="dashboard-icon text-success">✅</div>
                        <div class="dashboard-title">Disetujui</div>
                        <div class="dashboard-value">{{ $totalApproved }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card card-rejected h-100">
                        <div class="dashboard-icon text-danger">❌</div>
                        <div class="dashboard-title">Ditolak</div>
                        <div class="dashboard-value">{{ $totalLunas }}</div>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>
                <div class="activity">
                    @forelse($pinjaman->take(3) as $item)
                        @if($item->status == 'pending')
                            <p>📥 {{ $item->nama_lengkap }} mengajukan pinjaman Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</p>
                        @elseif($item->status == 'disetujui')
                            <p>✅ {{ $item->nama_lengkap }} pinjaman telah disetujui</p>
                        @elseif($item->status == 'ditolak')
                            <p>❌ {{ $item->nama_lengkap }} pinjaman ditolak</p>
                        @endif
                    @empty
                        <p>Tidak ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- PENGAJUAN --}}
        <div class="tab-pane fade" id="pengajuan">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Daftar Pengajuan Pinjaman</h5>
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Kontak</th>
                            <th>Pinjaman</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjaman as $item)
                            @php
                                $badgeClass = 'secondary';
                                if ($item->status === 'pending') $badgeClass = 'warning';
                                if ($item->status === 'disetujui') $badgeClass = 'success';
                                if ($item->status === 'ditolak') $badgeClass = 'danger';
                                if ($item->status === 'lunas') $badgeClass = 'info';
                            @endphp
                            <tr>
                                <td><b>{{ $item->nama_lengkap }}</b><br><small class="text-muted">{{ $item->alamat }}</small></td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}<br><small class="text-muted">{{ $item->tenor }} bulan</small></td>
                                <td><span class="badge bg-{{ $badgeClass }} text-uppercase">{{ $item->status }}</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">Detail</button>
                                    @if($item->status == 'pending')
                                        <form action="{{ route('admin.pinjaman.approve', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                        </form>
                                        <form action="{{ route('admin.pinjaman.deny', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-5">Tidak ada data pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- RIWAYAT --}}
        <div class="tab-pane fade" id="riwayat">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Riwayat Peminjaman Selesai</h5>
                <p class="text-muted mb-4">Daftar pengguna yang telah menyelesaikan peminjaman (lunas).</p>
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tenor</th>
                            <th>Tanggal Selesai</th>
                            <th>Total Dibayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjaman->where('status', 'lunas') as $item)
                            <tr>
                                <td><b>{{ $item->nama_lengkap }}</b><br><small class="text-muted">{{ $item->alamat }}</small></td>
                                <td>{{ $item->nik }}</td>
                                <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                                <td>{{ $item->tenor }} bulan</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}</td>
                                <td><strong class="text-success">Rp {{ number_format($item->jumlah_pinjaman * 1.2, 0, ',', '.') }}</strong></td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-secondary py-5">Tidak ada riwayat peminjaman selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PROFIL --}}
        <div class="tab-pane fade" id="profil">
            <div class="profile-card">
                <div class="profile-header">
                    <h3 class="mt-4 mb-1 fw-bold">{{ auth()->user()->name }}</h3>
                    <p class="opacity-90">Admin • Koperasi MP</p>
                </div>
                <div class="p-5">
                    <h5 class="fw-bold text-muted mb-3">INFORMASI PRIBADI</h5>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-3 border-bottom">
                                <span class="text-muted">Nama Lengkap</span>
                                <strong>{{ auth()->user()->name }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-3 border-bottom">
                                <span class="text-muted">Email</span>
                                <strong>{{ auth()->user()->email }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-3">
                                <span class="text-muted">Tanggal Bergabung</span>
                                <strong>{{ auth()->user()->created_at->translatedFormat('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-muted mb-3">INFORMASI AKUN</h5>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-3 border-bottom">
                                <span class="text-muted">Role</span>
                                <span class="badge bg-success px-3 py-2">{{ strtoupper(auth()->user()->role) }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between py-3">
                                <span class="text-muted">Terakhir Login</span>
                                <strong>{{ auth()->user()->updated_at->translatedFormat('d M Y, H:i') }} WIB</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL DETAIL --}}
@foreach($pinjaman as $item)
<div class="modal fade" id="detailModal{{ $item->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Foto Diri -->
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $item->selfie_ktp) }}" alt="Foto Diri" class="foto-profil rounded-circle" onerror="this.src='https://via.placeholder.com/160'">
                    <h5 class="mt-3 mb-1 fw-bold">{{ $item->nama_lengkap }}</h5>
                    <small class="text-muted">{{ $item->alamat }}</small>
                </div>

                <h6 class="fw-bold">Data Diri</h6>
                <table class="table">
                    <tr><td>Nama Lengkap</td><td>: {{ $item->nama_lengkap }}</td></tr>
                    <tr><td>NIK</td><td>: {{ $item->nik }}</td></tr>
                    <tr><td>Alamat</td><td>: {{ $item->alamat }}</td></tr>
                    <tr><td>No HP</td><td>: {{ $item->no_hp }}</td></tr>
                </table>

                <!-- Dokumen Foto -->
                <h6 class="fw-bold mt-4">Dokumen Foto</h6>
                <div class="foto-container">
                    <div class="foto-item">
                        <img src="{{ asset('storage/' . $item->selfie_ktp) }}"
                             alt="Foto Diri" class="foto-ktp" onerror="this.src='https://via.placeholder.com/320x200/4f46e5/ffffff?text=Foto+Diri'">
                        <small class="mt-2 d-block">Foto Diri (Selfie)</small>
                    </div>
                    <div class="foto-item">
                        <img src="{{ asset('storage/' . $item->foto_ktp) }}"
                             alt="Foto KTP" class="foto-ktp" onerror="this.src='https://via.placeholder.com/320x200/16a34a/ffffff?text=Foto+KTP'">
                        <small class="mt-2 d-block">Foto KTP</small>
                    </div>
                </div>

                <h6 class="fw-bold mt-4">Data Pinjaman</h6>
                <table class="table">
                    <tr><td>Jumlah</td><td>: Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td></tr>
                    <tr><td>Tenor</td><td>: {{ $item->tenor }} bulan</td></tr>
                    <tr><td>Tujuan</td><td>: {{ $item->tujuan_pinjaman }}</td></tr>
                    <tr><td>Metode</td><td>: {{ $item->metode_pencairan }}</td></tr>
                </table>

                <h6 class="fw-bold mt-4">Tanggal</h6>
                <table class="table">
                    <tr><td>Tanggal Pinjam</td><td>: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</td></tr>
                    <tr><td>Jatuh Tempo</td><td>: {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}</td></tr>
                </table>

            </div>
            <div class="modal-footer">
                @if($item->status == 'pending')
                    <form action="{{ route('admin.pinjaman.approve', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <form action="{{ route('admin.pinjaman.deny', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Deny</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>

<script>
// Tombol Lihat List Pinjaman
const lihatPengajuanBtn = document.getElementById('lihat-pengajuan-btn');
if (lihatPengajuanBtn) {
    lihatPengajuanBtn.addEventListener('click', function() {
        document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.remove('active'));
        document.getElementById('btn-pengajuan').classList.add('active');

        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
        document.getElementById('pengajuan').classList.add('show', 'active');

        document.querySelectorAll('.navbar-nav .nav-link[data-section]').forEach(nav => nav.classList.remove('active'));
        document.querySelector('.navbar-nav .nav-link[data-section="pengajuan"]').classList.add('active');
    });
}

// Navbar atas navigasi internal ke section tab
const adminTopNavLinks = document.querySelectorAll('.navbar-nav .nav-link[data-section]');
adminTopNavLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const sectionId = this.dataset.section;
        const targetPane = document.getElementById(sectionId);
        if (!targetPane) return;

        document.querySelectorAll('.navbar-nav .nav-link[data-section]').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');

        document.querySelectorAll('.sidebar .nav-link').forEach(btn => btn.classList.remove('active'));
        const activeSidebarBtn = document.querySelector(`#btn-${sectionId}`);
        if (activeSidebarBtn) {
            activeSidebarBtn.classList.add('active');
        }

        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
        targetPane.classList.add('show', 'active');
        targetPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>

</body>
</html>
