<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const page = usePage();

console.log(page.props);
</script>
<template>
    <div>
        <DashboardLayouts :auth="page.props.auth"></DashboardLayouts>
    </div>
</template>