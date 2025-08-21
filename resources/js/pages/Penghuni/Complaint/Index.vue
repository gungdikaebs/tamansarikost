<script setup>
import { usePage, router } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
const page = usePage();


</script>

<template>
    <div>
        <DashboardLayouts :auth="page.props.auth">
            <div class="max-w-5xl mx-auto py-8 px-4">
                <div class="flex justify-between items-center mb-10">
                    <h1 class="text-4xl font-extrabold text-indigo-700 text-center flex-1">📋 Daftar Pengaduan</h1>
                    <a href="complaint/create"
                        class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                        + Tambah Complaint
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="complaint in page.props.complaints" :key="complaint.id"
                        class="bg-white border border-indigo-100 shadow rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6 flex flex-col flex-1">
                            <h2 class="text-xl font-bold mb-2 text-indigo-800">{{ complaint.title }}</h2>
                            <p class="text-gray-700 mb-4 flex-1">{{ complaint.description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">{{ complaint.created_at }}</span>
                                <a :href="`complaint/detail/${complaint.id}`"
                                    class="ml-2 px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>