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

    <div class="mb-8 flex gap-4 justify-center flex-wrap">

        <a href="{{ url('/') }}"
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-black transition">
            Semua Kategori
        </a>

        @foreach($categories as $cat)
            <a href="{{ url('/?category=' . $cat->slug) }}"
               class="px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded shadow-sm transition">
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

                @if($event->poster_path)
                    <img src="{{ asset('assets/' . basename($event->poster_path)) }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif

                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 rounded-lg text-xs font-bold text-indigo-600">
                    {{ $event->category->name }}
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

                    <a href="{{ route('events.show') }}"
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

@endsection