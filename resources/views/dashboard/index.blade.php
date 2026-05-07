@extends('layouts.dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --maroon-prime: #660606;
        --maroon-dark: #4b0404;
        --maroon-light: #8c1414;
        --maroon-soft: #fff5f5;
        --text-dark: #1f2937;
        --text-gray: #6b7280;
    }

    .profile-container {
        font-family: 'Inter', sans-serif;
        max-width: 850px;
        margin: 0 auto;
    }

    /* =====================
       PAGE HEADING
    ===================== */
    .page-heading {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.02em;
    }

    .page-heading::before {
        content: "";
        width: 4px;
        height: 24px;
        background: var(--maroon-prime);
        border-radius: 4px;
    }

    /* =====================
       SECTION CARD
    ===================== */
    .section-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(102, 6, 6, 0.05);
        border: 1px solid rgba(102, 6, 6, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .section-header {
        background: linear-gradient(to right, var(--maroon-soft), transparent);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(102, 6, 6, 0.05);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--maroon-prime);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-body {
        padding: 2.5rem 1.5rem;
    }

    /* =====================
       PROFILE AVATAR
    ===================== */
    .profile-info-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1.5rem;
    }

    .avatar-outer {
        position: relative;
        padding: 5px;
        background: linear-gradient(135deg, var(--maroon-prime), var(--maroon-light));
        border-radius: 50%;
        box-shadow: 0 10px 25px rgba(102, 6, 6, 0.2);
        transition: transform 0.3s ease;
    }

    .avatar-outer:hover {
        transform: scale(1.03);
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        cursor: pointer;
    }

    .profile-details h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .profile-details p {
        font-size: 0.95rem;
        margin-top: 8px;
        background: var(--maroon-soft);
        padding: 4px 16px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        color: var(--maroon-prime);
        font-weight: 500;
    }

    /* =====================
       STAT CARDS
    ===================== */
    .stat-card-custom {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .stat-card-custom:hover {
        transform: translateY(-5px);
    }

    .stat-card-icon {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    /* =====================
       BUTTONS
    ===================== */
    .btn-elegant {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 0.8rem 1.8rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 14px;
        transition: all 0.2s ease;
    }

    .btn-primary-maroon {
        background: var(--maroon-prime);
        color: #ffffff;
        border: none;
    }

    .btn-primary-maroon:hover {
        background: var(--maroon-dark);
        box-shadow: 0 8px 20px rgba(102, 6, 6, 0.3);
        color: white;
    }

    /* Fancybox Custom Styling */
    .fancybox__content { border-radius: 12px; }
    .fancybox__backdrop { background: rgba(31, 41, 55, 0.95); }
</style>
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="profile-container">

            <div class="page-heading">
                <i class="fa-solid fa-user-shield text-maroon-prime"></i>
                My Profile
            </div>
{{-- ini tidak terlalu penting,mungkin untuk alert --}}
            @if(session('profil'))
                <div class="alert alert-minimal shadow-sm bg-white border-start border-success border-4 mb-4" role="alert">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <span><i class="fa-solid fa-circle-check text-success me-2"></i>{{ session('profile') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="section-card">
                <div class="section-header">
                    <i class="fa-solid fa-id-card me-1"></i> Identitas Akun
                </div>
                <div class="section-body">

                    <div class="profile-info-wrapper">
                        <div class="avatar-outer">
                            <a href="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('sbadmin2/img/undraw_profile.svg') }}"
                                data-fancybox="profile"
                                data-caption="{{ auth()->user()->name }}">
                                <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('sbadmin2/img/undraw_profile.svg') }}"
                                    class="profile-avatar" id="preview-img" alt="Foto Profil">
                            </a>
                        </div>

                        <div class="profile-details">
                            <h3>{{ auth()->user()->name }}</h3>
                            <p><i class="fa-solid fa-envelope me-2"></i> {{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <div class="action-group d-flex justify-content-center mt-5 gap-3">
                        <a href="{{ route('profile.edit') }}" class="btn-elegant btn-primary-maroon text-decoration-none">
                            <i class="fa-solid fa-user-pen"></i> Edit Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button type="submit" class="btn-elegant btn-outline-danger bg-white border-danger text-danger">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar
                            </button>
                        </form>


                    </div>

                    {{-- batas kelompok 2 --}}
    <header class="mb-4">
        {{-- <h2 class="fw-bold text-dark">Ringkasan Koperasi</h2> --}}
        {{-- <p class="text-muted">Statistik Koperasi Merah Putih hari ini.</p> --}}
    </header>

    <div class="row g-4">

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 border-start border-danger border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Total Cicilan</h6>
                    <h3 class="fw-bold text-dark mb-0">Rp0</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Pinjaman Aktif</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalPinjamanAktif ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 border-start border-warning border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Total Penarikan</h6>
                    <h3 class="fw-bold text-dark mb-0">Rp0</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold">Modal Koperasi</h6>
                    <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($totalModal ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
{{-- batas kelompok 2 --}}


                </div>
            </div>
        </div>
    </div>
</div>



@endsection
