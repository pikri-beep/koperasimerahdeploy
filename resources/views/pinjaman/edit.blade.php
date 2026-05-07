@extends('layouts.dashboard')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        background: linear-gradient(135deg, #e0f2fe, #f3e7e9);
    }

    .card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .input {
        transition: all 0.25s ease;
    }

    .input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
    }

    .upload-area {
        border: 2px dashed #9ca3af;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
    }
</style>

<div class="min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto">

        <div class="card rounded-3xl p-8 md:p-10 space-y-8">

            <!-- HEADER -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    Edit Pengajuan Pinjaman
                </h1>

                <a href="{{ route('pinjaman.riwayat') }}"
                   class="text-sm bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-2xl transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl">
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pinjaman.update', $pinjaman->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-10">

                @csrf
                @method('PUT')

                <!-- DATA DIRI -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-user text-blue-500"></i> Data Diri
                    </h2>

                    <div class="grid md:grid-cols-2 gap-5">
                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $pinjaman->nama_lengkap) }}"
                            class="input w-full px-4 py-3 border border-gray-300 rounded-2xl" required>

                        <input type="text" name="nik"
                            value="{{ old('nik', $pinjaman->nik) }}"
                            maxlength="16"
                            class="input w-full px-4 py-3 border border-gray-300 rounded-2xl" required>
                    </div>

                    <textarea name="alamat" rows="3"
                        class="input w-full mt-5 px-4 py-3 border border-gray-300 rounded-2xl" required>
                        {{ old('alamat', $pinjaman->alamat) }}
                    </textarea>

                    <input type="tel" name="no_hp"
                        value="{{ old('no_hp', $pinjaman->no_hp) }}"
                        class="input w-full mt-5 px-4 py-3 border border-gray-300 rounded-2xl" required>
                </div>

                <!-- DATA PINJAMAN -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-money-bill-wave text-green-500"></i> Data Pinjaman
                    </h2>

                    <div class="grid md:grid-cols-2 gap-5">
                        <input type="number" name="jumlah_pinjaman"
                            value="{{ old('jumlah_pinjaman', $pinjaman->jumlah_pinjaman) }}"
                            min="50000"
                            class="input w-full px-4 py-3 border border-gray-300 rounded-2xl" required>

                        <select name="tenor" class="input w-full px-4 py-3 border border-gray-300 rounded-2xl" required>
                            <option value="3"  {{ $pinjaman->tenor == 3  ? 'selected' : '' }}>3 Bulan</option>
                            <option value="6"  {{ $pinjaman->tenor == 6  ? 'selected' : '' }}>6 Bulan</option>
                            <option value="12" {{ $pinjaman->tenor == 12 ? 'selected' : '' }}>12 Bulan</option>
                            <option value="18" {{ $pinjaman->tenor == 18 ? 'selected' : '' }}>18 Bulan</option>
                            <option value="24" {{ $pinjaman->tenor == 24 ? 'selected' : '' }}>24 Bulan</option>
                        </select>
                    </div>

                    <input type="text" name="tujuan_pinjaman"
                        value="{{ old('tujuan_pinjaman', $pinjaman->tujuan_pinjaman) }}"
                        class="input w-full mt-5 px-4 py-3 border border-gray-300 rounded-2xl" required>

                    <select name="metode_pencairan"
                        class="input w-full mt-5 px-4 py-3 border border-gray-300 rounded-2xl" required>
                        <option value="transfer" {{ $pinjaman->metode_pencairan == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="tunai"    {{ $pinjaman->metode_pencairan == 'tunai'    ? 'selected' : '' }}>Tunai</option>
                        <option value="e-wallet" {{ $pinjaman->metode_pencairan == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                    </select>
                </div>

                <!-- DOKUMEN -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-camera text-purple-500"></i> Dokumen Pendukung
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">

                        <!-- Foto KTP -->
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Foto KTP Saat Ini</p>
                            <img src="{{ asset('storage/' . $pinjaman->foto_ktp) }}"
                                 class="w-full h-44 object-cover rounded-2xl border border-gray-200 mb-4">

                            <label class="upload-area block cursor-pointer rounded-2xl p-6 text-center">
                                <input type="file" name="foto_ktp" accept="image/*"
                                       class="hidden" id="fotoKtpInput"
                                       onchange="previewImage(event, 'previewKtpNew')">

                                <div id="previewKtpNewContainer">
                                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik untuk mengganti Foto KTP</p>
                                    <p class="text-xs text-gray-400 mt-1">PNG / JPG (Opsional)</p>
                                </div>

                                <img id="previewKtpNew" class="hidden mt-4 w-full h-40 object-cover rounded-xl"/>
                            </label>
                        </div>

                        <!-- Selfie dengan KTP -->
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Selfie dengan KTP Saat Ini</p>
                            <img src="{{ asset('storage/' . $pinjaman->selfie_ktp) }}"
                                 class="w-full h-44 object-cover rounded-2xl border border-gray-200 mb-4">

                            <label class="upload-area block cursor-pointer rounded-2xl p-6 text-center">
                                <input type="file" name="selfie_ktp" accept="image/*"
                                       class="hidden" id="selfieInput"
                                       onchange="previewImage(event, 'previewSelfieNew')">

                                <div id="previewSelfieNewContainer">
                                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik untuk mengganti Selfie dengan KTP</p>
                                    <p class="text-xs text-gray-400 mt-1">PNG / JPG (Opsional)</p>
                                </div>

                                <img id="previewSelfieNew" class="hidden mt-4 w-full h-40 object-cover rounded-xl"/>
                            </label>
                        </div>

                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600
                                   text-white py-4 rounded-2xl font-semibold shadow-md transition transform hover:scale-[1.02]">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('pinjaman.riwayat') }}"
                       class="flex-1 text-center bg-gray-200 hover:bg-gray-300 py-4 rounded-2xl font-semibold transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');

        // Sembunyikan icon + teks
        const container = previewId === 'previewKtpNew'
            ? document.getElementById('previewKtpNewContainer')
            : document.getElementById('previewSelfieNewContainer');
        if (container) container.style.display = 'none';
    }
}
</script>

@endsection
