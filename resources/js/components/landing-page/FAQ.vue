<script setup>
import { ref } from 'vue'

// Menyimpan state terbuka/tidak dari setiap FAQ
const isOpen = ref([false, false])

const faqItems = [
    {
        question: 'Rules adalah Taman Sari Kost',
        answer: '....',
    },
    {
        question: 'Bagaimana Cara Pembayaran di Taman Sari Kost?',
        answer: '....',
    },
    {
        question: ' Apakah ada biaya tambahan selain sewa kamar?',
        answer: '....',
    },
    {
        question: 'Apakah saya bisa memperpanjang kontrak setelah masa sewa berakhir?',
        answer: '....',
    }
]

// Fungsi untuk toggle
function toggle(index) {
    isOpen.value[index] = !isOpen.value[index]
}
</script>

<template>
    <div class="relative bg-[#EDF3FF] py-12 md:pb-32 overflow-hidden " id="faq">

        <!-- Lingkaran  -->
        <div class="absolute -left-28 top-1/2 transform -translate-y-1/2 z-0 md:block hidden">
            <div class="w-72 h-72 bg-blue-300 opacity-30 rounded-full"></div>
        </div>
        <div class="absolute md:left-28 top-0 -right-[20%] md:-right-0 md:transform md:translate-y-48 md:bottom-1 z-0">
            <div class="w-52 h-52 bg-blue-300 opacity-20 rounded-full"></div>
        </div>



        <!-- Konten FAQ -->
        <div class="relative z-10 max-w-screen-xl mx-auto px-6">
            <div class="flex flex-col md:flex-row">
                <div class="flex-1 mb-6 md:mb-0">
                    <p class="text-[#0A1B59]">FAQ</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0A1B59] mb-2 md:mb-8">
                        Frequently Asked <span class="block">Question</span>
                    </h2>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col gap-4">
                        <!-- Item 1 -->
                        <div class="w-full bg-white shadow-lg rounded-xl" v-for="(item, index) in faqItems"
                            :key="index">
                            <div class="flex justify-between items-center">
                                <h3 class="font-bold text-[#0A1B59] md:text-xl text-l p-4">
                                    {{ item.question }}
                                </h3>
                                <button class="text-[#0A1B59] p-3 pr-5" @click="toggle(index)">
                                    <i :class="['bx', isOpen[index] ? 'bx-minus' : 'bx-plus']"></i>
                                </button>
                            </div>
                            <p v-show="isOpen[index]" class="px-4 pb-4 text-sm text-gray-700">
                                {{ item.answer }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
