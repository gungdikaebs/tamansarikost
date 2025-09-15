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
        <div class="bg-white shadow-2xl rounded-2xl p-10 border border-indigo-200 relative overflow-hidden">
            <!-- Decorative background shapes -->
            <div class="absolute -top-8 -left-8 w-32 h-32 bg-blue-100 rounded-full opacity-30 z-0"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-100 rounded-full opacity-20 z-0"></div>
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