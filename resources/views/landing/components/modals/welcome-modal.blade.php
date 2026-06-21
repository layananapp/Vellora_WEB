<div id="welcomeModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    {{-- Modal Box --}}
    <div class="bg-white w-full max-w-[500px] mx-4 rounded-[32px] md:rounded-[40px] shadow-2xl px-6 py-8 md:px-10 md:py-10 relative">

        {{-- Close Button --}}
        <button
                onclick="
            document.getElementById('welcomeModal').style.display='none';
            document.getElementById('shippingModal').style.display='flex';
            "
            class="absolute top-5 right-6 text-2xl font-bold text-gray-400 hover:text-black">
            ×
        </button>

        {{-- Logo --}}
        <div class="flex justify-center">

            <h1 class="text-7xl font-bold text-pink-200">
                V
            </h1>

        </div>

        {{-- Title --}}
        <div class="text-center mt-4">

            <h2 class="text-2xl md:text-4xl font-bold text-[#1E1E1E]">
                Selamat Datang di
            </h2>

            <h3 class="text-2xl md:text-4xl font-bold text-pink-400 mt-2">
                Vellora!
            </h3>

        </div>

        {{-- Description --}}
        <p class="text-center text-gray-600 mt-6 text-base md:text-lg leading-relaxed">
            Temukan berbagai produk terbaik
            hanya untukmu
        </p>

        {{-- Button --}}
        <div class="flex justify-center mt-8">

            <button class="bg-pink-400 hover:bg-pink-500 transition text-white font-bold px-8 py-3 rounded-full text-base md:text-lg">
                Belanja Sekarang
            </button>

        </div>

    </div>

</div>