<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    room: Object
})

console.log(props.room.room_tenants);
</script>

<template>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Kamar</h2>
        <p><strong>Room Number:</strong> {{ room.room_number }}</p>
        <p><strong>Price:</strong> Rp. {{ room.price.toLocaleString('id-ID') }}</p>
        <p><strong>Status:</strong> {{ room.status }}</p>

        <div class="mt-6">
            <h3 class="text-xl font-semibold">Penghuni</h3>
            <ul v-if="room.room_tenants.length">
                <li v-for="rt in room.room_tenants" :key="rt.id" class="mt-2">
                    <p>{{ rt.tenant.fullname }}</p>
                    <p>({{ rt.tenant.user.email }})</p>
                </li>
            </ul>
            <p v-else class="text-gray-500">Belum ada penghuni</p>
        </div>
    </div>
</template>
