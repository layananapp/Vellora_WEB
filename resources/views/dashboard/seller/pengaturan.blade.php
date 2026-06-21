@extends('layouts.app')

@section('title', 'Pengaturan Seller')

@section('content')

<div class="min-h-screen bg-[#FFF9F9] flex flex-col lg:flex-row" x-data>

    {{-- SIDEBAR --}}
    @include('dashboard.seller.partials.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 w-full">

        {{-- TOPBAR --}}
        @include('dashboard.seller.partials.topbar')

        {{-- MAIN --}}
        <div class="p-4 md:p-6">

            {{-- Left --}}
            <div>

                <div class="flex items-center gap-3">

                    <a href="/seller/dashboard">

                        <i class="ri-arrow-left-line text-3xl md:text-4xl text-black"></i>

                    </a>

                    <h2 class="text-2xl md:text-3xl font-bold">
                        Pengaturan
                    </h2>

                </div>

                <p class="text-gray-500 mt-2 md:ml-12 text-sm md:text-base">
                    Kelola pengaturan akun dan toko anda
                </p>

            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-3xl shadow-sm mt-6 p-6">

                {{-- MENU --}}
                <div class="space-y-4">

                    {{-- AKUN TOKO --}}
                    <a
                    href="{{ route('seller.akun-toko') }}"
                    class="flex items-center justify-between px-5 py-5 rounded-2xl hover:bg-pink-50 transition group">

                        {{-- LEFT --}}
                        <div class="flex items-center gap-4">

                            <div class="w-14 h-14 rounded-2xl bg-pink-100 flex items-center justify-center">

                                <i class="ri-store-2-line text-2xl text-pink-400"></i>

                            </div>

                            <div>

                                <h3 class="text-xl font-bold">
                                    Akun Toko
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Kelola informasi dan profil toko
                                </p>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <i class="ri-arrow-right-s-line text-3xl text-gray-400 group-hover:text-pink-400 transition"></i>

                    </a>

                    {{-- AKUN --}}
                    <a
                    href="{{ route('seller.akun') }}"
                    class="flex items-center justify-between px-5 py-5 rounded-2xl hover:bg-pink-50 transition group">

                        {{-- LEFT --}}
                        <div class="flex items-center gap-4">

                            <div class="w-14 h-14 rounded-2xl bg-[#DDE8C8] flex items-center justify-center">

                                <i class="ri-user-3-line text-2xl"></i>

                            </div>

                            <div>

                                <h3 class="text-xl font-bold">
                                    Akun
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Atur informasi akun dan keamanan
                                </p>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        <i class="ri-arrow-right-s-line text-3xl text-gray-400 group-hover:text-pink-400 transition"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection