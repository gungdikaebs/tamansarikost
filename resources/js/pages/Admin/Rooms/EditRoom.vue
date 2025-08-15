<script setup>
import { defineProps } from 'vue';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    room: {
        type: Object,
        required: true
    }
});

const room = useForm({
    id: props.room.id,
    room_number: props.room.room_number,
    price: props.room.price,
    description: props.room.description,
    status: props.room.status
});

function submit() {
    room.put(`/dashboard/rooms/${props.room.id}`, {
        onSuccess: () => {
            room.reset();
            router.visit('/dashboard/rooms');
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

console.log(props.room);

</script>

<template>
    <DashboardLayouts :auth=props.auth>
        <div class="my-4 mx-auto bg-white">
            <h1 class="text-2xl font-bold mb-4 text-center">Edit Data Kamar</h1>
            <form class="max-w-xl mx-auto" @submit.prevent="submit">
                <div class="mb-5">
                    <label for="room_number" class="block mb-2 text-sm font-medium text-gray-900">Room Number</label>
                    <input v-model="room.room_number" type="text" id="room_number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan Room Number Disini!" required />
                </div>
                <div class="mb-5">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Harga</label>
                    <input v-model="room.price" type="number" id="price" placeholder="Masukkan Harga Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        required />
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <input v-model="room.description" type="text" id="description"
                        placeholder="Masukkan Deskripsi Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        required />
                </div>
                <div class="mb-5">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <select v-model="room.status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 ">
                        <option value="" disabled selected>Pilih Status Kamar</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </DashboardLayouts>
</template>