<script setup>
// import { Inertia } from '@inertiajs/inertia';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { defineProps, ref, watch } from 'vue';
const props = defineProps({
    auth: Object,
    payment: Object
});

console.log(props.payment);     
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Detail Pembayaran</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-4">
                    <strong>ID Pembayaran:</strong> {{ payment.id }}
                </div>
                <!-- <div class="mb-4">
                    <strong>Nama Penghuni:</strong> {{ payment.room_tenant.user.fullname }}
                </div> -->
                <div class="mb-4">
                    <strong>Jumlah Bayar:</strong> Rp. {{ payment.amount.toLocaleString() }}
                </div>
                <div class="mb-4">
                    <strong>Periode Tagihan:</strong> {{ payment.billing_period }}
                </div>
                <div class="mb-4">
                    <strong>Tanggal Pembayaran:</strong> {{ new Date(payment.payment_date).toLocaleDateString() }}
                </div>
                <div class="mb-4">
                    <strong>Status Pembayaran:</strong> {{ payment.payment_status }}
                </div>
                <div class="mb-4">
                    <strong>Metode Pembayaran:</strong> {{ payment.payment_method }}
                </div>
                <div class="mb-4">
                    <strong>Denda:</strong> Rp. {{ payment.penalty_fee.toLocaleString() }}
                </div>
                <div class="mb-4">
                    <strong>Bukti Pembayaran:</strong>
                    <img v-if="payment.payment_photo" :src="`/storage/${payment.payment_photo}`" alt="Bukti Pembayaran"
                        class="w-full max-w-md rounded-lg shadow-md mt-2" />
                </div>
            </div>
        </div>
    </DashboardLayouts>
</template>