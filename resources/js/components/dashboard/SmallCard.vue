<script setup>
const props = defineProps({
    icon: {
        type: String,
    },
    data: {
        type: Number,
    },
    title: {
        type: String,
    },
    link: {
        type: String,
    }
});
</script>

<template>
    <div
        class="flex flex-col bg-gradient-to-br from-blue-100 via-white to-blue-50 align-center p-6 md:p-8 rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300 justify-center border border-blue-200">
        <div class="flex gap-2 items-center text-blue-600 mb-2">
            <i :class="`${props.icon} text-2xl md:text-3xl`"></i>
            <p class="font-semibold text-lg">{{ props.title }}</p>
        </div>
        <div class="flex items-end gap-2 ">
            <p class="text-3xl md:text-4xl font-bold text-blue-800">{{ props.data }}</p>

        </div>
        <div class="mt-4 flex justify-between items-center">
            <a :href="props.link"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                View Details
            </a>
        </div>
    </div>
</template>