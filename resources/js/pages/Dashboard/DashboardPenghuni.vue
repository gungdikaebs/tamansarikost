<script setup>
import { defineProps } from 'vue';

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
                <p>Halo, {{ auth.user.username }}!</p>
                <div v-for="roomTenants in props.roomTenants" :key="roomTenants.id">
                    <p>Kamar yang kamu sewa: {{ roomTenants.room.room_number }}</p>
                    <p>Harga: Rp. {{ roomTenants.room.price.toLocaleString('id-ID') }}</p>
                    <p>Penanggung Jawab Kamar: {{ roomTenants.payee_name }}</p>
                </div>
            </div>

            <div v-else>
                <!-- Tenant Tidak Ada -->
                <div v-if="props.rooms && props.rooms.length > 0">
                    <h1 class="text-2xl font-bold mb-4 md:px-3 text-center md:text-start">Daftar Kamar</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-3 ">

                        <div v-for="room in props.rooms" :key="room.id"
                            class="bg-white rounded-lg shadow-lg/20 shadow-gray-600 p-4">
                            <a :href="`/dashboard/register-tenant?room_id=${room.id}`">
                                <img src="https://i.pinimg.com/736x/09/1f/6b/091f6b9e8ae59b382144f53d80564965.jpg"
                                    alt="Room Image" class="w-full h-48 object-cover mb-4 rounded">

                                <h2 class="text-xl font-bold">{{ room.room_number }}</h2>
                                <p class="mb-4">{{ room.description }}</p>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm rounded">Rp. {{ room.price.toLocaleString('id-ID')
                                        }}</p>
                                    <a class="bg-blue-500 py-1 px-3 rounded text-white font "
                                        :href="`/dashboard/register-tenant?room_id=${room.id}`">
                                        Book Now
                                    </a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50">
                    <h1 class="text-2xl text-gray-400">Tidak Ada Kamar Yang Tersedia!</h1>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>