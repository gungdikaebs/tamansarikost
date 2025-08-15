<script setup>
import { defineProps } from 'vue';

import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    rooms: {
        type: Array,
        required: true
    },
    tenant: {
        type: Object,
        required: true
    },
    roomTenants: {
        type: Array,
        required: true
    },
    paymentHistory: {
        type: Object,
        required: true
    }
});

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
        <DashboardLayouts :auth="props.auth">
            <div v-if="props.tenant" class="bg-white rounded-lg md:p-4">
                <div
                    class="mb-8 bg-gradient-to-r from-blue-100 via-white to-green-100 rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 shadow-md m-auto">
                        <i class="bx bx-user-circle text-white text-4xl"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-3xl font-extrabold text-blue-700 mb-2 text-center md:text-left">
                            Selamat Datang, <span class="text-green-600">{{ props.auth.user.username }}</span>
                        </h1>
                        <p class="text-lg text-gray-700 tracking-wide text-center md:text-left mb-2">
                            Selamat datang di <span class="font-semibold text-blue-600">Taman Sari Kost</span>!
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 relative">
                    <!-- Card History Payment (Left on desktop, Bottom on mobile) -->
                    <div
                        class="order-2 md:order-1 w-full md:flex-1 p-4 bg-gradient-to-br from-blue-50 via-white to-green-50 rounded-xl shadow-lg mt-5 md:overflow-auto">
                        <div class="flex items-center justify-between mb-4 px-2 md:px-5">
                            <h2 class="text-xl md:text-2xl font-extrabold text-gray-600 flex items-center gap-2">
                                <i class="bx bx-credit-card text-2xl bg-green-600 text-white rounded-full p-2"></i>
                                Riwayat Pembayaran
                            </h2>
                            <a href="/dashboard/payment"
                                class="text-blue-600 hover:underline text-sm font-semibold flex items-center gap-1">
                                Lihat Semua
                                <i class="bx bx-chevron-right"></i>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="(pay, idx) in paymentHistory" :key="pay.id"
                                class="bg-white rounded-xl shadow-md p-5 flex flex-col justify-between border-t-4"
                                :class="{
                                    'border-green-500': pay.payment_status === 'confirmed',
                                    'border-gray-400': pay.payment_status === 'pending'
                                }">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs text-gray-400 font-mono">#{{ idx + 1 }}</span>
                                    <span :class="[
                                        'px-3 py-1 text-xs font-bold rounded-full capitalize tracking-wide shadow',
                                        pay.payment_status === 'unpaid' ? 'bg-yellow-100 text-yellow-700' : '',
                                        pay.payment_status === 'pending' ? 'bg-gray-200 text-gray-700' : '',
                                        pay.payment_status === 'confirmed' ? 'bg-green-100 text-green-700' : '',
                                        pay.payment_status === 'failed' ? 'bg-red-100 text-red-700' : ''
                                    ]">
                                        {{ pay.payment_status }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="text-2xl font-extrabold text-gray-700 mb-1">Rp {{
                                        pay.amount.toLocaleString('id-ID') }}</div>
                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="bx bx-calendar"></i>
                                        {{ dateStr(pay.payment_date) }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <!-- <i class="bx bx-home text-blue-600"></i> -->
                                    <span class="text-sm text-gray-500">Jatuh Tempo : <span
                                            class="font-semibold text-gray-800">{{ dateStr(pay.billing_period) }}</span>
                                    </span>
                                </div>
                            </div>
                            <div v-if="paymentHistory.length === 0"
                                class="col-span-full flex items-center justify-center">
                                <div class="text-gray-400 text-center w-full py-12">
                                    <i class="bx bx-credit-card text-5xl mb-2"></i>
                                    <div class="text-lg font-semibold">Belum ada riwayat pembayaran.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Kamar (Right on desktop, Top on mobile) -->
                    <div
                        class="order-1 md:order-2 w-full md:w-96 mt-1 bg-gradient-to-br from-blue-50 via-white to-green-50 p-6 rounded-xl shadow-lg md:sticky md:top-24 md:self-start">
                        <h2 class="text-xl font-extrabold text-blue-900 mb-4 flex items-center gap-2">
                            <i class="bx bx-door-open text-2xl bg-blue-600 text-white rounded-full p-2"></i>
                            Info Kamar Anda
                        </h2>
                        <div v-for="roomTenants in props.roomTenants" :key="roomTenants.id" class="mb-6 last:mb-0">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="bx bx-home text-blue-700 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Nomor Kamar</div>
                                    <div class="text-lg font-semibold text-blue-800">{{ roomTenants.room.room_number }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="bx bx-money text-green-700 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Harga</div>
                                    <div class="text-lg font-semibold text-green-800">Rp. {{
                                        roomTenants.room.price.toLocaleString('id-ID') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="bg-gray-200 p-3 rounded-full">
                                    <i class="bx bx-user text-gray-700 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Penanggung Jawab</div>
                                    <div class="text-lg font-semibold text-gray-800">{{ roomTenants.payee.fullname }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>
                <!-- Tenant Tidak Ada -->
                <div v-if="props.rooms && props.rooms.length > 0">
                    <h1 class="text-3xl font-extrabold mb-6 md:px-3 text-center md:text-start text-blue-700">
                        Pilih Kamar Anda
                    </h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div v-for="room in props.rooms" :key="room.id"
                            class="bg-gradient-to-br from-blue-50 via-white to-green-50 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-5 flex flex-col justify-between border border-blue-100 hover:border-blue-400">
                            <a :href="`/dashboard/register-tenant?room_id=${room.id}`" class="block group">
                                <div class="relative mb-4">
                                    <img src="https://i.pinimg.com/736x/09/1f/6b/091f6b9e8ae59b382144f53d80564965.jpg"
                                        alt="Room Image"
                                        class="w-full h-48 object-cover rounded-xl group-hover:scale-105 transition-transform duration-300" />
                                    <span
                                        class="absolute top-3 left-3 bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow font-bold">
                                        {{ room.status }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h2 class="text-xl font-bold text-blue-800 mb-1">{{ room.room_number }}</h2>
                                    <p class="text-gray-600 text-sm mb-2">{{ room.description }}</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <p class="text-lg font-semibold text-green-700">
                                        Rp. {{ room.price.toLocaleString('id-ID') }}
                                    </p>
                                    <a class="bg-blue-500 py-2 px-5 rounded-lg text-white font-bold shadow hover:scale-105 transition-transform duration-200"
                                        :href="`/dashboard/register-tenant?room_id=${room.id}`">
                                        Book Now
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else
                    class="flex flex-col items-center justify-center h-64 mb-4 rounded-2xl bg-gradient-to-br from-gray-100 via-white to-gray-200 shadow-inner">
                    <i class="bx bx-bed text-6xl text-gray-400 mb-4"></i>
                    <h1 class="text-2xl text-gray-400 font-semibold">Tidak Ada Kamar Yang Tersedia!</h1>
                    <p class="text-gray-500 mt-2">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>
