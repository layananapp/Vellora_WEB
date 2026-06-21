@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')

<div class="min-h-screen bg-[#FFF8F8] pb-12">

    {{-- TOPBAR --}}
    <div class="h-12 bg-gradient-to-r from-pink-100 to-[#DCE8B4] flex items-center justify-between px-4 md:px-10">

        {{-- LOGO --}}
        <div class="flex items-center gap-2">

            <h1 class="text-xl md:text-2xl font-bold text-[#F07A8D]">
                Vellora
            </h1>

            <span class="text-base md:text-lg font-bold text-gray-500">
                Seller
            </span>

        </div>

        {{-- RIGHT --}}
        <p class="text-sm md:text-base">
            Butuh bantuan?
            <span class="text-[#FF5A5A] font-semibold cursor-pointer">
                Hubungi Kami
            </span>
        </p>

    </div>

    {{-- CONTENT --}}
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-16 px-4 md:px-10 py-10">

        {{-- LEFT --}}
        <div class="w-full max-w-[420px] text-center">

            {{-- TITLE --}}
            <h2 class="text-3xl md:text-4xl font-bold leading-snug">
                Masukkan
                <span class="text-[#F07A8D]">
                    Kode OTP
                </span>
            </h2>

            <p class="text-lg md:text-2xl mt-3 leading-relaxed text-gray-700">
                Kami telah mengirimkan kode verifikasi ke email anda
            </p>

            {{-- ICON --}}
            <div class="flex justify-center mt-6 md:mt-10">

                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-[#FFE5EA] flex items-center justify-center shadow-sm">
                    <i class="ri-mail-lock-line text-4xl md:text-6xl text-[#F07A8D]"></i>
                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div
        x-data="{
            otp: ['', '', '', ''],
            time: 179,
            get combinedOtp() {
                return this.otp.join('');
            },
            get minutes() {
                return String(Math.floor(this.time / 60)).padStart(2, '0')
            },
            get seconds() {
                return String(this.time % 60).padStart(2, '0')
            },
            start() {
                setInterval(() => {
                    if (this.time > 0) {
                        this.time--
                    }
                }, 1000)
            },
            handleInput(e, index) {
                let val = e.target.value.replace(/[^0-9]/g, '');
                this.otp[index] = val;
                if (val && index < 3) {
                    this.$refs['otp' + (index + 1)].focus();
                }
            },
            handleKeydown(e, index) {
                if (e.key === 'Backspace' && !this.otp[index] && index > 0) {
                    this.otp[index - 1] = '';
                    this.$refs['otp' + (index - 1)].focus();
                }
            }
        }"
        x-init="start()"
        class="w-full max-w-[400px] bg-white rounded-[30px] px-6 py-10 md:px-10 md:py-12 shadow-md border border-gray-100">

            {{-- TITLE --}}
            <h1 class="text-2xl md:text-3xl font-bold text-center">
                Verifikasi OTP
            </h1>

            <p class="text-center text-sm md:text-base mt-2 leading-relaxed text-gray-500">
                Masukkan kode OTP yang kami kirim ke email anda ({{ session('reset_email') }})
            </p>

            @if(session('success'))
                <div class="mt-4 rounded-2xl bg-green-500/10 border border-green-200 px-5 py-3 text-green-600 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 rounded-2xl bg-red-500/10 border border-red-200 px-5 py-3 text-red-600 text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('verifikasi-kode.verify') }}" method="POST" class="mt-8">
                @csrf
                <input type="hidden" name="otp" :value="combinedOtp">

                {{-- OTP Inputs --}}
                <div class="flex justify-center gap-2 md:gap-4">

                    <input
                    type="text"
                    maxlength="1"
                    x-model="otp[0]"
                    x-ref="otp0"
                    @input="handleInput($event, 0)"
                    @keydown="handleKeydown($event, 0)"
                    class="w-12 h-12 md:w-14 md:h-14 border border-gray-300 rounded-lg text-center text-xl md:text-2xl outline-none focus:border-pink-300 transition">

                    <input
                    type="text"
                    maxlength="1"
                    x-model="otp[1]"
                    x-ref="otp1"
                    @input="handleInput($event, 1)"
                    @keydown="handleKeydown($event, 1)"
                    class="w-12 h-12 md:w-14 md:h-14 border border-gray-300 rounded-lg text-center text-xl md:text-2xl outline-none focus:border-pink-300 transition">

                    <input
                    type="text"
                    maxlength="1"
                    x-model="otp[2]"
                    x-ref="otp2"
                    @input="handleInput($event, 2)"
                    @keydown="handleKeydown($event, 2)"
                    class="w-12 h-12 md:w-14 md:h-14 border border-gray-300 rounded-lg text-center text-xl md:text-2xl outline-none focus:border-pink-300 transition">

                    <input
                    type="text"
                    maxlength="1"
                    x-model="otp[3]"
                    x-ref="otp3"
                    @input="handleInput($event, 3)"
                    @keydown="handleKeydown($event, 3)"
                    class="w-12 h-12 md:w-14 md:h-14 border border-gray-300 rounded-lg text-center text-xl md:text-2xl outline-none focus:border-pink-300 transition">

                </div>

                {{-- TIMER --}}
                <div class="text-center mt-6">

                    <p class="text-sm text-gray-500">
                        Kode akan kadaluarsa dalam
                        <span class="text-[#FF6A6A] font-semibold">
                            <span x-text="minutes"></span>:<span x-text="seconds"></span>
                        </span>
                    </p>

                </div>

                {{-- BUTTON --}}
                <button
                type="submit"
                :disabled="combinedOtp.length !== 4"
                :class="combinedOtp.length === 4 ? 'bg-pink-100 hover:bg-pink-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                class="w-full h-[50px] rounded-full text-lg md:text-xl font-bold mt-6 transition flex items-center justify-center">
                    Verifikasi
                </button>
            </form>

            {{-- RESEND --}}
            <div class="flex justify-center mt-6">
                <form action="{{ route('lupa-password.send') }}" method="POST" id="resend-form" style="display: none;">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                </form>
                <button
                type="button"
                onclick="document.getElementById('resend-form').submit()"
                class="text-[#FF6A6A] text-sm md:text-base font-semibold hover:underline focus:outline-none">
                    Kirim ulang kode
                </button>

            </div>

            {{-- BACK --}}
            <div class="flex justify-center mt-8">

                <a
                href="{{ route('login') }}"
                class="flex items-center gap-2 text-base md:text-lg font-semibold hover:text-[#F07A8D] transition">
                    <i class="ri-arrow-left-line text-2xl"></i>
                    <span>Kembali ke Login</span>
                </a>

            </div>

        </div>

    </div>

</div>

@endsection