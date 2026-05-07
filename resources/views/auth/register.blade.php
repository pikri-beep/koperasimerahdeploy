<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Koperasi Merah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: radial-gradient(circle, #ffffff 0%, #f3f4f6 100%); }
    </style>
</head>
<body class="antialiased overflow-hidden text-gray-900">
    <div class="h-screen w-full flex items-center justify-center p-4">
        <div class="max-w-md w-full flex flex-col items-center">
            
            <div class="text-center mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-red-600 rounded-2xl shadow-lg mb-2 -rotate-3">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-black tracking-tight uppercase">
                    GABUNG <span class="text-red-600">ANGGOTA</span>
                </h1>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Koperasi Merah Putih</p>
            </div>

            <div class="bg-white rounded-[1.00rem] shadow-2xl p-6 border border-gray-100 relative w-full overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-red-600"></div>

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition outline-none text-sm font-medium"
                            placeholder="Nama Anda">
                        @error('name') <p class="text-[9px] text-red-500 font-bold uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition outline-none text-sm font-medium"
                            placeholder="nama@email.com">
                        @error('email') <p class="text-[9px] text-red-500 font-bold uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Sandi</label>
                            <input id="password" type="password" name="password" required 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition outline-none text-sm font-medium"
                                placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Konfirmasi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition outline-none text-sm font-medium"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-2 bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-2xl shadow-xl shadow-red-200 transition transform active:scale-95 uppercase tracking-widest text-xs">
                        Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                    </button>
                </form>

                <div class="mt-5 text-center border-t border-gray-50 pt-4">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-red-600 hover:underline">Masuk</a>
                    </p>
                </div>
            </div>

            <p class="mt-6 text-gray-400 text-[9px] font-bold uppercase tracking-[0.3em]">
                &copy; 2026 Koperasi Merah Putih &bull; Build with Love ❤️
            </p>
        </div>
    </div>
</body>
</html>