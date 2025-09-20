<template>
    <div class="bg-[#EDF3FF] py-16 md:mt-10" id="facilities">
        <div class="max-w-screen-xl mx-auto px-6">
            <p class="text-[#0A1B59]">Facilities</p>
            <h2 class="text-3xl md:text-4xl font-bold text-[#0A1B59] mb-8">Fasilitas Yang
                Tersedia
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div v-for="(card, index) in facilities" :key="index"
                    class="rounded-xl shadow-lg bg-white p-6 flex flex-col items-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group border border-[#90C9FF]">
                    <div
                        class="bg-gradient-to-tr from-[#90C9FF] to-[#EDF3FF] rounded-full p-4 mb-4 shadow-md group-hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                        <i :class="`${card.icon} text-5xl text-[#0A1B59]`"></i>
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
const facilities = [
    {
        title: 'Kamar Luas',
        description: 'Terdapat kamar tidur yang luas dan nyaman, dilengkapi dengaan dapur dan kamar mandi pribadi.',
        icon: 'bx bx-building',
    },
    {
        title: 'Area Parkir',
        description: 'Tersedia area parkir yang cukup nyaman bagi kendaraan bermotor anda.',
        icon: 'bx bxs-parking',
    },
    {
        title: 'Gratis Biaya Lainnya',
        description: 'tidak ada biaya tambahan lainnya selain biaya sewa kamar.',
        icon: 'bx bx-gift',
    },
];
</script>
