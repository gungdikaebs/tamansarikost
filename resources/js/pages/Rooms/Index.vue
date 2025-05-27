<script setup>
import { defineProps, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import TableRoom from '../../components/dashboard/room/TableRoom.vue';

const props = defineProps({
    rooms: {
        type: Array,
        required: true
    },
    auth: {
        type: Object,
        required: true
    },
    flash: {
        type: Object,
        default: () => ({})
    }

});

const showModal = ref(false);

const form = useForm({
    room_number: '',
    price: 750000,
    description: '',
    status: 'available'
});

function openModal() {
    showModal.value = true;
}
function closeModal() {
    showModal.value = false;
}

const submit = () => {
    form.post('/dashboard/rooms')
        .then(() => {
            closeModal();
            form.reset();
        })
        .catch((error) => {
            console.error('Failed to submit form:', error);
        });
};

</script>

<template>
    <DashboardLayouts :auth="auth">
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Kamar</h1>
            <button @click="openModal"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah Kamar
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </button>
        </div>

        <TableRoom :rooms="rooms" />
    </DashboardLayouts>

    <!-- Modal Tambah Kamar -->
    <div v-if="showModal" class="fixed inset-0 bg-blue-300/50  flex justify-center items-center">
        <div class="bg-indigo-50 p-6 rounded shadow-md w-[400px]">
            <form @submit.prevent="submit" class="space-y-4">
                <input v-model="form.room_number" placeholder="Room Number" class="input w-full border p-2 rounded" />
                <input v-model="form.price" placeholder="Price" type="number" class="input w-full border p-2 rounded" />
                <input v-model="form.description" placeholder="Description" class="input w-full border p-2 rounded" />
                <select v-model="form.status" class="input w-full border p-2 rounded">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Simpan</button>
            </form>
            <button @click="closeModal" class="mt-4 text-red-500">Tutup</button>
        </div>
    </div>
</template>
