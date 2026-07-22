@extends('layouts.app')

@section('content')

<!-- ===== HERO SECTION ===== -->
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

        <img src="{{ file_exists(public_path('assets/concert.png')) ? asset('assets/concert.png') : 'https://placehold.co/800x1000/4f46e5/ffffff?text=Concert+Event' }}" 
             alt="Concert"
             class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/80 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">
                    ✓
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">
                        Terverifikasi
                    </p>
                    <p class="font-bold text-slate-800">
                        Pembayaran Aman via Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== EVENTS SECTION ===== -->
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
                    $poster = $event->poster_path;

                    if ($poster && file_exists(public_path($poster))) {
                        $imageUrl = asset($poster);
                    } elseif ($poster && file_exists(public_path('assets/' . basename($poster)))) {
                        $imageUrl = asset('assets/' . basename($poster));
                    } elseif ($poster && \Illuminate\Support\Facades\Storage::disk('public')->exists($poster)) {
                        $imageUrl = asset('storage/' . $poster);
                    } else {
                        $imageUrl = 'https://placehold.co/600x800/e2e8f0/64748b?text=No+Poster';
                    }
                @endphp

                <img src="{{ $imageUrl }}"
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 rounded-lg text-xs font-bold text-indigo-600">
                    {{ $event->category->name ?? 'Event' }}
                </div>

            </div>

            <!-- CONTENT -->
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-1">
                    {{ $event->title }}
                </h3>

                <div class="text-slate-500 text-sm mb-4">
                    {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
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

<!-- ===== PARTNER SECTION ===== -->
<section class="max-w-7xl mx-auto px-6 py-20">

    <div class="text-center mb-12">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-3">
            Mitra Kami
        </span>

        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">
            Dipercaya Oleh
        </h2>

        <p class="text-slate-500 mt-3 max-w-2xl mx-auto">
            Bekerja sama dengan partner terpercaya untuk memberikan pengalaman terbaik.
        </p>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">

    @php
    $defaultPartners = [
        [
            'name' => 'Gojek',
            'logo' => 'https://placehold.co/200x80/00AA13/FFFFFF?text=Gojek'
        ],
        [
            'name' => 'Grab',
            'logo' => 'https://placehold.co/200x80/00B14F/FFFFFF?text=Grab'
        ],
        [
            'name' => 'Bank BRI',
            'logo' => 'https://placehold.co/200x80/00529C/FFFFFF?text=BRI'
        ],
        [
            'name' => 'Bank BCA',
            'logo' => 'https://placehold.co/200x80/00529C/FFFFFF?text=BCA'
        ],
        [
            'name' => 'Bank Mandiri',
            'logo' => 'https://placehold.co/200x80/003D79/FFFFFF?text=Mandiri'
        ],
        [
            'name' => 'DANA',
            'logo' => 'https://placehold.co/200x80/118EEA/FFFFFF?text=DANA'
        ],
    ];
    @endphp

        @foreach($defaultPartners as $partner)

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition p-6 flex flex-col items-center justify-center gap-4">

            <div class="w-full h-14 flex items-center justify-center">
                <img src="{{ $partner['logo'] }}"
                     alt="{{ $partner['name'] }}"
                     class="max-w-full max-h-full object-contain">
            </div>

            <h3 class="font-bold text-slate-700">
                {{ $partner['name'] }}
            </h3>

        </div>

        @endforeach

    </div>

</section>

        <!-- Trust Badge Bottom -->
        <div class="mt-12 pt-8 border-t border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-400">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Transaksi Terenkripsi & Didukung Pengiriman E-Ticket Instan</span>
            </div>
            <div class="flex gap-4">
                <span class="hover:text-slate-300 cursor-pointer">Syarat & Ketentuan Partner</span>
            </div>
        </div>

    </div>
</section>

@endsection