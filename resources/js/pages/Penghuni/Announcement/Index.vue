<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();
console.log(page.props.announcements); // Debugging line to check announcements data
function excerpt(html, length = 120) {
    const text = html.replace(/<[^>]+>/g, '');
    return text.length > length ? text.slice(0, length) + '...' : text;
}
</script>

<template>
    <div>
        <DashboardLayouts :auth="page.props.auth" :errors="page.props.errors">
            <div class="max-w-5xl mx-auto py-8 px-4">
                <h1 class="text-4xl font-extrabold mb-10 text-indigo-700 text-center">📢 Pengumuman Terbaru</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="announcement in page.props.announcements" :key="announcement.id"
                        class="bg-white border border-indigo-100 shadow rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-200">
                        <img v-if="announcement.image_url" :src="announcement.image_url" alt="Announcement Image"
                            class="w-full h-40 object-cover" />
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    #Pengumuman
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ new Date(announcement.created_at).toLocaleDateString('ID') }}
                                </span>
                            </div>
                            <h2 class="text-xl font-bold mb-2 text-indigo-800">{{ announcement.title }}</h2>
                            <p class="text-gray-700 mb-4 flex-1" v-html="excerpt(announcement.content, 120)"></p>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-xs text-gray-500">
                                    Oleh: {{ announcement.author_name || 'Admin' }}
                                </span>
                                <!-- Contoh tombol detail, sesuaikan dengan routing Anda -->
                                <a :href="`informations/detail/${announcement.id}`"
                                    class="text-indigo-600 hover:underline text-xs">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>
