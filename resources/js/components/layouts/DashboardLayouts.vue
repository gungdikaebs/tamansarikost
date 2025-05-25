<script setup>
import NavbarDashboard from '../dashboard/NavbarDashboard.vue';
import SidebarDashboard from '../dashboard/SidebarDashboard.vue';

</script>

<template>
    <div>
        <NavbarDashboard />
        <SidebarDashboard />
        <div class="p-4 sm:ml-64  bg-indigo-50/20">
            <div class="p-4 border-2 border-gray-800 border-dashed rounded-lg  mt-18">
                <slot />
            </div>
        </div>
    </div>
</template>