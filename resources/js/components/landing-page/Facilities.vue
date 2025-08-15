<template>
    <div class="bg-[#EDF3FF] py-12" id="facilities">
        <div class="max-w-screen-xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0A1B59] mb-8">Fasilitas Apa Saja <span class="block"> Yang
                    Tersedia?
                </span></h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div v-for="(card, index) in facilities" :key="index"
                    class="rounded-xl shadow-md bg-gradient-to-b from-[#90C9FF] to-white p-4 hover:scale-105 transition-all duration-300">
                    <img :src="card.image" alt="Facility Image" class="w-full h-40 object-cover rounded-lg mb-4 " />
                    <h3 class="font-semibold text-lg text-[#0A1B59]">{{ card.title }}</h3>
                    <p class="text-sm text-gray-700 mt-2">{{ card.description }}</p>
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
