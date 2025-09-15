<template>
    <div class="bg-[#EDF3FF] py-16" id="facilities">
        <div class="max-w-screen-xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0A1B59] mb-8">Fasilitas Apa Saja <span class="block"> Yang
                    Tersedia?
                </span></h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div v-for="(card, index) in facilities" :key="index"
                    class="rounded-xl shadow-lg bg-white p-6 flex flex-col items-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group border border-[#90C9FF]">
                    <div
                        class="bg-gradient-to-tr from-[#90C9FF] to-[#EDF3FF] rounded-full p-4 mb-4 shadow-md group-hover:scale-110 transition-transform duration-300">
                        <img :src="card.image" alt="Facility Image" class="w-24 h-24 object-cover rounded-full" />
                    </div>
                    <h3
                        class="font-bold text-xl text-[#0A1B59] mb-2 text-center group-hover:text-[#2563eb] transition-colors duration-300">
                        {{ card.title }}</h3>
                    <p class="text-base text-gray-600 text-center">{{ card.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import kamar1 from '../../../assets/Images/Kamar1.png'

const facilities = [
    {
        title: 'Kamar Luas',
        description: 'Terdapat kamar tidur yang luas dan nyaman, dilengkapi dengan dapur dan kamar mandi pribadi.',
        image: kamar1, // ganti dengan URL atau file lokal sesuai kebutuhanmu
    },
    {
        title: 'Area Parkir',
        description: 'Tersedia area parkir yang cukup nyaman bagi kendaraan bermotor anda.',
        image: kamar1,
    },
    {
        title: 'Gratis Biaya Lainnya',
        description: 'tidak ada biaya tambahan untuk fasilitas lainnya seperti iuran sampah dan air',
        image: kamar1,
    },

];
</script>
