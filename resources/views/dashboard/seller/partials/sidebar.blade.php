<div
    x-data="{ open: false, openLogout: false }"
    @toggle-sidebar.window="open = !open"
>
    {{-- Backdrop for Mobile --}}
    <div 
        x-show="open" 
        @click="open = false" 
        class="fixed inset-0 bg-black/30 z-40 lg:hidden"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    ></div>

    {{-- Sidebar Container --}}
    <div
        class="fixed inset-y-0 left-0 z-50 w-60 h-screen bg-white border-r border-gray-200 p-6 flex flex-col justify-between transform transition-transform duration-300 lg:translate-x-0 lg:static lg:h-screen lg:w-56 lg:z-auto"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
    >
        <div>
            {{-- Logo & Close button for mobile --}}
            <div class="flex items-center justify-between lg:justify-center">
                <h1 class="text-3xl lg:text-4xl font-bold text-pink-300 tracking-tight">
                    Vellora
                </h1>
                <button @click="open = false" class="lg:hidden text-2xl text-gray-500 hover:text-black">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            {{-- Menu --}}
            <div class="mt-10 space-y-3">

                {{-- Beranda --}}
                <a href="{{ route('seller.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/dashboard') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-home-5-line text-xl"></i>
                    <span>Beranda</span>
                </a>

                {{-- Pesanan --}}
                <a href="{{ route('seller.pesanan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/pesanan*') || request()->is('seller/detail-pesanan*') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-file-list-3-line text-xl"></i>
                    <span>Pesanan</span>
                </a>

                {{-- Produk --}}
                <a href="{{ route('seller.produk') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/produk*') || request()->is('seller/detail-produk*') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-shopping-bag-3-line text-xl"></i>
                    <span>Produk</span>
                </a>

                {{-- Chat --}}
                <a href="{{ route('seller.chat') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/chat*') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-chat-3-line text-xl"></i>
                    <span>Chat</span>
                </a>

                {{-- Notifikasi --}}
                <a href="{{ route('seller.notifikasi') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/notifikasi*') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-notification-3-line text-xl"></i>
                    <span>Notifikasi</span>
                </a>

                {{-- Pengaturan --}}
                <a href="{{ route('seller.pengaturan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-full transition
                {{ request()->is('seller/pengaturan*') ? 'bg-pink-100 font-medium' : 'hover:bg-gray-100' }}">

                    <i class="ri-settings-3-line text-xl"></i>
                    <span>Pengaturan</span>
                </a>

            </div>
        </div>

        {{-- Logout --}}
        <div class="pt-6">
            <button
                type="button"
                @click="openLogout = true"
                class="flex items-center gap-3 px-4 py-3 rounded-full text-red-500 border border-red-300 hover:bg-red-50 transition w-full"
            >
                <i class="ri-logout-box-r-line text-xl"></i>
                <span>Logout</span>
            </button>
        </div>

        {{-- Modal Logout --}}
        <template x-teleport="body">
            <div
                x-show="openLogout"
                x-cloak
                class="fixed inset-0 z-[999999] flex items-center justify-center px-4"
            >
                {{-- Backdrop --}}
                <div
                    @click="openLogout = false"
                    class="absolute inset-0 bg-black/20"
                ></div>

                {{-- Modal --}}
                <div class="relative z-10 bg-[#F5F5F5] rounded-[35px] px-8 py-7 w-full max-w-[320px] text-center shadow-xl">
                    <i class="ri-logout-box-r-line text-5xl text-red-500"></i>

                    <h2 class="text-2xl font-bold mt-3">
                        Logout
                    </h2>

                    <p class="text-gray-700 mt-3 leading-relaxed text-base">
                        Apakah anda yakin ingin keluar dari akun?
                    </p>

                    <div class="flex justify-center gap-3 mt-6">
                        <button
                            type="button"
                            @click="openLogout = false"
                            class="bg-gray-200 px-5 py-2 rounded-full text-base font-medium hover:bg-gray-300 transition"
                        >
                            Batal
                        </button>

                        <form action="{{ route('logout') }}" method="POST">

                            @csrf

                            <button
                            type="submit"
                            class="bg-[#FF8FA3] px-5 py-2 rounded-full text-base font-medium hover:bg-pink-400 transition">

                                Ya, Logout

                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>