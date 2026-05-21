@extends('layouts.admin')

@section('page_title', 'Tambah Kategori')
@section('page_subtitle', 'Buat kategori event baru')

@section('content')
<div class="w-full max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="px-6 py-5 border-b border-slate-200">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-slate-800">Form Tambah Kategori</h2>
            </div>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('name') border-red-500 @enderror"
                       placeholder="Contoh: Seminar, Workshop, Competition"
                       autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-slate-400">Nama kategori akan digunakan untuk mengelompokkan event.</p>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-sm">
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 border border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection