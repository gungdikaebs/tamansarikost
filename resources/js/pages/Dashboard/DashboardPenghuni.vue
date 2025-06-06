<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    rooms: {
        type: Array,
        required: true
    },
    auth: {
        type: Object,
        required: true
    }
});

function bookRoom(roomId) {
    router.post('book-room/' + roomId);
}

</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div v-if="props.rooms.length >= 1" class=" grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-3">
                <div v-for="room in rooms" :key="room.id"
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg mx-auto md:mx-0 ">
                    <a href="#">
                        <img class="rounded-t-lg w-[500px] h-[200px] object-cover"
                            src="https://i.pinimg.com/736x/1a/08/3e/1a083ede2f6fbdb4d07fc6817f127e16.jpg" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class=" text-2xl font-bold tracking-tight text-gray-900 ">{{ room.room_number }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 ">Rp. {{ room.price.toLocaleString('id-ID') }}</p>
                        <p class="mb-3 font-normal text-gray-700 ">{{ room.description }}</p>
                        <button @click="bookRoom(room.id)"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                            Book Now
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>


            <div v-else class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50 ">
                <p class="text-2xl text-gray-400 ">Tidak Ada Kamar Yang Tersedia!</p>
            </div>
        </DashboardLayouts>
    </div>
</template>