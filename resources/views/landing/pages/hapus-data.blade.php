@extends('layouts.app')

@section('title', 'Hapus Data')

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
        <div class="flex items-center gap-2 md:gap-4 text-xl md:text-2xl font-bold flex-wrap justify-center sm:justify-start">

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
                Hapus Data
            </span>

        </div>

        {{-- Login --}}
        <div class="flex items-center gap-2">

            <span class="text-2xl">
                👤
            </span>

            <span class="font-semibold">
                Masuk
            </span>

        </div>

    </div>

    {{-- Main Content --}}
    <div class="max-w-5xl mx-auto mt-8 px-4 pb-20">

        {{-- Title --}}
        <div class="text-center">

            <h1 class="text-2xl md:text-4xl font-bold text-[#3B302A]">
                Penghapusan Akun & Data
            </h1>

            <p class="text-base md:text-lg text-gray-600 mt-3">
                Pengguna dapat mengajukan penghapusan akun dan data melalui halaman ini.
            </p>

        </div>

        {{-- Card --}}
        <div class="bg-white rounded-[28px] shadow-sm p-6 md:p-10 mt-8 md:mt-12 border border-gray-200">

            <div class="space-y-8">

                {{-- Penjelasan --}}
                <div>

                    <h2 class="text-xl md:text-2xl font-semibold text-[#3B302A] mb-4">
                        Cara Menghapus Akun
                    </h2>

                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        Untuk menghapus akun Marketplace Anda, silakan kirim permintaan penghapusan akun melalui email resmi kami.
                    </p>

                </div>

                {{-- Email --}}
                <div class="bg-[#FFF4F7] rounded-2xl p-6">

                    <p class="text-xs text-gray-500 mb-2">
                        Email Penghapusan Akun
                    </p>

                    <p class="text-base md:text-lg font-semibold text-[#3B302A] break-all">
                        layananapp@gmail.com
                    </p>

                </div>

                {{-- Langkah --}}
                <div>

                    <h2 class="text-xl md:text-2xl font-semibold text-[#3B302A] mb-4">
                        Langkah Pengajuan
                    </h2>

                    <div class="space-y-4 text-gray-600 text-sm md:text-base">

                        <div class="flex gap-3">

                            <span class="font-bold">
                                1.
                            </span>

                            <p>
                                Kirim email dengan subject:
                                <span class="font-semibold">
                                    "Permintaan Hapus Akun"
                                </span>
                            </p>

                        </div>

                        <div class="flex gap-3">

                            <span class="font-bold">
                                2.
                            </span>

                            <p>
                                Sertakan nama akun dan email yang terdaftar pada aplikasi.
                            </p>

                        </div>

                        <div class="flex gap-3">

                            <span class="font-bold">
                                3.
                            </span>

                            <p>
                                Permintaan akan diproses maksimal dalam 7 hari kerja.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Data --}}
                <div>

                    <h2 class="text-xl md:text-2xl font-semibold text-[#3B302A] mb-4">
                        Data yang Akan Dihapus
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600 text-sm md:text-base">

                        <div class="bg-gray-50 rounded-xl px-5 py-4">
                            • Informasi akun
                        </div>

                        <div class="bg-gray-50 rounded-xl px-5 py-4">
                            • Riwayat transaksi
                        </div>

                        <div class="bg-gray-50 rounded-xl px-5 py-4">
                            • Data profil pengguna
                        </div>

                        <div class="bg-gray-50 rounded-xl px-5 py-4">
                            • Data aktivitas aplikasi
                        </div>

                    </div>

                </div>

                {{-- Retensi --}}
                <div class="bg-[#F8F8F8] rounded-2xl p-6">

                    <h2 class="text-lg md:text-xl font-semibold text-[#3B302A] mb-3">
                        Informasi Tambahan
                    </h2>

                    <p class="text-gray-600 leading-relaxed text-xs md:text-sm">
                        Beberapa data tertentu dapat disimpan sementara untuk kebutuhan keamanan, pencegahan penyalahgunaan, atau kewajiban hukum yang berlaku sebelum dihapus sepenuhnya dari sistem.
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Footer --}}
    @include('landing.components.footer')

</div>

@endsection