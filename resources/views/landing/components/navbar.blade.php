<nav class="w-full pt-6" x-data="{ open: false }">

    {{-- Container --}}
    <div class="w-full px-4">

        {{-- Top Bar --}}
        <div class="bg-[#DDE8C8] rounded-t-xl px-4 md:px-10 py-3 flex items-center gap-3">

            <i class="ri-truck-line text-[#FF8E8E] text-xl"></i>

            <p class="text-sm font-medium text-[#3B302A]">
                Gratis Pengiriman untuk Semua Order
            </p>

        </div>

        {{-- Main Navbar --}}
        <div class="bg-white px-4 md:px-10 py-5 flex items-center justify-between">

            {{-- Logo --}}
            <a href="/">
                <h1 class="text-3xl md:text-5xl font-bold text-[#F7CACA]">
                    Vellora
                </h1>
            </a>

            {{-- Menu (Desktop) --}}
            <div class="hidden md:flex items-center gap-8 font-semibold text-lg text-[#1E1E1E]">

                <a
                href="/products/fashion"
                class="hover:text-[#F07A8D] transition">

                    Belanja

                </a>

                <a
                href="/tentang-kami"
                class="hover:text-[#F07A8D] transition">

                    Tentang

                </a>

                <a
                href="#"
                class="hover:text-[#F07A8D] transition">

                    Bantuan

                </a>

            </div>

            {{-- AUTH (Desktop) --}}
            <div class="hidden md:flex items-center gap-4">

                @if(session()->has('user'))

                    {{-- USER --}}
                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-full bg-[#FDECEC] flex items-center justify-center">

                            <i class="ri-user-3-line text-xl text-[#F07A8D]"></i>

                        </div>

                        <div class="leading-tight">

                            <p class="font-bold text-sm text-[#1E1E1E]">
                                {{ session('user')['name'] }}
                            </p>

                            <p class="text-xs text-gray-500 capitalize">
                                {{ session('role') }}
                            </p>

                        </div>

                    </div>

                    {{-- DASHBOARD --}}
                    @if(session('role') === 'seller')

                        <a
                        href="{{ route('seller.dashboard') }}"
                        class="h-[44px] px-5 rounded-full bg-[#FDECEC] text-[#F07A8D] font-semibold flex items-center gap-2 hover:bg-pink-100 transition">

                            <i class="ri-store-2-line text-lg"></i>

                            Dashboard

                        </a>

                    @endif

                    @if(session('role') === 'admin')

                        <a
                        href="{{ route('admin.dashboard') }}"
                        class="h-[44px] px-5 rounded-full bg-[#FDECEC] text-[#F07A8D] font-semibold flex items-center gap-2 hover:bg-pink-100 transition">

                            <i class="ri-shield-user-line text-lg"></i>

                            Dashboard

                        </a>

                    @endif

                    {{-- LOGOUT --}}
                    <form
                    action="{{ route('logout') }}"
                    method="POST">

                        @csrf

                        <button
                        type="submit"
                        class="h-[44px] px-5 rounded-full bg-[#F07A8D] text-white font-semibold flex items-center gap-2 hover:bg-[#eb6c80] transition">

                            <i class="ri-logout-box-r-line text-lg"></i>

                            Logout

                        </button>

                    </form>

                @else

                    {{-- LOGIN --}}
                    <a
                    href="/login"
                    class="flex items-center gap-2 hover:text-[#F07A8D] transition">

                        <i class="ri-user-line text-3xl"></i>

                        <span class="font-semibold">
                            Masuk
                        </span>

                    </a>

                @endif

            </div>

            {{-- Hamburger Button (Mobile) --}}
            <button @click="open = !open" class="md:hidden text-3xl text-[#1E1E1E] focus:outline-none">
                <i :class="open ? 'ri-close-line' : 'ri-menu-line'"></i>
            </button>

        </div>

        {{-- Mobile Dropdown Menu --}}
        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="md:hidden bg-white border-t border-gray-100 px-6 py-4 flex flex-col gap-4 shadow-lg rounded-b-xl"
            style="display: none;"
        >
            <a href="/products/fashion" class="font-semibold text-lg text-[#1E1E1E] hover:text-[#F07A8D] transition py-2 border-b border-gray-50">Belanja</a>
            <a href="/tentang-kami" class="font-semibold text-lg text-[#1E1E1E] hover:text-[#F07A8D] transition py-2 border-b border-gray-50">Tentang</a>
            <a href="#" class="font-semibold text-lg text-[#1E1E1E] hover:text-[#F07A8D] transition py-2 border-b border-gray-50">Bantuan</a>

            {{-- Mobile Auth --}}
            <div class="pt-4 border-t border-gray-100 flex flex-col gap-4">
                @if(session()->has('user'))
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-[#FDECEC] flex items-center justify-center">
                            <i class="ri-user-3-line text-xl text-[#F07A8D]"></i>
                        </div>
                        <div class="leading-tight">
                            <p class="font-bold text-sm text-[#1E1E1E]">
                                {{ session('user')['name'] }}
                            </p>
                            <p class="text-xs text-gray-500 capitalize">
                                {{ session('role') }}
                            </p>
                        </div>
                    </div>

                    @if(session('role') === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="h-[44px] px-5 rounded-full bg-[#FDECEC] text-[#F07A8D] font-semibold flex items-center justify-center gap-2 hover:bg-pink-100 transition">
                            <i class="ri-store-2-line text-lg"></i>
                            Dashboard Seller
                        </a>
                    @endif

                    @if(session('role') === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="h-[44px] px-5 rounded-full bg-[#FDECEC] text-[#F07A8D] font-semibold flex items-center justify-center gap-2 hover:bg-pink-100 transition">
                            <i class="ri-shield-user-line text-lg"></i>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full h-[44px] px-5 rounded-full bg-[#F07A8D] text-white font-semibold flex items-center justify-center gap-2 hover:bg-[#eb6c80] transition">
                            <i class="ri-logout-box-r-line text-lg"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="flex items-center justify-center gap-2 py-3 bg-[#FDECEC] text-[#F07A8D] rounded-full hover:bg-pink-100 transition">
                        <i class="ri-user-line text-xl"></i>
                        <span class="font-semibold">Masuk</span>
                    </a>
                @endif
            </div>
        </div>

    </div>

</nav>