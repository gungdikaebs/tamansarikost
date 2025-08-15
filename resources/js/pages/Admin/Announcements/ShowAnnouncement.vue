<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();
const announcement = page.props.announcement; // pastikan data sudah dikirim oleh backend
</script>

<template>
    <DashboardLayouts :auth="page.props.auth">
        <div class="p-6 max-w-4xl mx-auto bg-white rounded-lg">
            <h1 class="text-4xl font-bold mb-6 text-center">{{ announcement.title }}</h1>
            <div v-if="announcement.image" class="my-6">
                <img :src="`/storage/${announcement.image}`" alt="Announcement Image" class="rounded-md mx-auto"
                    width="300" height="300" />

            </div>
            <div v-else>
                <p class="text-gray-500"></p>
            </div>
            <div class="my-4 flex">
                <span class="text-gray-600 text-sm mr-10">Dibuat pada: {{ new
                    Date(announcement.created_at).toLocaleDateString() }}</span>
                <!-- Menampilkan konten rich text dari TipTap -->
                <div v-html="announcement.content" class="prose max-w-none text-justify tracking-tight"></div>
            </div>

        </div>
    </DashboardLayouts>
</template>
