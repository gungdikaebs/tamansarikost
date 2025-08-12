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
                    <!-- Left content -->
                    <div
                        class="w-full md:flex-1 p-4 bg-gradient-to-br from-blue-50 via-white to-green-50 rounded-xl shadow-lg mt-5 md:overflow-auto">
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
                                        pay.payment_status === 'pending' ? 'bg-gray-200 text-gray-700' : '',
                                        pay.payment_status === 'confirmed' ? 'bg-green-100 text-green-700' : ''
                                    ]">
                                        {{ pay.payment_status }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="text-2xl font-extrabold text-gray-700 mb-1">Rp {{
                                        pay.amount.toLocaleString('id-ID') }}</div>
                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="bx bx-calendar"></i>
                                        {{ pay.payment_date }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <i class="bx bx-home text-blue-600"></i>
                                    <span class="text-sm text-gray-500">Kamar: <span
                                            class="font-semibold text-blue-700">{{ pay.room_number || '-'
                                            }}</span></span>
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

                    <!-- Right sidebar -->
                    <div
                        class="w-full md:w-96 mt-1 bg-gradient-to-br from-blue-50 via-white to-green-50 p-6 rounded-xl shadow-lg md:sticky md:top-24 md:self-start">
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
                    <h1 class="text-2xl font-bold mb-4 md:px-3 text-center md:text-start">Daftar Kamar</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-3 ">
                        <div v-for="room in props.rooms" :key="room.id"
                            class="bg-white rounded-lg shadow-lg/20 shadow-gray-600 p-4">
                            <a :href="`/dashboard/register-tenant?room_id=${room.id}`">
                                <img src="https://i.pinimg.com/736x/09/1f/6b/091f6b9e8ae59b382144f53d80564965.jpg"
                                    alt="Room Image" class="w-full h-48 object-cover mb-4 rounded" />

                                <h2 class="text-xl font-bold">{{ room.room_number }}</h2>
                                <p class="mb-4">{{ room.description }}</p>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm rounded">
                                        Rp. {{ room.price.toLocaleString('id-ID') }}
                                    </p>
                                    <a class="bg-blue-500 py-1 px-3 rounded text-white font"
                                        :href="`/dashboard/register-tenant?room_id=${room.id}`">
                                        Book Now
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50">
                    <h1 class="text-2xl text-gray-400">Tidak Ada Kamar Yang Tersedia!</h1>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>
