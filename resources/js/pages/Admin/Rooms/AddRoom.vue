<script setup>
import { defineProps } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },

});

const form = useForm({
    room_number: '',
    price: '750000',
    description: '',
    status: 'available'
});

function submit() {
    router.post('/dashboard/rooms', form, {
        onSuccess: () => {
            form.room_number = '';
            form.price = '';
            form.description = '';
            form.status = '';
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

console.log(props.auth.user);
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="my-4 mx-auto bg-white p-6 rounded">
            <h1 class="text-2xl font-bold mb-5 text-center">Insert Data Kamar </h1>
            <form class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="room_number" class="block mb-2 text-sm font-medium text-gray-900 ">Room Number</label>
                    <input v-model="form.room_number" type="text" id="room_number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan Room Number Disini!" required />
                </div>
                <div class="mb-5">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 ">Harga</label>
                    <input v-model="form.price" type="number" id="price" placeholder="Masukkan Harga Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5  "
                        required />
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
                    <input v-model="form.description" type="text" id="description"
                        placeholder="Masukkan Deskripsi Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5  "
                        required />
                </div>
                <div class="mb-5">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 ">Status</label>
                    <select v-model="form.status" id="status" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5">
                        <option value="" disabled selected>Pilih Status Kamar</option>
                        <option value="available">Tersedia</option>
                        <option value="occupied">Terisi</option>
                        <option value="maintenance">Perbaikan</option>
                    </select>
                </div>
                <button @click.prevent="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
            </form>
        </div>
    </DashboardLayouts>

</template>