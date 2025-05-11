<template>
    <div class="bg-[#EDF3FF] py-12">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-[#0A1B59] mb-8">Fasilitas Apa Saja Yang Tersedia?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div v-for="(card, index) in facilities" :key="index"
                    class="rounded-xl shadow-md bg-gradient-to-b from-[#90C9FF] to-white p-4">
                    <img :src="card.image" alt="Facility Image" class="w-full h-40 object-cover rounded-lg mb-4" />
                    <h3 class="font-semibold text-lg text-[#0A1B59]">{{ card.title }}</h3>
                    <p class="text-sm text-gray-700 mt-2">{{ card.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import kamar1 from '../../assets/Images/Kamar1.png'

const facilities = [
    {
        title: 'Big Room',
        description: 'leo. tincidunt Ut Vestibulum tincidunt placerat vitae faucibus Sed tincidunt faucibus sit tincidunt tempor Sed amet, Cras',
        image: kamar1, // ganti dengan URL atau file lokal sesuai kebutuhanmu
    },
    {
        title: 'Parking Area',
        description: 'leo. tincidunt Ut Vestibulum tincidunt placerat vitae faucibus Sed tincidunt faucibus sit tincidunt tempor Sed amet, Cras',
        image: kamar1,
    },
    {
        title: 'Free Other Cost',
        description: 'leo. tincidunt Ut Vestibulum tincidunt placerat vitae faucibus Sed tincidunt faucibus sit tincidunt tempor Sed amet, Cras',
        image: kamar1,
    },
];
</script>
