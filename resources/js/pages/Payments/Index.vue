<script setup>
import { Inertia } from '@inertiajs/inertia';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { defineProps, ref, watch } from 'vue';

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

const localPayments = ref([...props.payments]);
watch(() => props.payments, (newPayments) => {
    localPayments.value = [...newPayments];
});

function formatDateToDayMonthYear(dateInput) {
    if (!dateInput) return 'Invalid Date';
    const date = new Date(dateInput);
    if (isNaN(date)) return 'Invalid Date';

    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'short' });
    const year = date.getFullYear();
    return `${day} ${month} ${year}`;
}

function updatePaymentStatus(paymentId, newStatus) {
    Inertia.put(`payments/${paymentId}/status`,
        { payment_status: newStatus },
        {
            preserveScroll: true,
            onSuccess: () => {
                const payment = localPayments.value.find(p => p.id === paymentId);
                if (payment) {
                    payment.payment_status = newStatus;
                }
                console.log(`Payment ${paymentId} status updated to ${newStatus}`);
            },
            onError: (errors) => {
                console.error(`Failed to update payment ${paymentId} status:`, errors);
            }
        });
}


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
                            <th scope="col" class="px-6 py-3">Kamar</th>
                            <th scope="col" class="px-6 py-3">Jumlah Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Jatuh Tempo Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="payment in localPayments" :key="payment.id"
                            class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ payment.id }}</td>
                            <td class="px-6 py-4">{{ payment.room_tenant?.tenant?.fullname || 'N/A' }}</td>
                            <td class="px-6 py-4">{{ payment.room_tenant?.room?.room_number || 'N/A' }}</td>
                            <td class="px-6 py-4 ">Rp. {{ payment.amount.toLocaleString('id-ID') }}</td>
                            <td class="px-6 py-4" v-if="payment.payment_date !== null">{{
                                formatDateToDayMonthYear(payment.payment_date) }}</td>
                            <td class="px-6 py-4" v-else>Belum Membayar</td>
                            <td class="px-6 py-4">{{ formatDateToDayMonthYear(payment.billing_period) }}</td>
                            <td class="px-6 py-4">
                                <select v-model="payment.payment_status"
                                    @change="updatePaymentStatus(payment.id, payment.payment_status)"
                                    class="border rounded px-2 py-1">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <a :href="`/dashboard/payments/${payment.id}`"
                                    class="text-blue-600 hover:text-blue-900">Detail</a>
                                <span class="mx-2">|</span>
                                <a :href="`/dashboard/payments/${payment.id}/edit`"
                                    class="text-blue-600 hover:text-blue-900">Edit</a>
                                <span class="mx-2">|</span>
                                <button @click="Inertia.delete(`/dashboard/payments/${payment.id}`)"
                                    class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </DashboardLayouts>
    </div>
</template>