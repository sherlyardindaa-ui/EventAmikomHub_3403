@extends('layouts.admin')

@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah data mitra/partner')

@section('content')
<div class="w-full max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.partners.index') }}" class="text-slate-500 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="text-lg font-semibold text-slate-800">Edit Partner</h2>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="p-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Partner -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Partner <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $partner->name) }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama partner"
                       required>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo Partner -->
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-slate-700 mb-1">
                    Logo Partner
                </label>
                
                <!-- Tampilkan logo lama jika ada -->
                @if($partner->logo_url)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-12 h-12 object-cover rounded-lg border">
                        <span class="text-xs text-slate-500">Logo saat ini</span>
                    </div>
                @endif

                <input type="file" 
                       name="logo" 
                       id="logo" 
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm file:mr-2 file:px-3 file:py-1 file:bg-indigo-50 file:text-indigo-700 file:border-0 file:rounded-lg file:text-sm file:font-medium hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-slate-400">Kosongkan jika tidak ingin mengubah logo</p>
                @error('logo')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website -->
            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-slate-700 mb-1">
                    Website
                </label>
                <input type="url" 
                       name="website" 
                       id="website" 
                       value="{{ old('website', $partner->website) }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('website') border-red-500 @enderror"
                       placeholder="https://example.com">
                @error('website')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.partners.index') }}" class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection