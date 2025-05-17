<template>
    <div class="md:bg-gradient-to-tr from-[#3967f4] via-[#6b8ced] to-[#EFF3FF] bg-[#557EF8] py-20" id="hero">
        <div class="max-w-screen-xl mx-auto px-6  grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <!-- Left Content -->
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-[#0A1B59] leading-tight">
                    Apa Sih <br />
                    <span class="text-white">Taman Sari Kost ?</span>
                </h1>
                <p class="text-white mt-6 text-sm md:text-base leading-relaxed text-justify">
                    Taman Sari Kost adalah pilihan kost yang menawarkan harga terjangkau dengan fasilitas nyaman, cocok
                    untuk mahasiswa dan pekerja.
                    Terletak di lokasi yang strategis, kost ini memudahkan akses ke berbagai pusat aktivitas seperti
                    kampus, perkantoran, dan pusat perbelanjaan.
                    Dengan lingkungan yang aman dan suasana yang nyaman, Taman Sari Kost menjadi tempat tinggal ideal
                    bagi Anda yang mencari hunian praktis dan ekonomis.
                </p>

                <!-- CTA Button -->
                <div class="mt-6 ">
                    <Link href="/register">

                    <button
                        class="flex items-center px-6 py-3 bg-[#0A1B59] text-white font-semibold rounded-full hover:bg-[#091749] transition">
                        Book Now
                        <span class="ml-3 bg-white text-[#0A1B59] rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 " fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </button>
                    </Link>
                </div>

                <!-- Stats -->
                <div class="mt-10 grid grid-cols-3 gap-4 text-center md:text-start text-white">
                    <div>
                        <div class="text-3xl hover:animate-bounce"><i class='bx bx-buildings '></i></div>
                        <div class="text-2xl font-bold">12</div>
                        <div class="text-sm mt-1">Room Total</div>
                    </div>
                    <div>
                        <div class="text-3xl  hover:animate-bounce"><i class='bx bx-star'></i></div>
                        <div class="text-2xl font-bold">4.8</div>
                        <div class="text-sm mt-1">Rating</div>
                    </div>
                    <div>
                        <div class="text-3xl  hover:animate-bounce"><i class='bx bx-user-voice'></i></div>
                        <div class="text-2xl font-bold">100</div>
                        <div class="text-sm mt-1">Happy Customer</div>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div v-if="isLaptop" class="relative w-full h-full">
                <!-- Rounded background circle -->
                <div class="absolute -top-8 -left-8 w-40 h-40 bg-lime-100 rounded-full z-0"></div>

                <!-- Image with border and rounded corners -->
                <div class="relative z-10 rounded-[32px] border border-[#0A1B59] overflow-hidden">
                    <img :src="Bangunan" alt=" Hero Image" class="w-full h-auto object-cover rounded-[32px] p-5" />
                </div>
            </div>

            <div v-else class="relative w-full h-full">
                <!-- Rounded background circle -->
                <!-- <div class="absolute -top-8 -left-8 w-40 h-40 bg-lime-100 rounded-full z-0"></div> -->

                <!-- Image with border and rounded corners -->
                <div class="relative z-10 rounded-[32px] border border-[#0A1B59] overflow-hidden">
                    <img :src="Bangunan" alt=" Hero Image" class="w-full h-auto object-cover rounded-[32px] p-5" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import Bangunan from '../../../assets/images/Bangunan.png'
import { Link } from '@inertiajs/inertia-vue3'

const isLaptop = ref(false)

const checkScreen = () => {
    isLaptop.value = window.innerWidth >= 768
}

onMounted(() => {
    checkScreen()
    window.addEventListener('resize', checkScreen)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', checkScreen)
})
</script>