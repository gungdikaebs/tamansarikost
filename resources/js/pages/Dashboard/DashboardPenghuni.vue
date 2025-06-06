<script setup>
import { defineProps } from 'vue';
import { router } from "@inertiajs/vue3";

import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    rooms: {
        type: Array,
        required: true
    },
    tenant: {
        type: Object,
        required: true
    },
    roomTenants: {
        type: Array,
        required: true
    },
});

console.log(props.tenant);
</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div v-if="props.tenant">
                <!-- Tenant Ada -->
                <p>Halo, tenant!</p>
                <div v-for="roomTenants in props.roomTenants" :key="roomTenants.id">
                    <h5 class="text-2xl font-bold mb-2">{{ roomTenants }}</h5>

                </div>
            </div>

            <div v-else>
                <!-- Tenant Tidak Ada -->
                <div v-if="props.rooms && props.rooms.length > 0"
                    class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-3">
                    <div v-for="room in props.rooms" :key="room.id" class="...">
                        <h5>{{ room.room_number }}</h5>
                        <p>Rp. {{ room.price.toLocaleString('id-ID') }}</p>
                        <p>{{ room.description }}</p>
                        <a :href="`/dashboard/register-tenant?room_id=${room.id}`">Book Now</a>
                    </div>
                </div>
                <div v-else class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50">
                    <p class="text-2xl text-gray-400">Tidak Ada Kamar Yang Tersedia!</p>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>