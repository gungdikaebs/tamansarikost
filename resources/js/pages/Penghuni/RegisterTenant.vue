<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';

const props = defineProps({
    auth: Object,
    user: Object,
    room_id: String,
});

const form = useForm({
    user_id: props.user.id,
    fullname: '',
    ktp_photo: null,
});

const submitting = ref(false);
const generalError = ref('');

function handleFileUpload(event) {
    form.ktp_photo = event.target.files[0];
    // Reset error file
    form.errors.ktp_photo = undefined;
}

function validateForm() {
    let isValid = true;
    form.errors = {}; // Clear previous errors

    if (!form.fullname || form.fullname.length < 3) {
        form.errors.fullname = 'Full Name must be at least 3 characters.';
        isValid = false;
    }

    if (!form.ktp_photo) {
        form.errors.ktp_photo = 'KTP photo is required.';
        isValid = false;
    } else if (!form.ktp_photo.type.startsWith('image/')) {
        form.errors.ktp_photo = 'File must be an image.';
        isValid = false;
    }

    return isValid;
}

function submit() {
    generalError.value = '';
    if (!validateForm()) {
        return;
    }

    submitting.value = true;

    form.post('/dashboard/register-tenant', {
        onFinish: () => {
            submitting.value = false;
        },
        onError: (errors) => {
            // You can handle general error message here
            generalError.value = 'Please fix the errors in the form.';
        }
    });
}
</script>

<template>
    <div>
        <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto my-4">
            <h2 class="text-xl font-semibold mb-4">Register Tenant</h2>

            <div class="mb-4">
                <input type="text" v-model="form.fullname" placeholder="Full Name"
                    :class="['border p-2 rounded w-full', form.errors.fullname ? 'border-red-600' : 'border-gray-300']" />
                <div v-if="form.errors.fullname" class="text-red-600 mt-1 text-sm">{{ form.errors.fullname }}</div>
            </div>

            <div class="mb-5">
                <label for="ktp_photo" class="block mb-1 font-medium">Foto KTP</label>
                <input id="ktp_photo" name="ktp_photo" type="file" @change="handleFileUpload" accept="image/*"
                    :class="['border p-2 rounded w-full', form.errors.ktp_photo ? 'border-red-600' : 'border-gray-300']" />
                <div v-if="form.errors.ktp_photo" class="text-red-600 mt-1 text-sm">{{ form.errors.ktp_photo }}</div>
            </div>

            <div class="mb-4">
                <input type="text" disabled v-model="form.user_id" placeholder="User ID"
                    class="border p-2 rounded w-full bg-gray-100" />
            </div>

            <button :disabled="submitting" type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-300 disabled:opacity-50">
                {{ submitting ? 'Submitting...' : 'Submit' }}
            </button>

            <div v-if="generalError" class="text-red-600 mt-4">{{ generalError }}</div>
        </form>
    </div>
</template>
