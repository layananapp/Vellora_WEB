{{-- TOP BAR --}}
<div class="h-20 md:h-24 bg-white border-b border-gray-200 flex items-center justify-between lg:justify-end px-4 md:px-8">

    {{-- Hamburger Trigger (Mobile Only) --}}
    <button 
        type="button" 
        @click="$dispatch('toggle-sidebar')" 
        class="lg:hidden p-2 text-gray-700 hover:text-pink-500 transition text-2xl md:text-3xl focus:outline-none"
    >
        <i class="ri-menu-line"></i>
    </button>

    <div class="flex items-center gap-4 md:gap-6">

        <a href="/admin/notifikasi" class="relative">
            <i class="ri-notification-3-line text-2xl text-gray-500 hover:text-pink-500 transition"></i>
        </a>

        <div class="flex items-center gap-3">

            <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name', 'Admin')) }}&background=FF8FA3&color=fff"
                 class="w-11 h-11 rounded-full object-cover">

            <h3 class="font-bold text-base text-gray-800">
                {{ session('user.name', 'Admin') }}
            </h3>

        </div>

    </div>

</div>
