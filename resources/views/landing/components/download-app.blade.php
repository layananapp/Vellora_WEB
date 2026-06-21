<section class="w-full mt-6">

    <div class="w-full px-4">

        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 px-6 py-8 md:px-12 lg:ml-10 text-center lg:text-left">

            {{-- Left --}}
            <div class="flex flex-col sm:flex-row items-center gap-6">

                {{-- Logo --}}
                <div class="flex-shrink-0">

                    <img 
                        src="{{ asset('images/logo-v.png') }}"
                        alt="Vellora"
                        class="w-24 h-auto mx-auto sm:mx-0">

                </div>

                {{-- Text --}}
                <div>

                    <h2 class="text-2xl md:text-3xl font-bold text-[#1E1E1E]">

                        Download Aplikasi

                        <span class="text-pink-400">
                            Vellora
                        </span>

                    </h2>

                    <p class="text-base md:text-lg text-[#3B302A] mt-2 max-w-xl mx-auto sm:mx-0">

                        Belanja makin praktis, banyak promo eksklusif
                        dan pengalaman terbaik menunggumu!

                    </p>

                </div>

            </div>

            {{-- Right --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 lg:mr-20">

                {{-- Google Play --}}
                <a href="https://play.google.com/store/apps/details?id=com.layananapp.vellora"
                   class="bg-white border border-gray-200 rounded-2xl px-5 py-3 shadow-sm hover:shadow-md transition flex items-center gap-3">

                    {{-- Icon --}}
                    <img 
                        src="{{ asset('images/playstore-icon.png') }}"
                        alt="Play Store"
                        class="w-10 h-10 object-contain">

                    {{-- Text --}}
                    <div class="text-left">

                        <p class="text-xs text-gray-500 leading-none">
                            GET IT ON
                        </p>

                        <p class="text-lg font-bold text-[#1E1E1E] leading-tight mt-1">
                            Google Play
                        </p>

                    </div>

                </a>

                {{-- Phone Promo --}}
                <img 
                    src="{{ asset('images/phone-promo.png') }}"
                    alt="Phone"
                    class="w-20 h-auto">

            </div>

        </div>

    </div>

</section>