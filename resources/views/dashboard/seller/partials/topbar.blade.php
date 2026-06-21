@php
    $apiUrl = config('services.marketplace_api.url');
@endphp
{{-- TOP BAR --}}
<div class="h-20 md:h-24 bg-gradient-to-r from-pink-100 to-[#DDE8C8] flex items-center justify-between lg:justify-end px-4 md:px-8 rounded-bl-3xl">

    {{-- Hamburger Trigger (Mobile Only) --}}
    <button 
        type="button" 
        @click="$dispatch('toggle-sidebar')" 
        class="lg:hidden p-2 text-gray-700 hover:text-pink-500 transition text-2xl md:text-3xl focus:outline-none"
    >
        <i class="ri-menu-line"></i>
    </button>

    <div class="flex items-center gap-3">

        <i class="ri-notification-3-line text-2xl md:text-3xl"></i>

        <img
        src="{{ isset($store) && $store['store_logo']
        ? $apiUrl . '/' . $store['store_logo']
        : asset('images/profile-store.png') }}"
        alt=""
        class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover">

        <h3 class="font-bold text-sm md:text-lg">
            {{ $store ? ($store['store_name'] ?? 'TokoKu') : 'TokoKu' }}
        </h3>

    </div>

</div>