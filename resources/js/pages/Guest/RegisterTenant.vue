<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

const props = defineProps({
    auth: Object,
    user: Object,
    room_id: String,
});


const form = useForm({
    user_id: '',
    fullname: '',
    ktp_photo: null,
});

function handleFileUpload(event) {
    form.ktp_photo = event.target.files[0];
}

console.log(props);

</script>

<template>
    <div>
        <form @click.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto my-4">
            Register tenant
            <input type="text" v-model="form.fullname" placeholder="Full Name" class="border p-2 rounded mb-4 w-full" />
            <input type="file" @change="handleFileUpload" class="border p-2 rounded mb-4 w-full" />
            <input type="text" v-model="form.user_id" placeholder="User ID" class="border p-2 rounded mb-4 w-full" />
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-300">
                Submit
            </button>
        </form>
    </div>
</template>