<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    role: {
        type: String,
        required: true
    }
});
console.log(props.role);
</script>

<template>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 "
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white ">
            <!-- Admin Sidebar -->
            <ul v-if="props.role === 'admin'" class="space-y-2 ">
                <li class="hover:font-medium">
                    <a href="/dashboard" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100  ">
                        <i
                            class='bx bx-home-smile text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center '></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="/dashboard/rooms"
                        class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-buildings text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center '></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kamar</span>
                        <span
                            class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">Pro</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-rounded-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Informasi</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full ">3</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="/dashboard/users"
                        class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-user text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-user-pin text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Penghuni</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-wallet text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pembayaran</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-alt-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Complain</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-file text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
                    </a>
                </li>
            </ul>
            <!-- End Admin Sidebar -->
            <!-- Penghuni Sidebar -->
            <ul v-if="props.role === 'penghuni'" class="space-y-2 ">
                <li class="hover:font-medium">
                    <a href="/dashboard" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100  ">
                        <i
                            class='bx bx-home-smile text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center '></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-rounded-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Informasi</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full ">3</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-wallet text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pembayaran</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-alt-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Complain</span>
                    </a>
                </li>
            </ul>
            <!-- End Penghuni Sidebar -->
            <!-- Guest Sidebar -->
            <ul v-if="props.role === 'guest'" class="space-y-2 ">
                <li class="hover:font-medium">
                    <a href="/dashboard" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100  ">
                        <i
                            class='bx bx-home-smile text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center '></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li class="hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-rounded-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Informasi</span>

                    </a>
                </li>
                <li class="relative group hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                        <i
                            class='bx bx-wallet text-2xl py-2 text-gray-500 transition duration-75 hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pembayaran</span>
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 p-3 ms-3 text-sm font-medium rounded-full">
                            <i class='bx bx-lock text-lg text-gray-500'></i>
                        </span>

                        <!-- Tooltip (Tailwind Only) -->
                        <div
                            class="absolute opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gray-900 text-white text-sm px-3 py-1 rounded-lg shadow-md z-10 whitespace-nowrap">
                            Hanya bisa diakses saat anda <br> sudah menjadi penghuni
                        </div>
                    </a>
                </li>
                <li class="relative group hover:font-medium">
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100  ">
                        <i
                            class='bx bx-message-alt-error text-2xl py-2 text-gray-500 transition duration-75  hover:text-gray-900 text-center'></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Complain</span>
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 p-3 ms-3 text-sm font-medium   rounded-full ">
                            <i class='bx bx-lock text-lg text-gray-500'></i>
                        </span>
                        <div
                            class="absolute opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gray-900 text-white text-sm px-3 py-1 rounded-lg shadow-md z-10 whitespace-nowrap">
                            Hanya bisa diakses saat anda <br> sudah menjadi penghuni
                        </div>
                    </a>
                </li>

            </ul>
            <!-- End Guest Sidebar -->
        </div>
    </aside>
</template>