<script setup>
import { ref } from 'vue'

// Menyimpan state terbuka/tidak dari setiap FAQ
const isOpen = ref([false, false, false, false])

const faqItems = [
    {
        question: 'Rules adalah Taman Sari Kost',
        answer: `
            <ul>
                <li><strong>1.</strong> Dilarang membuat kerusuhan dan mengganggu penghuni lain!</li>
                <li><strong>2.</strong> Dilarang membawa hewan peliharaan!</li>
                <li><strong>3.</strong> Dilarang membawa anak kecil!</li>
                <li><strong>4.</strong> Batas tamu berkunjung sampai jam 10 malam (22.00)</li>
            </ul>
        `,
    },
    {
        question: 'Bagaimana Cara Pembayaran di Taman Sari Kost?',
        answer: `
            <ul>
                <li><strong>1.</strong> Pembayaran dilakukan melalui transfer bank/tunai.</li>
                <li><strong>2.</strong> Bukti transfer dikirimkan melalui Website (transfer).</li>
                <li><strong>3.</strong> Pengelola akan melakukan pengecekan (transfer).</li> 
                <li><strong>4.</strong> Setelah pengecekan, pengelola akan mengkonfirmasi pembayaran (transfer).</li> 
            </ul>
        `,
    },
    {
        question: 'Apakah ada biaya tambahan selain sewa kamar?',
        answer: `
        <p>Tidak ada Biaya Tambahan Lainnya terkecuali <strong>biaya listrik</strong> dan itu menjadi tanggung jawab pribadi karena masing - masing kamar sudah disediakan <strong>Token </strong>sendiri - sendiri</p>
           
        `,
    },
    {
        question: 'Apakah saya bisa memperpanjang kontrak setelah masa sewa berakhir?',
        answer: `
            <ul>
                <li><strong>1.</strong> Ya, Anda dapat memperpanjang kontrak dengan melakukan pembayaran tepat waktu.</li>
                <li><strong>2.</strong> Keterlambatan di toleransi selama 1 Minggu</li>
            </ul>
        `,
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
                        <!-- Item FAQ -->
                        <div class="w-full bg-white shadow-lg rounded-xl" v-for="(item, index) in faqItems"
                            :key="index">
                            <div class="flex justify-between items-center cursor-pointer" @click="toggle(index)">
                                <h3 class="font-semibold text-[#0A1B59]  md:text-lg p-4">
                                    {{ item.question }}
                                </h3>
                                <button class="text-[#0A1B59] p-3 pr-5">
                                    <i :class="['bx', isOpen[index] ? 'bx-minus' : 'bx-plus']"></i>
                                </button>
                            </div>
                            <div v-show="isOpen[index]" class="px-4 pb-4 text-sm text-gray-700">
                                <div class="md:text-lg" v-html="item.answer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
