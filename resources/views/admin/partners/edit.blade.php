@extends('layouts.admin')

@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah data partner')

@section('content')
<div class="w-full max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="px-5 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Form Edit Partner</h2>
        </div>

        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="p-5">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Partner *</label>
                <input type="text" name="name" value="{{ old('name', $partner->name) }}" 
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Logo URL *</label>
                <input type="url" name="logo_url" value="{{ old('logo_url', $partner->logo_url) }}" 
                       placeholder="https://example.com/logo.png"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('logo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Website</label>
                <input type="url" name="website" value="{{ old('website', $partner->website) }}" 
                       placeholder="https://example.com"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update</button>
                <a href="{{ route('admin.partners.index') }}" class="px-4 py-2 border rounded-lg hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection