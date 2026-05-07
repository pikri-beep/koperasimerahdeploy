<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel Kendali Administrator') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.modal') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition duration-200">
                    <i class="fas fa-wallet mr-2"></i> Kelola Simpanan
                </a>
                <button onclick="alert('Fitur laporan sedang disiapkan!')" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition duration-200">
                    <i class="fas fa-file-download mr-2"></i> Cetak Laporan Anggota
                </button>

                 <a href="{{ route('admin.pinjaman') }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded shadow transition duration-200">
                    <i class="fas fa-money-bill-wave mr-2"></i> Kelola Pinjaman
                </a>

            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Total Anggota</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAnggota }}</h3>
                            <p class="text-xs text-green-600 mt-2 font-semibold"><i class="fas fa-check-circle"></i> Status Aktif</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-users text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Pengurus (Admin)</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAdmin }}</h3>
                            <p class="text-xs text-purple-600 mt-2 font-semibold"><i class="fas fa-shield-alt"></i> Otoritas Penuh</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Baru (Bulan Ini)</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Pendaftaran via Register</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-user-plus text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                        <div class="p-6 bg-white">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                                <h3 class="font-bold text-lg text-gray-700">Daftar & Hak Akses Anggota</h3>

                                <form action="{{ route('admin.dashboard') }}" method="GET" class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Cari nama atau email..."
                                           class="block w-full md:w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </form>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3">Nama Anggota</th>
                                            <th class="px-4 py-3">Role</th>
                                            <th class="px-4 py-3 text-center">Aksi Kendali</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($users as $user)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-4 py-4">
                                                <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="px-2 py-1 rounded text-[10px] font-extrabold tracking-tighter {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-green-100 text-green-700 border border-green-200' }}">
                                                    {{ strtoupper($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($user->id == 1)
                                                    <span class="text-[10px] bg-gray-800 text-white px-2 py-1 rounded shadow-sm inline-block">
                                                        <i class="fas fa-crown text-yellow-400 mr-1"></i> SUPER ADMIN
                                                    </span>
                                                @elseif($user->id == auth()->id())
                                                    <span class="text-xs text-gray-400 italic font-medium">Akun Anda</span>
                                                @else
                                                    <div class="flex justify-center space-x-4">
                                                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="role" value="{{ $user->role == 'user' ? 'admin' : 'user' }}">
                                                            <button type="submit" title="Switch Role" class="text-indigo-500 hover:text-indigo-700 transition transform hover:scale-110">
                                                                <i class="fas fa-exchange-alt"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" title="Hapus User" class="text-red-400 hover:text-red-600 transition transform hover:scale-110">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-12 text-center text-gray-400 font-medium">
                                                <i class="fas fa-search mb-3 text-3xl block"></i>
                                                Data "{{ request('search') }}" tidak ditemukan.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                        <div class="p-6">
                            <h3 class="font-bold text-gray-700 mb-4 flex items-center">
                                <i class="fas fa-history mr-2 text-gray-400"></i> Pendaftaran Terbaru
                            </h3>
                            <div class="space-y-4">
                                {{-- Kita ambil data pendaftar terbaru secara manual agar tidak terganggu pagination --}}
                                @php $recentUsers = \App\Models\User::latest()->take(5)->get(); @endphp
                                @foreach($recentUsers as $recent)
                                <div class="flex items-center space-x-3 pb-3 border-b border-gray-50 last:border-0">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ strtoupper(substr($recent->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $recent->name }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $recent->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-600 p-6 rounded-xl shadow-lg text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h4 class="font-bold mb-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Info Panel
                            </h4>
                            <p class="text-xs leading-relaxed opacity-90">
                                Gunakan fitur pencarian untuk menemukan anggota berdasarkan nama atau email dengan cepat. Perubahan role akan langsung berdampak pada akses menu user.
                            </p>
                        </div>
                        <div class="absolute -right-4 -bottom-4 opacity-10 text-8xl transform rotate-12">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
