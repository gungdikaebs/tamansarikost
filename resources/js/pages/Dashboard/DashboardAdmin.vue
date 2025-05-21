<script setup>
import BigCard from '../../components/dashboard/BigCard.vue';
import NavbarDashboard from '../../components/dashboard/NavbarDashboard.vue';
import SidebarDashboard from '../../components/dashboard/SidebarDashboard.vue';
import SmallCard from '../../components/dashboard/SmallCard.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

console.log(props.auth.user);
</script>
<template>
    <div>
        <NavbarDashboard />
        <SidebarDashboard />
        <div class="p-4 sm:ml-64  bg-indigo-50/20">
            <div class="p-4 border-2 border-gray-800 border-dashed rounded-lg  mt-18">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <SmallCard />
                    <SmallCard />
                    <SmallCard />
                    <SmallCard />
                </div>
                <BigCard />

            </div>
        </div>
    </div>
</template>