<script setup>
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: Object,
    payment: Object
});

console.log(props.payment);
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6 border-b pb-3">Detail Pembayaran</h1>

            <div class="bg-white shadow-lg rounded-lg p-6 max-w-5xl mx-auto">
                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Informasi Utama -->
                    <div class="space-y-4">
                        <p><span class="font-semibold">ID Pembayaran:</span> {{ payment.id }}</p>
                        <p>
                            <span class="font-semibold">Jumlah Bayar:</span>
                            <span class="text-green-600 font-bold">Rp {{ payment.amount.toLocaleString() }}</span>
                        </p>
                        <p><span class="font-semibold">Periode Tagihan:</span> {{ payment.billing_period }}</p>
                        <p><span class="font-semibold">Tanggal Pembayaran:</span> {{ new
                            Date(payment.payment_date).toLocaleDateString() }}</p>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="space-y-4">
                        <p>
                            <span class="font-semibold">Status Pembayaran:</span>
                            <span class="px-2 py-1 rounded-md text-sm font-medium" :class="{
                                'bg-green-100 text-green-700': payment.payment_status === 'confirmed',
                                'bg-yellow-100 text-yellow-700': payment.payment_status === 'pending',
                                'bg-red-100 text-red-700': payment.payment_status === 'rejected'
                            }">
                                {{ payment.payment_status }}
                            </span>
                        </p>
                        <p><span class="font-semibold">Metode Pembayaran:</span> {{ payment.payment_method }}</p>
                        <p><span class="font-semibold">Denda:</span> Rp {{ payment.penalty_fee.toLocaleString() }}</p>

                        <div>
                            <span class="font-semibold">Bukti Pembayaran:</span>
                            <div v-if="payment.payment_photo" class="mt-3">
                                <img :src="`/storage/${payment.payment_photo}`" alt="Bukti Pembayaran"
                                    class="w-48 rounded-lg shadow-md border" />
                                <a :href="`/storage/${payment.payment_photo}`" download
                                    class="block mt-2 text-blue-500 hover:underline text-sm">
                                    Download Bukti
                                </a>
                            </div>
                            <p v-else class="text-gray-500 text-sm mt-2">Tidak ada bukti pembayaran</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </DashboardLayouts>
</template>
