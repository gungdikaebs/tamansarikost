<script setup>
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { defineProps, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Search from '../../components/dashboard/Search.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    payments: {
        type: Object,
        required: true
    },
    search: {
        type: String,
        default: '',
    },
});

const localPayments = ref([...props.payments.data]);

// pagination
function goToPage(page) {
    router.get('/dashboard/payments', { search: props.search, page }, { preserveState: true, replace: true });
}
watch(() => props.payments, (newPayments) => {
    localPayments.value = [...newPayments.data];
}, { immediate: true });


// Search functionality
const search = ref(props.search);
watch(search, (newSearch) => {
    router.get('/dashboard/payments', { search: newSearch }, { preserveState: true, replace: true });
});

// Sorting functionality
const sortKey = ref(null);
const sortOrder = ref('asc'); // 'asc' atau 'desc'

function sortPayments(key) {
    if (sortKey.value === key) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = key;
        sortOrder.value = 'asc';
    }
    localPayments.value.sort((a, b) => {
        let valA = a[key];
        let valB = b[key];

        // Sorting berbasis tanggal
        if (key === 'payment_date' || key === 'billing_period') {
            valA = valA ? new Date(valA) : new Date(0);
            valB = valB ? new Date(valB) : new Date(0);
        } else if (typeof valA === 'string' && typeof valB === 'string') {
            valA = valA.toLowerCase();
            valB = valB.toLowerCase();
        }

        if (valA < valB) return sortOrder.value === 'asc' ? -1 : 1;
        if (valA > valB) return sortOrder.value === 'asc' ? 1 : -1;
        return 0;
    });
    // Trigger reaktifitas array
    localPayments.value = [...localPayments.value];
}


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
    router.put(`payments/${paymentId}/status`,
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

function deletePayment(paymentId) {
    if (confirm('Are you sure you want to delete this payment?')) {
        router.delete(`/dashboard/payments/${paymentId}`, {
            onSuccess: () => {
                localPayments.value = localPayments.value.filter(p => p.id !== paymentId);
                console.log(`Payment ${paymentId} deleted successfully.`);
            },
            onError: (errors) => {
                console.error(`Failed to delete payment ${paymentId}:`, errors);
            }
        });
    }
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

            <div class="relative overflow-x-auto p-4 sm:rounded-lg">
                <Search v-model:search="search" placeholder="Cari Pembayaran..." />
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-5">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Id</th>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Kamar</th>
                            <th scope="col" class="px-6 py-3">Jumlah Pembayaran</th>
                            <th @click="sortPayments('payment_date')" class="cursor-pointer px-6 py-3">
                                Tgl Pembayaran
                                <i v-if="sortKey === 'payment_date'"
                                    :class="sortOrder === 'asc' ? 'bx bx-chevron-up' : 'bx bx-chevron-down'"></i>
                            </th>
                            <th @click="sortPayments('billing_period')" class="cursor-pointer px-6 py-3">
                                Jatuh Tempo
                                <i v-if="sortKey === 'billing_period'"
                                    :class="sortOrder === 'asc' ? 'bx bx-chevron-up' : 'bx bx-chevron-down'"></i>
                            </th>
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
                                <select :value="payment.payment_status"
                                    @change="e => updatePaymentStatus(payment.id, e.target.value)" :class="[
                                        'border rounded px-2 py-1',
                                        payment.payment_status === 'confirmed' ? 'bg-green-100 text-green-700 border-green-400' :
                                            payment.payment_status === 'pending' ? 'bg-blue-100 text-blue-700 border-blue-400' :
                                                payment.payment_status === 'failed' ? 'bg-red-100 text-red-700 border-red-400' : ''
                                    ]">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 flex gap-3 mx-auto">
                                <a :href="`/dashboard/payments/${payment.id}`"
                                    class="font-medium text-gray-600 hover:underline">
                                    <i class="bx bx-show text-2xl"></i>
                                </a>

                                <a :href="`/dashboard/payments/${payment.id}/edit`"
                                    class="text-blue-600 hover:text-blue-900"> <i class="bx bx-edit text-2xl"></i></a>

                                <button @click="deletePayment(payment.id)" class="text-red-600 hover:text-red-900"> <i
                                        class="bx bx-trash text-2xl"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <ul class="flex items-center -space-x-px h-8 text-sm mt-4">
                    <li>
                        <button :disabled="!payments.prev_page_url" @click="goToPage(payments.current_page - 1)"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </button>
                    </li>
                    <li v-for="page in payments.last_page" :key="page">
                        <button :class="[
                            'flex items-center justify-center px-3 h-8 leading-tight border',
                            page === payments.current_page
                                ? 'bg-blue-600 text-white border-blue-600'
                                : 'bg-white text-gray-500 border-gray-300 hover:bg-gray-100 hover:text-gray-700 '
                        ]" @click="goToPage(page)" :disabled="page === payments.current_page">
                            {{ page }}
                        </button>
                    </li>
                    <li>
                        <button :disabled="!payments.next_page_url" @click="goToPage(payments.current_page + 1)"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </DashboardLayouts>
    </div>
</template>