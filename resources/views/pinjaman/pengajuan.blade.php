<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Pinjaman</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #f3e7e9);
        }

        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .input {
            transition: all 0.25s ease;
        }

        .input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
        }

        .input:hover {
            border-color: #93c5fd;
        }
    </style>
</head>

<body class="min-h-screen py-10 px-4">

<div class="max-w-4xl mx-auto">

    <!-- CARD -->
    <div class="card rounded-3xl p-8 md:p-10 space-y-8">

        <!-- HEADER DALAM CARD -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-dollar text-blue-600"></i>
                Pengajuan Pinjaman
            </h1>

            <a href="{{ route('pinjaman') }}"
               class="text-sm bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- VALIDATION ERROR -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('pinjaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        <!-- DATA DIRI -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
                <i class="fa-solid fa-user text-blue-500"></i> Data Diri
            </h2>

            <div class="grid md:grid-cols-2 gap-5">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap"
                       class="input w-full px-4 py-3 border rounded-xl"
                       value="{{ old('nama_lengkap') }}" required>

                <input type="text" name="nik" placeholder="NIK"
                       maxlength="16"
                       class="input w-full px-4 py-3 border rounded-xl"
                       value="{{ old('nik') }}" required>
            </div>

            <textarea name="alamat" rows="3"
                      placeholder="Alamat Lengkap"
                      class="input w-full mt-5 px-4 py-3 border rounded-xl"
                      required>{{ old('alamat') }}</textarea>

            <input type="tel" name="no_hp"
                   placeholder="Nomor HP / WhatsApp"
                   class="input w-full mt-5 px-4 py-3 border rounded-xl"
                   value="{{ old('no_hp') }}" required>
        </div>

        <!-- DATA PINJAMAN -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
                <i class="fa-solid fa-money-bill-wave text-green-500"></i> Data Pinjaman
            </h2>

            <div class="grid md:grid-cols-2 gap-5">
                <input type="number" name="jumlah_pinjaman"
                       placeholder="Jumlah Pinjaman (Rp)"
                       min="50000"
                       class="input w-full px-4 py-3 border rounded-xl"
                       value="{{ old('jumlah_pinjaman') }}" required>

                <select name="tenor" class="input w-full px-4 py-3 border rounded-xl" required>
                    <option value="">Pilih Tenor</option>
                    <option value="3" {{ old('tenor')=='3'?'selected':'' }}>3 Bulan</option>
                    <option value="6" {{ old('tenor')=='6'?'selected':'' }}>6 Bulan</option>
                    <option value="12" {{ old('tenor')=='12'?'selected':'' }}>12 Bulan</option>
                    <option value="18" {{ old('tenor')=='18'?'selected':'' }}>18 Bulan</option>
                    <option value="24" {{ old('tenor')=='24'?'selected':'' }}>24 Bulan</option>
                </select>
            </div>

            <input type="text" name="tujuan_pinjaman"
                   placeholder="Tujuan Pinjaman"
                   class="input w-full mt-5 px-4 py-3 border rounded-xl"
                   value="{{ old('tujuan_pinjaman') }}" required>

            <select name="metode_pencairan"
                    class="input w-full mt-5 px-4 py-3 border rounded-xl" required>
                <option value="">Metode Pencairan</option>
                <option value="transfer" {{ old('metode_pencairan')=='transfer'?'selected':'' }}>Transfer Bank</option>
                <option value="tunai" {{ old('metode_pencairan')=='tunai'?'selected':'' }}>Tunai</option>
                <option value="e-wallet" {{ old('metode_pencairan')=='e-wallet'?'selected':'' }}>E-Wallet</option>
            </select>
        </div>

        <!-- UPLOAD -->
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-5 flex items-center gap-2">
        <i class="fa-solid fa-camera text-purple-500"></i> Upload Dokumen
    </h2>

    <div class="grid md:grid-cols-2 gap-6">

        <!-- FOTO KTP -->
        <label class="cursor-pointer group">
            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-blue-400 transition relative">

                <input type="file" name="foto_ktp" accept="image/*" required
                       class="absolute inset-0 opacity-0 cursor-pointer"
                       onchange="previewImage(event, 'previewKTP')">

                <div id="previewKTPContainer" class="space-y-2">
                    <i class="fa-solid fa-id-card text-3xl text-gray-400 group-hover:text-blue-500"></i>
                    <p class="text-sm text-gray-600">Klik atau drop Foto KTP</p>
                    <p class="text-xs text-gray-400">PNG / JPG</p>
                </div>

                <img id="previewKTP" class="hidden mt-3 w-full h-40 object-cover rounded-xl"/>
            </div>
        </label>

        <!-- SELFIE -->
        <label class="cursor-pointer group">
            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-blue-400 transition relative">

                <input type="file" name="selfie_ktp" accept="image/*" required
                       class="absolute inset-0 opacity-0 cursor-pointer"
                       onchange="previewImage(event, 'previewSelfie')">

                <div id="previewSelfieContainer" class="space-y-2">
                    <i class="fa-solid fa-user-check text-3xl text-gray-400 group-hover:text-blue-500"></i>
                    <p class="text-sm text-gray-600">Selfie dengan KTP</p>
                    <p class="text-xs text-gray-400">PNG / JPG</p>
                </div>

                <img id="previewSelfie" class="hidden mt-3 w-full h-40 object-cover rounded-xl"/>
            </div>
        </label>

    </div>
</div>

        <!-- BUTTON -->
        <div class="flex flex-col md:flex-row gap-4 pt-6">
            <button type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 hover:scale-[1.02] text-white py-4 rounded-xl font-semibold shadow-md transition">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Kirim Pengajuan
            </button>

            <a href="{{ route('pinjaman') }}"
               class="flex-1 text-center bg-gray-200 hover:bg-gray-300 py-4 rounded-xl font-semibold transition">
                Batal
            </a>
        </div>

        </form>
    </div>
</div>

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pengajuan Berhasil',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#6366f1',
        width: 500,
        padding: '2em'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('pinjaman') }}";
        }
    });
</script>
@endif

</body>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
}
</script>

</html>
