<script setup>
import NavbarDashboard from '../../components/dashboard/NavbarDashboard.vue';
import SidebarDashboard from '../../components/dashboard/SidebarDashboard.vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

import { defineProps } from 'vue';
import { onMounted } from 'vue';
const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    tenant: {
        type: Object,
        required: true
    },
    rooms: {
        type: Array,
        required: true
    },
});
onMounted(() => {
    console.log(props.tenant);
    console.log(props.rooms);
    console.log(props.auth);
});

</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            Nama Penghuni: {{ props.auth.user.username }} <br>
            Tanggung Jawab: {{ props.tenant.payee.username }} <br>
            Kamar : {{ props.rooms[0].room_number }} <br>
            Biaya : Rp. {{ props.rooms[0].price.toLocaleString('id-ID') }} <br>
        </DashboardLayouts>
    </div>
</template>