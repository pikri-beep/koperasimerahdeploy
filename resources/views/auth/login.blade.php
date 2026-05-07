<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Koperasi Merah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%); }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-2xl shadow-lg mb-4 rotate-3">
                    <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                    KOPERASI <span class="text-red-600">MERAH PUTIH</span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">Silakan masuk untuk akses dashboard</p>
            </div>

            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-100">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Anggota</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition duration-200 outline-none"
                                placeholder="contoh@email.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <input id="password" type="password" name="password" required 
                            class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition duration-200 outline-none"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-8 text-xs">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded text-red-600 focus:ring-red-500 border-gray-300">
                            <span class="ml-2 text-gray-600 font-medium italic">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-red-600 hover:underline font-bold">Lupa Sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-red-200 transition duration-300 transform active:scale-95 uppercase tracking-wider text-sm">
                        Masuk Ke Akun <i class="fas fa-sign-in-alt ml-2"></i>
                    </button>
                </form>

                <div class="mt-8 text-center border-t border-gray-50 pt-6">
                    <p class="text-sm text-gray-500 font-medium">
                        Belum jadi anggota? 
                        <a href="{{ route('register') }}" class="text-red-600 font-black hover:underline ml-1">Daftar Sekarang</a>
                    </p>
                </div>
            </div>

            <p class="text-center mt-10 text-gray-400 text-[10px] font-bold uppercase tracking-widest">
                &copy; 2026 Koperasi Merah Putih &bull; Build with Love ❤️
            </p>
        </div>
    </div>
</body>
</html>