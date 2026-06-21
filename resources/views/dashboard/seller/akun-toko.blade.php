@extends('layouts.app')

@section('title', 'Akun Toko')

@php
    $apiUrl = config('services.marketplace_api.url');
@endphp

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

            {{-- ALERT --}}
            @if (session('success'))

                <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-2xl">

                    {{ session('success') }}

                </div>

            @endif

            @if (session('error'))

                <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-5 py-3 rounded-2xl">

                    {{ session('error') }}

                </div>

            @endif

            {{-- BREADCRUMB --}}
            <div class="flex flex-wrap items-center gap-2 md:gap-3">

                <a href="/seller/pengaturan">

                    <i class="ri-arrow-left-line text-3xl md:text-4xl"></i>

                </a>

                <h2 class="text-2xl md:text-3xl font-bold">
                    Pengaturan
                </h2>

                <i class="ri-arrow-right-s-line text-xl md:text-2xl"></i>

                <h2 class="text-2xl md:text-3xl font-bold">
                    Akun Toko
                </h2>

            </div>

            <p class="text-gray-500 md:ml-14 mt-1 text-base md:text-lg">
                Atur referensi dan akun toko.
            </p>

            {{-- FORM --}}
            <form
            action="{{ route('seller.update-akun-toko') }}"
            method="POST"
            enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- CONTENT --}}
                <div class="flex flex-col md:flex-row gap-6 md:gap-16 mt-8 md:ml-12 items-center md:items-start bg-white p-6 md:p-10 rounded-3xl border border-gray-100 shadow-sm max-w-3xl">

                    {{-- LEFT --}}
                    <div class="flex-shrink-0 text-center">

                        <h3 class="font-bold text-lg mb-4">
                            Logo Toko
                        </h3>

                        <div x-data="{ preview: null }">

                            <label
                            class="w-32 h-32 rounded-full border-[3px] border-black flex items-center justify-center overflow-hidden cursor-pointer mx-auto">

                                {{-- PREVIEW BARU --}}
                                <template x-if="preview">

                                    <img
                                    :src="preview"
                                    class="w-full h-full object-cover">

                                </template>

                                {{-- LOGO LAMA --}}
                                <template x-if="!preview">

                                    @if(isset($store['store_logo']) && $store['store_logo'])

                                        <img
                                        src="{{ $apiUrl . '/' . $store['store_logo'] }}"
                                        class="w-full h-full object-cover">

                                    @else

                                        <i class="ri-user-settings-line text-7xl"></i>

                                    @endif

                                </template>

                                <input
                                type="file"
                                name="store_logo"
                                class="hidden"
                                @change="
                                    preview =
                                    URL.createObjectURL(
                                        $event.target.files[0]
                                    )
                                ">

                            </label>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex-1 w-full space-y-5">

                        {{-- NAMA TOKO --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Nama Toko
                            </label>

                            <input
                            type="text"
                            name="store_name"
                            value="{{ old('store_name', $store ? ($store['store_name'] ?? '') : '') }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent">

                        </div>

                        {{-- EMAIL --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Email Toko/Akun
                            </label>

                            <input
                            type="email"
                            value="{{ $user['email'] ?? '' }}"
                            readonly
                            class="w-full border-2 border-gray-300 rounded-full px-5 py-2 outline-none bg-gray-100 cursor-not-allowed">

                        </div>

                        {{-- NAMA PEMILIK --}}
                        <div>

                            <label class="block font-bold mb-1">
                                Nama Pemilik/Akun
                            </label>

                            <input
                            type="text"
                            value="{{ $user['name'] ?? '' }}"
                            readonly
                            class="w-full border-2 border-gray-300 rounded-full px-5 py-2 outline-none bg-gray-100 cursor-not-allowed">

                        </div>

                        {{-- NO HP --}}
                        <div>

                            <label class="block font-bold mb-1">
                                No. Tlp
                            </label>

                            <input
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $store ? ($store['phone_number'] ?? '') : '') }}"
                            class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent">

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-center md:justify-end mt-8 md:mt-12 max-w-3xl">

                    <button
                    type="submit"
                    class="bg-[#FF8FA3] hover:bg-pink-400 transition px-8 py-3 rounded-full font-bold text-lg md:text-xl w-full sm:w-auto">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection