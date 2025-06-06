<script setup>
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    payments: {
        type: Array,
        required: true
    }
});

console.log(props.payments);


</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div class="flex justify-between my-4">
                <h1 class="text-2xl font-bold mb-4">Daftar Pembayaran</h1>
                <a href="/dashboard/payments/create"
                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Tambah Pembayaran
                    <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Id</th>
                            <th scope="col" class="px-6 py-3">Nama Penghuni</th>
                            <th scope="col" class="px-6 py-3">Jumlah Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </DashboardLayouts>
    </div>
</template>