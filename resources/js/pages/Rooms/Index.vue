<script setup>
import { defineProps } from 'vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
// import SmallCard from '../../components/dashboard/SmallCard.vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';
import RoomCard from '../../components/dashboard/room/RoomCard.vue';

const props = defineProps({
    rooms: Array,

})

console.log(props.rooms[0].room_number)



</script>
<template>
    <DashboardLayouts>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        </div>
        <RoomCard :rooms="props.rooms" />
        <!-- <BigCard /> -->
    </DashboardLayouts>
</template>