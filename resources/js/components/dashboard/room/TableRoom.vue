<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
const props = defineProps({
    rooms: {
        type: Array,
        required: true
    },
});

function deleteRoom(id) {
    console.log(id);
    if (confirm('Are you sure you want to delete this room?')) {
        router.delete(`/dashboard/rooms/${id}`);
    }
}

console.log(props.rooms);
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Room Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody v-for="room in props.rooms" :key="room.id">
                <tr class="odd:bg-white border-b  border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
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
                        <a :href="'/dashboard/rooms/' + room.id + '/edit'"
                            class="font-medium text-blue-600 hover:underline">Edit</a>
                        <button @click="deleteRoom(room.id)" class="text-red-600 hover:underline">Delete</button>

                    </td>

                </tr>


            </tbody>
        </table>
    </div>
</template>