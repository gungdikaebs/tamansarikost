<script setup>
import DashboardAdmin from '../components/dashboard/DashboardAdmin.vue';
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

function logout() {
    router.post('/logout')
}

console.log(props.auth);
</script>

<template>

    <DashboardAdmin />
    <button @click="logout">Logout</button>

</template>