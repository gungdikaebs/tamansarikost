<script setup>
import { ref, watch, defineEmits, defineProps } from 'vue';

const emit = defineEmits(['update:search']);

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Cari...',
    },
});

const searchTerm = ref(props.modelValue);

watch(() => props.modelValue, (val) => {
    if (val !== searchTerm.value) {
        searchTerm.value = val;
    }
});

function onInput() {
    emit('update:search', searchTerm.value);
}
</script>

<template>
    <div class="relative">
        <input type="text" :placeholder="placeholder" v-model="searchTerm" @input="onInput"
            class="relative bg-gray-100/40 rounded-xl px-11 py-2 focus:outline-none focus:ring-1 focus:ring-gray-300 w-full" />
        <i class="bx bx-search absolute left-4 top-3"></i>
    </div>
</template>
