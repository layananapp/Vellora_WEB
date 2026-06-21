@extends('layouts.app')

@section('title', 'Akun')

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
                    Akun
                </h2>

            </div>

            <p class="text-gray-500 md:ml-14 mt-1 text-base md:text-lg">
                Kelola informasi akun dan login anda
            </p>

            {{-- FORM --}}
            <form
            action="{{ route('seller.update-akun') }}"
            method="POST"
            class="md:ml-14 mt-6 w-full max-w-[380px] bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">

                @csrf
                @method('PUT')

                {{-- EMAIL --}}
                <div class="mb-4">

                    <label class="block font-bold mb-1">
                        Email Login
                    </label>

                    <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user['email'] ?? '') }}"
                    readonly
                    class="w-full border-2 border-gray-300 rounded-full px-5 py-2 outline-none bg-gray-100 text-sm cursor-not-allowed">

                </div>

                {{-- USERNAME --}}
                <div class="mb-6">

                    <label class="block font-bold mb-1">
                        Username
                    </label>

                    <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user['name'] ?? '') }}"
                    class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent text-sm">

                </div>

                {{-- PASSWORD --}}
                <h3 class="text-xl md:text-2xl font-bold mb-4 pt-4 border-t border-gray-100">

                    Ubah Password

                    <span class="text-gray-500 text-lg">
                        (Opsional)
                    </span>

                </h3>

                {{-- PASSWORD LAMA --}}
                <div class="mb-4">

                    <label class="block font-bold mb-1">
                        Password saat ini
                    </label>

                    <input
                    type="password"
                    name="current_password"
                    class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent text-sm">

                </div>

                {{-- PASSWORD BARU --}}
                <div class="mb-4">

                    <label class="block font-bold mb-1">
                        Password Baru
                    </label>

                    <input
                    type="password"
                    name="new_password"
                    class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent text-sm">

                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label class="block font-bold mb-1">
                        Konfirmasi Password Baru
                    </label>

                    <input
                    type="password"
                    name="confirm_password"
                    class="w-full border-2 border-gray-500 rounded-full px-5 py-2 outline-none bg-transparent text-sm">

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-center md:justify-end mt-8">

                    <button
                    type="submit"
                    class="bg-[#FF8FA3] hover:bg-pink-400 transition px-7 py-2.5 rounded-full font-bold text-lg md:text-xl w-full sm:w-auto">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection