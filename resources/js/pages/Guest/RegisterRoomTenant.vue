<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    },
    room: {
        type: Object,
        required: true
    }
});

console.log(props);
</script>
<template>
    <div>test</div>
</template>