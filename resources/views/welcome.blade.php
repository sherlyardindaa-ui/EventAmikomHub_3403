@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>

        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>

        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu.
            Pesan aman & cepat dengan Midtrans.
        </p>

        <div class="flex gap-4">
            <a href="#events"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>

            <a href="#"
                class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>

    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <img src="{{ asset('assets/concert.png') }}" alt="Concert"
            class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    ✓
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">
                        Terverifikasi
                    </p>
                    <p class="font-bold">
                        Pembayaran Aman via Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-extrabold mb-2">
                Event Terdekat
            </h2>
            <p class="text-slate-500 font-medium">
                Jangan sampai ketinggalan acara seru minggu ini!
            </p>
        </div>
    </div>

    <!-- FILTER KATEGORI -->
    <div class="mb-8 flex gap-3 justify-center flex-wrap">

    {{-- Semua Kategori --}}
    <a href="{{ url('/') }}"
       class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300
       {{ !request('category')
            ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
            : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 hover:text-indigo-700'
       }}">
        Semua Kategori
    </a>

    {{-- Daftar Kategori --}}
    @foreach($categories as $cat)
        <a href="{{ url('/?category=' . $cat->slug) }}"
           class="px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300
           {{ request('category') == $cat->slug
                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                : 'bg-gray-100 text-gray-700 hover:bg-indigo-100 hover:text-indigo-700'
           }}">
            {{ $cat->name }}
        </a>
    @endforeach

    </div>

    <!-- GRID EVENT -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">

            <!-- IMAGE -->
            <div class="relative overflow-hidden aspect-[3/4]">
                @php
                    $imageUrl = null;
                    $posterPath = $event->poster_path ?? '';
                    
                    if (!empty($posterPath)) {
                        if (file_exists(public_path($posterPath))) {
                            $imageUrl = asset($posterPath);
                        } elseif (Storage::disk('public')->exists($posterPath)) {
                            $imageUrl = asset('storage/' . $posterPath);
                        } elseif (file_exists(public_path('assets/' . $posterPath))) {
                            $imageUrl = asset('assets/' . $posterPath);
                        }
                    }
                @endphp

                @if($imageUrl)
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <img src="https://placehold.co/600x800/e2e8f0/64748b?text={{ urlencode($event->title ?? 'No Poster') }}" 
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @endif

                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 rounded-lg text-xs font-bold text-indigo-600">
                    {{ $event->category->name ?? 'Event' }}
                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">
                    {{ $event->title }}
                </h3>

                <div class="text-slate-500 text-sm mb-4">
                    {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}
                </div>

                <div class="flex justify-between items-center pt-4 border-t">
                    <span class="text-2xl font-black text-indigo-600">
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    </span>

                    <a href="{{ route('events.show', $event->id) }}"
                       class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20">
            <h2 class="text-3xl font-bold text-gray-700">
                Tidak Ada Event
            </h2>
            <p class="text-gray-500 mt-3">
                Event pada kategori ini belum tersedia.
            </p>
        </div>
        @endforelse
    </div>
</section>

<!-- ========== SECTION PARTNER ========== -->
<section class="max-w-7xl mx-auto px-6 py-20 bg-slate-50 rounded-3xl my-10">
    <div class="text-center mb-12">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-3">
            Mitra Kami
        </span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">
            Dipercaya Oleh
        </h2>
        <p class="text-slate-500 mt-3 max-w-2xl mx-auto">
            Berbagai perusahaan dan komunitas telah bergabung bersama kami
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($partners as $partner)
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 hover:shadow-lg transition hover:-translate-y-1 duration-300">
            <div class="w-24 h-24 mx-auto bg-slate-50 rounded-full shadow-sm flex items-center justify-center overflow-hidden">
                @if($partner->logo_url)
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                @elseif($partner->logo)
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2-2z"/>
                    </svg>
                @endif
            </div>
            <h3 class="font-bold text-slate-700 mt-3">{{ $partner->name }}</h3>
            @if($partner->website)
                <a href="{{ $partner->website }}" target="_blank" class="text-xs text-indigo-500 hover:underline mt-1 inline-block">
                    Kunjungi →
                </a>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center text-slate-500 py-8">
            Belum ada partner yang bergabung
        </div>
        @endforelse
    </div>
</section>

@endsection