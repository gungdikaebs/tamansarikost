<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const { props } = usePage();

const statusInfo = {
    pending: {
        label: 'Menunggu',
        color: 'bg-yellow-100 text-yellow-800 border-yellow-300',
        icon: 'M12 8v4m0 4h.01'
    },
    resolved: {
        label: 'Selesai',
        color: 'bg-green-100 text-green-800 border-green-300',
        icon: 'M5 13l4 4L19 7'
    },
    rejected: {
        label: 'Ditolak',
        color: 'bg-red-100 text-red-800 border-red-300',
        icon: 'M6 18L18 6M6 6l12 12'
    }
};
</script>

<template>

    <Head>
        <title>Detail Komplain</title>
    </Head>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div
                class="bg-gradient-to-br from-white via-gray-50 to-gray-100 rounded-2xl shadow-xl p-10 max-w-2xl mx-auto mt-10 border border-gray-200">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Detail Komplain</h1>
                </div>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="w-36 font-semibold text-gray-500 flex-shrink-0">Tanggal</span>
                        <span class="text-gray-900 px-3 py-1 ">
                            {{ new Date(props.complaint.created_at).toLocaleDateString() }}
                        </span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Judul Komplain</span>
                        <div class="text-xl text-gray-900 font-semibold mt-1  px-2 py-2 ">
                            {{ props.complaint.title }}
                        </div>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-500">Deskripsi</span>
                        <div class="text-gray-800 whitespace-pre-line mt-1  px-2 py-3  ">
                            {{ props.complaint.description }}
                        </div>
                    </div>
                    <div v-if="props.complaint.status" class="flex items-center gap-2">
                        <span class="font-semibold text-gray-500">Status</span>
                        <span
                            :class="`${statusInfo[props.complaint.status]?.color} border px-2 py-2 rounded-full text-sm font-bold flex items-center gap-2`">
                            <svg v-if="statusInfo[props.complaint.status]" class="w-5 h-5" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    :d="statusInfo[props.complaint.status].icon" />
                            </svg>
                            {{ statusInfo[props.complaint.status]?.label || props.complaint.status }}
                        </span>
                    </div>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>