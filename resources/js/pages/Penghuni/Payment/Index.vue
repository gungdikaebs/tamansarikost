<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();

console.log(page.props);

function dateStr(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}


</script>
<template>
    <div>
        <DashboardLayouts :auth="page.props.auth">

            <div class="pt-10 px-4 lg:px-8">
                <h1 class="text-2xl text-gray-500 font-bold mb-4 text-center md:text-left">Payment Page</h1>
                <!-- Payment History Content Goes Here -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="payment in page.props.payments" :key="payment.id"
                        class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-6 flex flex-col border border-blue-100 hover:shadow-2xl transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs text-blue-400 font-medium uppercase tracking-wide">ID
                                Pembayaran</span>
                            <span class="font-bold text-blue-700 text-lg">{{ payment.id }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Jumlah</span>
                            <span class="font-semibold text-green-600 text-lg">
                                Rp {{ payment.amount.toLocaleString('id-ID') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Tanggal Bayar</span>
                            <span class="text-gray-700">{{ dateStr(payment.payment_date) }}</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Jatuh Tempo</span>
                            <span class="text-gray-700">{{ dateStr(payment.billing_period) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-gray-500">Status</span>
                            <span :class="{
                                'bg-green-100 text-green-700 px-2 py-1 rounded font-semibold': payment.payment_status === 'confirmed',
                                'bg-yellow-100 text-gray-600 px-2 py-1 rounded font-semibold': payment.payment_status === 'pending',
                                'bg-yellow-100 text-yellow-700 px-2 py-1 rounded font-semibold': payment.payment_status === 'unpaid',
                                'bg-red-100 text-red-700 px-2 py-1 rounded font-semibold': payment.payment_status === 'failed'
                            }">
                                {{ payment.payment_status }}
                            </span>
                        </div>
                        <a :href="`payment/bayar/${payment.id}`" v-if="payment.payment_status === 'unpaid'" class=" mt-6 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-lg
                            shadow hover:from-blue-700 hover:to-blue-500 transition font-semibold text-center">
                            Bayar Sekarang
                        </a>
                        <a :href="`payment/detail/${payment.id}`" v-else
                            class="mt-6 px-4 py-2 bg-gradient-to-r from-gray-200 to-blue-100 text-blue-700 rounded-lg
                            shadow hover:from-blue-200 hover:to-blue-300 transition font-semibold text-center border border-blue-300">
                            Lihat Detail Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>