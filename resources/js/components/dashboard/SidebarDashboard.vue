<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    role: {
        type: String,
        required: true
    },

});
</script>

<template>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 "
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white ">
            <!-- Admin Sidebar -->
            <ul v-if="props.role === 'admin'" class="space-y-2">
                <li>
                    <a href="/dashboard" class="flex items-center p-2 rounded-lg transition group `hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-home-smile text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/rooms"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-buildings text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Kamar</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/announcements"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-rounded-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Informasi</span>
                        <span
                            class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded-full group-hover:bg-blue-700">3</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/users"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-user text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Users</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/tenants"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-user-pin text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Penghuni</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/payments"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-wallet text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Pembayaran</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/complaints"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-alt-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Complain</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-file text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Laporan</span>
                    </a>
                </li>
            </ul>
            <!-- End Admin Sidebar -->
            <!-- Penghuni Sidebar -->
            <ul v-if="props.role === 'penghuni'" class="space-y-2">
                <li>
                    <a href="/dashboard" class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-home-smile text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/informations"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-rounded-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Informasi</span>
                        <span
                            class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded-full group-hover:bg-blue-700">3</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/payment"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-wallet text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Pembayaran</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/complaint"
                        class="flex items-center p-2 rounded-lg transition group hover:bg-blue-50">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-alt-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Complain</span>
                    </a>
                </li>
            </ul>
            <!-- End Penghuni Sidebar -->

        </div>
    </aside>
</template>