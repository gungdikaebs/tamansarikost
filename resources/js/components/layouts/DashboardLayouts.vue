<script setup>
import NavbarDashboard from '../dashboard/NavbarDashboard.vue';
import SidebarDashboard from '../dashboard/SidebarDashboard.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

const role = props.auth.user.role;

</script>

<template>
    <div>
        <NavbarDashboard :auth="auth" />
        <SidebarDashboard :role="role" />
        <div class="p-4 sm:ml-64 bg-indigo-50/20">
            <div class="p-4 mt-18 rounded-lg bg-white ">
                <slot />
            </div>
        </div>
    </div>
</template>