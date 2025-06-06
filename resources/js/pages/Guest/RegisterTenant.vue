<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

const props = defineProps({
    auth: Object,
    user: Object,
    room_id: String,
});

console.log(props.user);

const form = useForm({
    user_id: props.user.id,
    fullname: '',
    ktp_photo: null,
});

function handleFileUpload(event) {
    form.ktp_photo = event.target.files[0];
}

function submit() {
    form.post('/dashboard/register-tenant'); // Replace with your actual endpoint
}

</script>

<template>
    <div>
        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto my-4">
            Register tenant
            <input type="text" v-model="form.fullname" placeholder="Full Name" class="border p-2 rounded mb-4 w-full" />
            <div class="mb-5">
                <label for="ktp_photo" class="block mb-1 font-medium">Foto KTP</label>
                <input id="ktp_photo" name="ktp_photo" type="file" @change="handleFileUpload" accept="image/*"
                    class="border p-2 rounded w-full" />
                <div v-if="form.errors.ktp_photo">{{ form.errors.ktp_photo }}</div>

            </div>
            <input type="text" disabled v-model="form.user_id" placeholder="User ID"
                class="border p-2 rounded mb-4 w-full" />
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-300">
                Submit
            </button>
        </form>
    </div>
</template>