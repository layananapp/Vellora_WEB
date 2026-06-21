@extends('layouts.app')

@section('title', 'Vellora')

@section('content')

    @include('landing.components.navbar')

    @include('landing.components.hero')

    @include('landing.components.download-app')

    @include('landing.components.categories')

    {{-- CTA Section --}}
    <div class="pt-10 mb-10 border-t border-gray-300">

        <div class="text-center">

            <h2 class="text-3xl font-bold text-[#1E1E1E]">
                Tertarik menjadi bagian dari Vellora?
            </h2>

            <p class="text-gray-500 mt-3 text-sm">
                Mulai perjalanan bisnismu bersama marketplace modern Vellora.
            </p>

            <div class="mt-6">

                <button class="border border-pink-400 text-pink-400 hover:bg-pink-400 hover:text-white transition px-8 py-3 rounded-full font-semibold">
                    Mulai Berjualan
                </button>

            </div>

        </div>

    </div>

    @include('landing.components.footer')

    <!-- @include('landing.components.modals.welcome-modal')

    @include('landing.components.modals.shipping-modal')

    @include('landing.components.modals.payment-modal') -->

@endsection