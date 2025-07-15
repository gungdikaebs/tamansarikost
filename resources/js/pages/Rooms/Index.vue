<script setup>
import { defineProps, watch, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Search from '../../components/dashboard/Search.vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    rooms: Array,
    auth: Object,
    flash: Object,
    search: String,

});

const search = ref(props.search);
watch(search, (newSearch) => {
    router.get('/dashboard/rooms', { search: newSearch }, { preserveState: true, replace: true });
});



function deleteRoom(id) {
    if (confirm('Are you sure you want to delete this room?')) {
        router.delete(`/dashboard/rooms/${id}`);
    }
}
</script>

<template>
    <DashboardLayouts :auth="auth">
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Kamar</h1>
            <a href="/dashboard/rooms/create"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah Kamar
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg p-4">
            <Search v-model:search="search" placeholder="Cari kamar..." />

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Room Number</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="room in props.rooms" :key="room.id" class="odd:bg-white border-b border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ room.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ room.room_number }}
                        </td>
                        <td class="px-6 py-4">
                            Rp. {{ room.price.toLocaleString('id-ID') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ room.status }}
                        </td>
                        <td class="px-6 py-4 flex gap-3 mx-auto">
                            <a :href="`/dashboard/rooms/${room.id}`" class="font-medium text-blue-600 hover:underline">
                                <i class="bx bx-show
    text-2xl"></i>
                            </a>
                            <a :href="`/dashboard/rooms/${room.id}/edit`"
                                class="font-medium text-blue-600 hover:underline">
                                <i class="bx bx-edit text-2xl"></i>
                            </a>
                            <button @click="deleteRoom(room.id)" class="text-red-600 hover:underline cursor-pointer">
                                <i class="bx bx-trash text-2xl"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayouts>
</template>
