<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 1. KONFIGURASI FANCYBOX --}}
    <script>
        Fancybox.bind("[data-fancybox]", {
            Images: { Panzoom: { maxScale: 3 } },
            dragToClose: true,
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [],
                    right: ["iterateZoom", "download", "fullscreen", "close"],
                },
            },
            showClass: "f-zoomInUp",
            hideClass: "f-fadeOut",
            Click: { backdrop: "close" },
        });
    </script>

    {{-- 2. NOTIFIKASI SWEETALERT (TAMBAH/EDIT/STATUS) --}}
    <script>
        // Notifikasi Sukses Umum (Tambah/Edit)
        @if(session('success'))
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        // Notifikasi Status Profile
        @if(session('status'))
            Swal.fire({
                title: "Update Berhasil",
                text: "{{ session('status') }}",
                icon: "success"
            });
        @endif

        // Notifikasi Gagal/Error
        @if(session('error'))
            Swal.fire({
                title: "Opps!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        @endif
    </script>

    {{-- 3. SCRIPT KONFIRMASI HAPUS DATA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menangkap klik pada tombol dengan class 'confirm-delete'
            document.body.addEventListener('click', function (e) {
                if (e.target.closest('.confirm-delete')) {
                    e.preventDefault();
                    const button = e.target.closest('.confirm-delete');
                    const form = button.closest('form');

                    Swal.fire({
                        title: "Hapus data ini?",
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ef4444", // merah tailwind
                        cancelButtonColor: "#6b7280",  // abu-abu tailwind
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>