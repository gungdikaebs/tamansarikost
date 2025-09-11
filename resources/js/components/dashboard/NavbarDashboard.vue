<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

onMounted(() => {
    initFlowbite();
});

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-md">
        <div class="px-4 py-3 lg:px-8 flex items-center justify-between">
            <!-- Left: Logo & Sidebar Toggle -->
            <div class="flex items-center gap-3">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-200 transition">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="/dashboard/" class="flex items-center gap-2 group">
                    <img src="https://i.pinimg.com/736x/25/3c/15/253c15575735e8d0cbe1ce77a6dac3f4.jpg" alt="Logo"
                        width="48" height="48" class="rounded-full object-cover group-hover:scale-105 transition" />
                    <span class="text-xl md:text-2xl text-gray-600 font-bold tracking-tight transition">
                        TamanSariKost
                    </span>
                </a>
            </div>
            <!-- Right: User Dropdown -->
            <div class="flex items-center gap-4">
                <button type="button"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-blue-50 rounded-full px-3 py-1 transition focus:ring-2 focus:ring-blue-200"
                    aria-expanded="false" data-dropdown-toggle="dropdown-user">
                    <img v-if="props.auth && props.auth.user && props.auth.user.photo"
                        class="w-9 h-9 rounded-full border-2 border-blue-300" :src="`storage/${props.auth.user.photo}`"
                        alt="user photo" />
                    <img v-else class="w-9 h-9 rounded-full border-2 border-blue-300"
                        :src="`https://ui-avatars.com/api/?name=${props.auth.user.username}`"
                        alt="default user photo" />
                    <span class="hidden sm:block font-medium text-gray-800">{{ props.auth.user.username }}</span>
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-md shadow-lg min-w-[200px]"
                    id="dropdown-user">
                    <div class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-900">{{ props.auth.user.username }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ props.auth.user.email }}</p>
                    </div>
                    <ul class="py-1">
                        <li>
                            <a href="/dashboard"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded transition">Dashboard</a>
                        </li>
                        <li>
                            <a href="/dashboard/settings"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded transition">Settings</a>
                        </li>
                        <li>
                            <a href="/logout"
                                class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded transition">Sign
                                out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>
