<script setup>
import NavbarDashboard from '../../components/dashboard/NavbarDashboard.vue';
import SidebarDashboard from '../../components/dashboard/SidebarDashboard.vue';
</script>

<template>
    <div>
        <NavbarDashboard />
        <SidebarDashboard />
        <div class="p-4 sm:ml-64  bg-indigo-50/20">
            <div class="p-4 border-2 border-gray-800 border-dashed rounded-lg  mt-18">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">

                </div>

            </div>
        </div>
    </div>
</template>