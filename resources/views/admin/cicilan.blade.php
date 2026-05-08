@extends('layouts.dashboard')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Data Cicilan</h2>
            <p class="text-muted mb-0">
                Kelola pembayaran cicilan user
            </p>
        </div>
    </div>

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <div class="card shadow border-0 rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($cicilans as $cicilan)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $cicilan->user->name ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($cicilan->jumlah_cicilan,0,',','.') }}
                            </td>

                            <td>
                                {{ $cicilan->tanggal_jatuh_tempo }}
                            </td>

                            <td>

                                @if($cicilan->status == 'pending')

                                <span class="badge bg-warning">
                                    Pending
                                </span>

                                @elseif($cicilan->status == 'sudah_bayar')

                                <span class="badge bg-primary">
                                    Sudah Bayar
                                </span>

                                @elseif($cicilan->status == 'lunas')

                                <span class="badge bg-success">
                                    Lunas
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    {{ $cicilan->status }}
                                </span>

                                @endif

                            </td>

                            <td>

                                @if($cicilan->foto_bukti)

                                <a href="{{ asset('storage/' . $cicilan->foto_bukti) }}" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    Lihat
                                </a>

                                @else

                                <span class="text-muted">
                                    Belum Upload
                                </span>

                                @endif

                            </td>

                            <td>

                                @if($cicilan->status == 'sudah_bayar')

                                <div class="d-flex gap-2">

                                    <form action="{{ route('admin.cicilan.konfirmasi', $cicilan->id) }}" method="POST">
                                        @csrf

                                        <button class="btn btn-success btn-sm">
                                            Konfirmasi
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.cicilan.tolak', $cicilan->id) }}" method="POST">
                                        @csrf

                                        <button class="btn btn-danger btn-sm">
                                            Tolak
                                        </button>
                                    </form>

                                </div>

                                @else

                                <span class="text-muted">
                                    Tidak ada aksi
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Tidak ada data cicilan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection