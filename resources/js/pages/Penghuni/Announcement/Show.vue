<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();
</script>

<template>

    <Head>
        <title>Detail Pengumuman</title>
    </Head>

    <DashboardLayouts :auth="page.props.auth">
        <a href="/dashboard/informations/"
            class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold transition group mb-6">
            <span
                class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-indigo-100 group-hover:bg-indigo-200 transition">
                <i class="bx bx-arrow-back text-2xl"></i>
            </span>
            <span class="text-base sm:text-lg group-hover:underline">Kembali ke Daftar Pengaduan</span>
        </a>
        <div class="bg-white shadow-2xl rounded p-10 border border-indigo-200 relative overflow-hidden">
            <!-- Decorative background shapes -->
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold text-blue-800 mb-4 text-center drop-shadow">
                    {{ page.props.announcement.title }}
                    
                </h1>
                <div v-if="page.props.announcement.image_url" class="flex justify-center mb-6">
                    <img :src="page.props.announcement.image_url" alt="Announcement Image"
                        class="rounded-xl shadow-lg max-h-72 object-cover border-4 border-white" />
                </div>
                <div class="prose max-w-none text-gray-700 text-lg leading-relaxed text-justify"
                    v-html="page.props.announcement.content"></div>
            </div>
        </div>
    </DashboardLayouts>
</template>