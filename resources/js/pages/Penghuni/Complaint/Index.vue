<script setup>
import { usePage, router, Head } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
const page = usePage();

function dateStr(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

function truncateWords(text, maxWords) {
    if (!text) return '';

    const words = text.split(' ');
    if (words.length <= maxWords) {
        return text;
    }

    // potong kata ke maxWords dan tambahkan "..." di akhir
    return words.slice(0, maxWords).join(' ') + '...';
}



</script>

<template>

    <Head>
        <title>Daftar Pengaduan</title>
    </Head>
    <div>
        <DashboardLayouts :auth="page.props.auth">
            <div class="max-w-5xl mx-auto py-8 px-4">
                <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between items-center mb-10">
                    <h1 class="text-3xl font-extrabold text-indigo-700  flex-1">📋 Daftar Pengaduan</h1>
                    <a href="complaint/create"
                        class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition ">
                        + Tambah Complaint
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="complaint in page.props.complaints" :key="complaint.id"
                        class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-200 shadow-lg rounded-2xl overflow-hidden flex flex-col hover:scale-105 hover:shadow-xl transition-transform duration-200">
                        <div class="relative">
                            <img v-if="complaint.image" :src="`/storage/${complaint.image}`" alt="Complaint Image"
                                class="w-full h-48 object-cover" />
                            <div v-else
                                class="w-full h-48 flex items-center justify-center bg-indigo-100 text-indigo-400 text-6xl">
                                <span>📋</span>
                            </div>
                            <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-semibold" :class="{
                                'bg-red-100 text-red-700': complaint.status === 'closed',
                                'bg-yellow-100 text-yellow-700': complaint.status === 'resolved',
                                'bg-gray-100 text-gray-700': complaint.status === 'pending'
                            }">
                                {{ complaint.status === 'closed' ? 'Tutup' : complaint.status === 'resolved' ? 'Selesai'
                                    : 'Menunggu Konfirmasi' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h2 class="text-2xl font-bold mb-2 text-indigo-800">{{ complaint.title }}</h2>
                            <p class="text-gray-600 mb-4 flex-1 line-clamp-3 text-justify">{{
                                truncateWords(complaint.description,
                                    150) }}</p>
                            <div class="flex justify-between items-center mt-auto">
                                <a :href="`complaint/detail/${complaint.id}`"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold">
                                    Lihat Detail
                                </a>
                                <span class="text-sm text-gray-500">{{ dateStr(complaint.created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>