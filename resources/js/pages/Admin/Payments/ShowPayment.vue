<script setup>
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: Object,
    payment: Object
});
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6 bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-3xl font-extrabold mb-8 text-blue-800 flex items-center gap-3">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Detail Pembayaran
                </h1>

                <div class="bg-white shadow-2xl rounded-2xl p-8 border border-blue-100">
                    <div class="grid md:grid-cols-2 gap-8">

                        <!-- Informasi Utama -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-700">ID Pembayaran:</span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-bold">{{
                                    payment.id }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-700">Jumlah Bayar:</span>
                                <span class="text-green-700 font-extrabold text-xl">Rp {{
                                    payment.amount.toLocaleString() }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Periode Tagihan:</span>
                                <span class="ml-2 text-gray-600">{{ payment.billing_period }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Tanggal Pembayaran:</span>
                                <span class="ml-2 text-gray-600">{{ new Date(payment.payment_date).toLocaleDateString()
                                    }}</span>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-700">Status Pembayaran:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-bold transition" :class="{
                                    'bg-green-100 text-green-700 border border-green-300': payment.payment_status === 'confirmed',
                                    'bg-yellow-100 text-gray-700 border border-yellow-300': payment.payment_status === 'pending',
                                    'bg-yellow-100 text-yellow-700 border border-yellow-300': payment.payment_status === 'unpaid',
                                    'bg-red-100 text-red-700 border border-red-300': payment.payment_status === 'failed'
                                }">
                                    {{ payment.payment_status }}
                                </span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Metode Pembayaran:</span>
                                <span class="ml-2 text-gray-600">{{ payment.payment_method }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Denda:</span>
                                <span class="ml-2 text-red-600 font-bold">Rp {{ payment.penalty_fee.toLocaleString()
                                    }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Bukti Pembayaran:</span>
                                <div v-if="payment.payment_photo" class="mt-3 flex flex-col items-start">
                                    <img :src="`/storage/${payment.payment_photo}`" alt="Bukti Pembayaran"
                                        class="w-56 rounded-xl shadow-lg border border-gray-200 hover:scale-105 transition-transform duration-200" />
                                    <a :href="`/storage/${payment.payment_photo}`" download
                                        class="mt-2 text-blue-600 hover:underline text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                        </svg>
                                        Download Bukti
                                    </a>
                                </div>
                                <p v-else class="text-gray-400 text-sm mt-2 italic">Tidak ada bukti pembayaran</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </DashboardLayouts>
</template>
