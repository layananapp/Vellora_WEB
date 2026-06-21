@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')

<div class="w-full min-h-screen bg-[#F5F5F5]">

    {{-- Top Bar --}}
    <div class="bg-[#DDE8C8] px-4 md:px-10 py-3 flex items-center gap-3">

        <span class="text-[#FF8E8E] text-lg">
            🚚
        </span>

        <p class="text-sm font-medium text-[#3B302A]">
            Gratis Pengiriman untuk Semua Order
        </p>

    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 md:px-10 py-6">

        {{-- Left --}}
        <div class="flex items-center gap-2 md:gap-4 text-xl md:text-3xl font-bold flex-wrap justify-center sm:justify-start">

            <a href="/">
                ←
            </a>

            <span>
                Belanja
            </span>

            <span>
                ›
            </span>

            <span>
                Kebijakan Privasi
            </span>

        </div>

        {{-- Login --}}
        <div class="flex items-center gap-2">

            <span class="text-2xl md:text-3xl">
                👤
            </span>

            <span class="font-semibold">
                Masuk
            </span>

        </div>

    </div>

    {{-- Content --}}
    <div class="max-w-5xl mx-auto mt-6 px-4 pb-12">

        <h1 class="text-3xl md:text-5xl font-bold text-center mb-10 md:mb-14">
            Kebijakan Privasi
        </h1>

        <div class="space-y-8">

            {{-- Item 1 --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                    1
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Informasi yang Kami Kumpulkan
                    </h2>

                    <p class="text-lg md:text-xl text-gray-700 mt-2 leading-relaxed">
                        Vellora dapat mengumpulkan informasi seperti nama,
                        email, nomor telepon, alamat, dan data transaksi
                        untuk mendukung layanan platform.
                    </p>

                </div>

            </div>

            {{-- Item 2 --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                    2
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Penggunaan Informasi
                    </h2>

                    <p class="text-lg md:text-xl text-gray-700 mt-2 leading-relaxed">
                        Data pengguna digunakan untuk memproses pesanan,
                        memberikan layanan, mengirim notifikasi,
                        serta meningkatkan pengalaman belanja.
                    </p>

                </div>

            </div>

            {{-- Item 3 --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                    3
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Keamanan Data
                    </h2>

                    <p class="text-lg md:text-xl text-gray-700 mt-2 leading-relaxed">
                        Kami menjaga keamanan data pengguna menggunakan
                        sistem dan teknologi perlindungan yang sesuai
                        agar tidak disalahgunakan.
                    </p>

                </div>

            </div>

            {{-- Item 4 --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                    4
                </div>

                <div>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Berbagi Informasi
                    </h2>

                    <p class="text-lg md:text-xl text-gray-700 mt-2 leading-relaxed">
                        Vellora tidak menjual data pribadi pengguna.
                        Informasi hanya dibagikan kepada pihak terkait
                        seperti layanan pembayaran atau pengiriman
                        sesuai kebutuhan transaksi.
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Footer --}}
    @include('landing.components.footer')

</div>

@endsection