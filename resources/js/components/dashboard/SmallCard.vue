<script setup>
const props = defineProps({
    hello: {
        type: String,
    }
});

console.log(props);
</script>
<template>
    <div class="flex flex-col  bg-white  align-center p-6  md:p-8 rounded-lg shadow-lg  justify-center">
        <div class=" flex gap-1 items-center text-gray-500">
            <i class='bx bx-user text-xl'></i>
            <p class="font-medium">test</p>
        </div>
        <div class="">
            <p class="text-2xl md:text-3xl font-semibold">100</p>
        </div>
    </div>

</template>