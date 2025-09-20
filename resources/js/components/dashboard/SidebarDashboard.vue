<script setup>
import { defineProps } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    role: {
        type: String,
        required: true
    },
})

const page = usePage()
</script>

<template>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 "
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white ">
            <!-- Admin Sidebar -->
            <ul v-if="props.role === 'admin'" class="space-y-2">
                <li>
                    <a href="/dashboard" :class="[
                        'flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url === '/dashboard' ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-home-smile text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/rooms" :class="[
                        'flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/rooms') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-buildings text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Rooms</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/announcements" :class="[
                        'flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/announcements') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-rounded-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Informations</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/users" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/users') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-user text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Users</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/tenants" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/tenants') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-group text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Tenants</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/payments" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/payments') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-wallet text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Payments</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/complaints" :class="[
                        'flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/complaint') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-chat text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Complaints</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/reports" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/reports') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-bar-chart-alt-2 text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Reports</span>
                    </a>
                </li>



            </ul>

            <!--End Admin Sidebar-->
            <!--Penghuni Sidebar-->
            <ul v-if="props.role === 'penghuni'" class=" space-y-2">
                <li>
                    <a href="/dashboard" :class="[
                        'flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url === '/dashboard' ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-home-smile text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="/dashboard/informations" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/informations') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-message-rounded-error text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Informations</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/payment" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/payment') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-wallet text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Payment</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/complaint" :class="['flex items-center p-2 rounded-lg transition group hover:bg-blue-50',
                        page.url.startsWith('/dashboard/complaint') ? 'bg-blue-100 font-bold text-blue-700' : ''
                    ]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full group-hover:bg-blue-200">
                            <i class='bx bx-chat text-2xl text-blue-500 group-hover:text-blue-700'></i>
                        </div>
                        <span class="ms-4 text-gray-900 font-semibold group-hover:text-blue-700">Complaints</span>
                    </a>
                </li>
            </ul>
            <!-- End Penghuni Sidebar -->
        </div>
    </aside>
</template>

<style>
/* Tambahan agar aktif lebih jelas */
.bg-blue-100 {
    background-color: #dbeafe !important;
}

.font-bold {
    font-weight: 700 !important;
}

.text-blue-700 {
    color: #1d4ed8 !important;
}
</style>