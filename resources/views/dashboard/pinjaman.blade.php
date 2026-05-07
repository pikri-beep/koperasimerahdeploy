@extends('layouts.dashboard')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjaman - Koperasi MP</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --maroon-prime: #8b0000;
            --maroon-light: #b22222;
            --maroon-soft: #ffe5e5;
        }

        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

       /* ================= SIDEBAR FIXED PROFIL ================= */
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

        /* Content Area */
        .content {
            flex: 1;
            padding: 35px 40px;
        }

        .welcome-box {
            background: linear-gradient(135deg, #fff0f0 0%, #fff 100%);
            border-left: 8px solid var(--maroon-prime);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .welcome-box:hover {
            transform: translateY(-5px);
        }

        .btn-maroon {
            background: var(--maroon-prime);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
            transition: all 0.3s;
        }

        .btn-maroon:hover {
            background: var(--maroon-light);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.35);
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
        }

        .stat-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(139, 0, 0, 0.15);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .card-box {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.07);
        }

        .logo-text {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR (Hanya perbaikan font & hover) -->
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
            <a href="{{ route('pinjaman') }}" class="active"><i class="bi bi-house-door me-2"></i> Beranda</a>
            <a href="{{ route('pinjaman.riwayat') }}"><i class="bi bi-clock-history me-2"></i> Riwayat Pengajuan</a>
            <a href="{{ route('dashboard') }}"><i class="bi bi-person-circle me-2"></i> Profil Saya</a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">

        <h2 class="fw-bold mb-4">Dashboard Pinjaman</h2>

        <!-- Welcome Box dengan efek zoom -->
        <div class="welcome-box mb-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold">Selamat Datang, <span class="text-maroon">{{ auth()->user()->name }}</span> 👋</h3>
                    <p class="lead text-muted mt-2">Ajukan pinjaman dengan proses cepat, aman, dan transparan.</p>
                    <a href="{{ route('pinjaman.pengajuan') }}" class="btn btn-maroon btn-lg mt-3">
                        <i class="bi bi-plus-circle me-2"></i> Ajukan Pinjaman Baru
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                         width="155" alt="Illustration" class="img-fluid">
                </div>
            </div>
        </div>

<!-- Statistik Dinamis -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stat-card h-100 text-center">
            <div class="card-body">
                <div class="icon-circle bg-danger text-white mx-auto">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <p class="text-muted mb-1">Total Pengajuan</p>
                <h3 class="fw-bold text-danger">{{ $total ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 text-center">
            <div class="card-body">
                <div class="icon-circle bg-warning text-white mx-auto">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="text-muted mb-1">Menunggu</p>
                <h3 class="fw-bold text-warning">{{ $pending ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 text-center">
            <div class="card-body">
                <div class="icon-circle bg-success text-white mx-auto">
                    <i class="bi bi-check-circle"></i>
                </div>
                <p class="text-muted mb-1">Disetujui</p>
                <h3 class="fw-bold text-success">{{ $disetujui ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card h-100 text-center">
            <div class="card-body">
                <div class="icon-circle bg-secondary text-white mx-auto">
                    <i class="bi bi-x-circle"></i>
                </div>
                <p class="text-muted mb-1">Ditolak</p>
                <h3 class="fw-bold">{{ $ditolak ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

        <!-- Informasi -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card card-box h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-4">Keunggulan Pinjaman di Koperasi MP</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Proses Cepat</strong><br>
                                        <small class="text-muted">1-3 hari kerja</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Bunga Rendah</strong><br>
                                        <small class="text-muted">Kompetitif & transparan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Dana Langsung Cair</strong><br>
                                        <small class="text-muted">Ke rekening atau e-wallet</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Aman & Terpercaya</strong><br>
                                        <small class="text-muted">Terdaftar resmi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-box h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold">Tentang Kami</h5>
                        <p class="mt-3 text-muted">
                            Koperasi Marah Putih berkomitmen membantu anggota dalam memenuhi kebutuhan finansial
                            dengan pelayanan yang cepat, adil, dan profesional.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endsection
