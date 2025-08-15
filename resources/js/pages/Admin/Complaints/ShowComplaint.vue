<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();
console.log(page.props.complaint);
</script>

<template>
    <div>
        <DashboardLayouts :auth="page.props.auth">
            <h1 class="text-2xl font-bold mb-2 mx-2">📃Detail Complaint</h1>
            <div class="bg-white  rounded-lg p-4 flex flex-col gap-1">
                <h2 class="text-xl font-semibold ">{{ page.props.complaint.title }}</h2>
                <p class="text-gray-500 ">{{ page.props.complaint.tenant.fullname }} | {{
                    page.props.complaint.tenant.room_tenants[0].room.room_number }}</p>
                <p class="text-gray-800 mb-2" v-html="page.props.complaint.description"></p>
                <p class="text-gray-500">
                    <i v-if="page.props.complaint.status === 'resolved'" class='bx bxs-check-circle'></i>
                    <i v-else class='bx bx-circle'></i>
                    Status: {{ page.props.complaint.status }}
                </p>
            </div>
        </DashboardLayouts>
    </div>
</template>