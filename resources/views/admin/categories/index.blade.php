@extends('layouts.admin')

@section('page_title', 'Kelola Kategori')
@section('page_subtitle', 'Kelola data kategori event')

@section('content')
<div class="w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header dengan Search dan Tombol Tambah -->
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Daftar Kategori</h2>
                <p class="text-sm text-slate-500 mt-0.5">Total {{ $categories->total() }} kategori</p>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- FORM SEARCH -->
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari kategori..." 
                               class="w-64 pl-10 pr-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.categories.index') }}" class="ml-2 px-3 py-2 bg-slate-200 text-slate-600 rounded-xl hover:bg-slate-300 text-sm">
                            Reset
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('admin.categories.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah
                </a>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
        <div class="mx-6 mt-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        <!-- Info Hasil Pencarian -->
        @if(request('search'))
        <div class="mx-6 mt-4 text-sm text-slate-500">
            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:underline ml-2">Hapus filter</a>
        </div>
        @endif

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">Dibuat Pada</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500">Diupdate Pada</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $category->id }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700">
                                {{ $category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            @if(request('search'))
                                Tidak ada kategori dengan nama <strong>"{{ request('search') }}"</strong>
                            @else
                                Belum ada data kategori
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection