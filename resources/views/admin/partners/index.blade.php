@extends('layouts.admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Kelola data mitra/partner event')

@section('content')
<div class="w-full">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header dengan Search -->
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">Data Partner</h2>
                <p class="text-xs text-slate-500">Total {{ $partners->total() }} partner</p>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- FORM SEARCH -->
                <form method="GET" action="{{ route('admin.partners.index') }}" class="flex">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari partner..." 
                               class="w-64 pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-sm">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.partners.index') }}" class="ml-2 px-3 py-2 bg-slate-200 text-slate-600 rounded-lg hover:bg-slate-300 text-sm">
                            Reset
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('admin.partners.create') }}" 
                   class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition">
                    + Tambah
                </a>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
        <div class="mx-5 mt-4 bg-green-100 text-green-700 p-2 rounded text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mx-5 mt-4 bg-red-100 text-red-700 p-2 rounded text-sm">
            {{ session('error') }}
        </div>
        @endif

        <!-- Info Hasil Pencarian -->
        @if(request('search'))
        <div class="mx-5 mt-3 text-xs text-slate-500">
            Hasil pencarian: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('admin.partners.index') }}" class="text-indigo-600 hover:underline ml-2">Hapus</a>
        </div>
        @endif

        <!-- Grid Partner -->
        <div class="p-5">
            @if($partners->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($partners as $partner)
                        <div class="border border-slate-200 rounded-lg p-3 text-center hover:shadow transition">
                            <!-- Logo -->
                            <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center overflow-hidden">
                                @if($partner->logo_url)
                                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                    </svg>
                                @endif
                            </div>

                            <!-- Nama -->
                            <h3 class="font-semibold text-slate-800 text-sm mt-2">{{ $partner->name }}</h3>

                            <!-- Website -->
                            @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" class="text-xs text-indigo-500 hover:underline">Website</a>
                            @endif

                            <!-- Tombol Aksi -->
                            <div class="flex justify-center gap-2 mt-3">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" 
                                   class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus partner {{ $partner->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 pt-4 border-t border-slate-200">
                    {{ $partners->links() }}
                </div>
            @else
                <div class="text-center py-10">
                    @if(request('search'))
                        <p class="text-slate-500">Tidak ada partner dengan nama <strong>"{{ request('search') }}"</strong></p>
                        <a href="{{ route('admin.partners.index') }}" class="text-indigo-600 text-sm hover:underline mt-2 inline-block">Lihat semua partner</a>
                    @else
                        <p class="text-slate-500">Belum ada data partner</p>
                        <a href="{{ route('admin.partners.create') }}" class="text-indigo-600 text-sm hover:underline mt-2 inline-block">Tambah partner</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection