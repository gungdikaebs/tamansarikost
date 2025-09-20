<script setup>
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { usePage } from '@inertiajs/vue3';
import SmallCard from '../../components/dashboard/SmallCard.vue';
import ChartReport from '../../components/dashboard/ChartReport.vue';
const { props } = usePage()

console.log(props.chart);

</script>
<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <SmallCard :icon="`bx bx-user`" :data="props.users.length" title="Total Users"
                    link="/dashboard/users" />
                <SmallCard :icon="`bx bx-money`" :data="props.payments.length" title="Payment Pending"
                    link="/dashboard/payments" />
                <SmallCard :icon="`bx bx-message`" :data="props.complaints.length" title="Complaint Pending"
                    link="/dashboard/complaints" />
            </div>
            <ChartReport :chart="props.chart" /> <!-- Panggil komponen chart -->


        </DashboardLayouts>
    </div>
</template>