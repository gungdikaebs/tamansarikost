<script setup>
import { defineProps, ref } from 'vue'
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

import ModalInput from '../../../components/dashboard/RoomTenants/ModalInput.vue';
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const modalInput = ref(false);

const props = defineProps({
    room: Object,
    auth: Object,
    tenants: Array,

})

console.log(props.tenants);
const updateStatus = (roomTenantId, newStatus) => {
    router.put(`/dashboard/room-tenants/${roomTenantId}`, { status: newStatus })
        .then(() => {
            console.log('Status updated');
        })
        .catch(err => {
            console.error('Failed to update status', err);
        });
};


const deleteRoomTenant = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        router.delete(`/dashboard/room-tenants/${id}`, {
            onSuccess: () => {
                window.location.reload();
            },
            onError: (errors) => {
                console.error('Error deleting room tenant:', errors);
            },
        });
    }
}


</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6 bg-white shadow rounded-lg space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">🏠 Detail Kamar</h2>
                <span class="text-sm text-green-600 font-medium">🟢 {{ props.room.status }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kiri: Info Kamar -->
                <div class="space-y-2">
                    <p><strong>📦 Room Number:</strong> {{ props.room.room_number }}</p>
                    <p><strong>💰 Harga:</strong> Rp.{{ props.room.price.toLocaleString('id') }}</p>
                </div>

                <!-- Kanan: Info Penghuni -->
                <div v-if="props.room.room_tenants.length" class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-semibold text-lg mb-2">👤 Penghuni</h3>
                    <div v-for="rt in props.room.room_tenants" :key="rt.id" class="mb-2 border-b pb-2">
                        <p><strong>Full Name:</strong> {{ rt.tenant.fullname }}</p>
                        <p><strong>Email:</strong> {{ rt.tenant.user.email }}</p>
                        <p><strong>Username:</strong> {{ rt.tenant.user.username }}</p>
                        <p><strong>Mulai Sewa:</strong> {{ rt.start_date }}</p>
                        <p><strong>Selesai Sewa:</strong> {{ rt.end_date ?? '-' }}</p>
                        <p><strong>Status:</strong>
                            <select v-model="rt.status" @change="updateStatus(rt.id, rt.status)">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </p>
                        <p><strong>Penanggung Jawab:</strong> {{ rt.payee.fullname }}</p>
                        <button @click="deleteRoomTenant(rt.id)"
                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                            🗑️ Delete Room Tenant
                        </button>
                    </div>
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap gap-3 pt-4">
                <button @click="modalInput = true" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                    ➕ Tambah Data Room Tenant
                </button>

            </div>
        </div>
        <ModalInput v-if="modalInput" :roomId="props.room.id" :tenants="props.tenants" @close="modalInput = false" />
    </DashboardLayouts>
</template>
