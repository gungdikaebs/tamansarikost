<script setup>
import { defineProps } from 'vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import TableRoom from '../../components/dashboard/room/TableRoom.vue';

const props = defineProps({
    rooms: {
        type: Array,
        required: true
    },
    auth: {
        type: Object,
        required: true
    },
    flash: {
        type: Object,
        default: () => ({})
    }

});



</script>

<template>
    <DashboardLayouts :auth="auth">
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Kamar</h1>
            <a href="/dashboard/rooms/add"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah Kamar
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>

        <TableRoom :rooms="rooms" />
    </DashboardLayouts>

    <!-- Modal Tambah Kamar -->

</template>
