<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { ref } from 'vue';

const page = usePage();
const payment = page.props.payment;

function dateStr(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

const previewOpen = ref(false);

function openPreview() {
    previewOpen.value = true;
}

function closePreview() {
    previewOpen.value = false;
}
</script>

<template>
    <DashboardLayouts :auth="page.props.auth">
        <div class="p-4 min-h-screen bg-gradient-to-br from-indigo-100 via-white to-indigo-200">
            <div class=" mx-auto">
                <div class="bg-white shadow-2xl rounded-2xl p-10 border border-indigo-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 opacity-10 pointer-events-none select-none">
                        <i class="bx bx-receipt text-[12rem] text-indigo-200"></i>
                    </div>
                    <h1
                        class="text-4xl font-extrabold mb-10 text-center text-blue-500 tracking-wide drop-shadow flex items-center justify-center gap-2">
                        <i class="bx bx-credit-card text-blue-500"></i>
                        Detail Pembayaran
                    </h1>
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="bg-indigo-50 rounded-full p-3">
                                <i class="bx bx-hash text-2xl text-indigo-700"></i>
                            </div>
                            <div>
                                <div class="text-gray-500 font-medium">ID Transaksi</div>
                                <div class="font-semibold text-indigo-700 text-lg">{{ payment.id }}</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-money text-green-600"></i> Jumlah
                            </span>
                            <span class="text-gray-700 font-bold text-lg text-right">Rp {{
                                payment.amount != null ? payment.amount.toLocaleString() : '0' }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-error text-red-500"></i> Denda
                            </span>
                            <span class="text-red-500 font-bold text-lg text-right">Rp {{
                                payment.penalty_fee != null ? payment.penalty_fee.toLocaleString() : '0' }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-calculator text-blue-600"></i> Total Bayar
                            </span>
                            <span class="text-blue-700 font-bold text-lg text-right">
                                Rp {{
                                    (
                                        Number(payment.amount != null ? payment.amount : 0) +
                                        Number(payment.penalty_fee != null ? payment.penalty_fee : 0)
                                    ).toLocaleString()
                                }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-calendar-check text-indigo-600"></i> Tanggal Dibayar
                            </span>
                            <span class="text-right">{{ dateStr(payment.payment_date) }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-calendar-event text-indigo-600"></i> Jatuh Tempo
                            </span>
                            <span class="text-right">{{ dateStr(payment.billing_period) }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-transfer-alt text-indigo-600"></i> Metode
                            </span>
                            <span class="flex items-center justify-end gap-2 text-indigo-600 text-right">
                                <template v-if="payment.payment_method === 'cash'">
                                    <i class='bx bx-money'></i> <span>Cash</span>
                                </template>
                                <template v-else-if="payment.payment_method === 'transfer'">
                                    <i class='bx bx-credit-card'></i> <span>Transfer</span>
                                </template>
                                <template v-else>
                                    <span>{{ payment.payment_method }}</span>
                                </template>
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 items-center text-base">
                            <span class="text-gray-500 font-medium flex items-center gap-2">
                                <i class="bx bx-check-shield text-indigo-600"></i> Status
                            </span>
                            <span v-if="payment && payment.payment_status"
                                class="justify-self-end w-fit px-4 py-1 rounded font-semibold text-right inline-block shadow"
                                :class="{
                                    'text-green-700 bg-green-100': payment.payment_status === 'confirmed',
                                    'text-yellow-700 bg-yellow-100': payment.payment_status === 'pending',
                                    'text-gray-700 bg-gray-100': payment.payment_status === 'unpaid',
                                    'text-red-700 bg-red-100': payment.payment_status === 'failed'
                                }">
                                {{
                                    payment.payment_status === 'confirmed' ? 'Terkonfirmasi'
                                        : payment.payment_status === 'pending' ? 'Menunggu Konfirmasi'
                                            : payment.payment_status === 'unpaid' ? 'Belum Dibayar'
                                                : payment.payment_status === 'failed' ? 'Gagal Melakukan Pembayaran'
                                                    : payment.payment_status
                                }}
                            </span>
                            <span v-else
                                class="justify-self-end w-fit px-4 py-1 rounded font-semibold text-right inline-block text-gray-400 bg-gray-100 shadow">
                                Status tidak tersedia
                            </span>
                        </div>
                        <div v-if="payment.payment_photo" class="flex flex-col items-center pt-8">
                            <span class="text-gray-500 mb-2 text-base font-medium flex items-center gap-2">
                                <i class="bx bx-image-alt text-indigo-600"></i> Bukti Pembayaran
                            </span>
                            <div class="relative group">
                                <img :src="payment.payment_photo" alt="Bukti Pembayaran"
                                    class="rounded-2xl max-h-48 w-auto border-4 border-indigo-200 shadow-lg cursor-pointer transition-transform duration-200 group-hover:scale-105 hover:shadow-2xl"
                                    @click="openPreview" />
                                <span
                                    class="absolute bottom-2 right-2 bg-indigo-700 text-white text-xs px-2 py-1 rounded opacity-80 group-hover:opacity-100 transition-opacity">
                                    Klik untuk perbesar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div v-if="previewOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
                @click.self="closePreview">
                <div
                    class="bg-white rounded-2xl p-8 shadow-2xl max-w-3xl w-full flex flex-col items-center animate-fadeIn">
                    <img :src="payment.payment_photo" alt="Preview Bukti Pembayaran"
                        class="max-h-[70vh] w-auto mb-6 rounded-xl border-4 border-indigo-200 shadow-lg" />
                    <button
                        class="px-8 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
                        @click="closePreview">
                        Tutup
                    </button>
                </div>
            </div>
        </transition>
    </DashboardLayouts>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.animate-fadeIn {
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
