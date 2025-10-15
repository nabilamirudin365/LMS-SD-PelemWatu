@extends('layouts.app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-indigo-800">👥 Manajemen Akun</h2>
        <a href="{{ route('users.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow-md font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span>Tambah Akun</span>
        </a>
    </div>

    {{-- Form Filter & Search --}}
    <form method="GET" action="{{ route('users.index') }}" class="mb-6 p-4 bg-slate-50 rounded-lg">
        <div class="flex flex-wrap items-end gap-4">
            
            {{-- Filter Role --}}
            <div>
                <label for="role" class="block font-semibold mb-1 text-slate-700">Filter berdasarkan Role:</label>
                <select name="role" id="role" class="w-full border rounded px-3 py-2">
                    <option value="">-- Semua Role --</option>
                    <option value="guru" {{ $selectedRole == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="murid" {{ $selectedRole == 'murid' ? 'selected' : '' }}>Murid</option>
                </select>
            </div>

            {{-- Filter Kelas (Awalnya disembunyikan jika role bukan murid) --}}
            <div id="kelas-filter-container" style="display: {{ $selectedRole == 'murid' ? 'block' : 'none' }};">
                <label for="kelas_id" class="block font-semibold mb-1 text-slate-700">Filter berdasarkan Kelas:</label>
                <select name="kelas_id" id="kelas_id" class="w-full border rounded px-3 py-2">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            {{-- Search Bar --}}
            <div>
                <label for="search" class="block font-semibold mb-1 text-slate-700">Cari Nama:</label>
                <input type="search" name="search" id="search" placeholder="Ketik nama..." value="{{ $searchKeyword }}" class="w-full border rounded px-3 py-2">
            </div>

            {{-- Tombol Aksi Form --}}
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded shadow-md">Filter</button>
            <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline py-2">Reset</a>
        </div>
    </form>
    
    {{-- ... Tabel dan bagian lainnya tetap sama ... --}}
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="w-full table-auto">
             <thead class="bg-slate-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Role</th>
                    @if($selectedRole != 'guru')
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Kelas</th>
                    @endif
                    <th class="px-4 py-3 text-center font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-700">
                @forelse($users as $user)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 font-semibold text-xs rounded-full 
                            @if($user->role == 'guru') bg-sky-100 text-sky-800 @endif
                            @if($user->role == 'murid') bg-emerald-100 text-emerald-800 @endif
                        ">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    @if($selectedRole != 'guru')
                        <td class="px-4 py-3">
                            @forelse($user->kelas as $kelas)
                                <span class="bg-gray-200 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                    {{ $kelas->nama_kelas }}
                                </span>
                            @empty
                                <span class="text-slate-400 text-xs">-</span>
                            @endforelse
                        </td>
                    @endif

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-x-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-slate-500">
                        Tidak ada data user yang cocok dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6 flex justify-between items-center">
        <div>
            {{ $users->links() }}
        </div>
        <a href="{{ route('dashboard') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg shadow">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>

{{-- JAVASCRIPT UNTUK LOGIKA TAMPIL/SEMBUNYI --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const kelasFilterContainer = document.getElementById('kelas-filter-container');

        // Fungsi untuk mengecek dan mengubah tampilan
        function toggleKelasFilter() {
            if (roleSelect.value === 'murid') {
                kelasFilterContainer.style.display = 'block';
            } else {
                kelasFilterContainer.style.display = 'none';
            }
        }

        // Panggil fungsi saat halaman pertama kali dimuat
        toggleKelasFilter();

        // Tambahkan event listener untuk memanggil fungsi setiap kali pilihan role berubah
        roleSelect.addEventListener('change', toggleKelasFilter);
    });
</script>

@endsection