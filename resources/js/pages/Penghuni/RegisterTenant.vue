<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import Breadcrumb from '../../components/dashboard/Breadcrumb.vue';

const props = defineProps({
    auth: Object,
    user: Object,
    room_id: String,
    breadcrumbs: Array,
});

const form = useForm({
    user_id: props.user.id,
    fullname: '',
    ktp_photo: null,
});

const submitting = ref(false);
const generalError = ref('');
const ktpPreview = ref(null);

function handleFileUpload(event) {
    form.ktp_photo = event.target.files[0];
    form.errors.ktp_photo = undefined;
    if (form.ktp_photo && form.ktp_photo.type.startsWith('image/')) {
        ktpPreview.value = URL.createObjectURL(form.ktp_photo);
    } else {
        ktpPreview.value = null;
    }
}

function validateForm() {
    let isValid = true;
    form.errors = {};

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
        onError: () => {
            generalError.value = 'Please fix the errors in the form.';
        }
    });
}
</script>

<template>
    <div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen flex items-center justify-center">
        <div class="shadow-2xl rounded-2xl bg-white max-w-xl w-full p-10 mt-10 border border-blue-200 relative">
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                <div class="bg-blue-600 rounded-full p-4 shadow-lg">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-8 mt-14">
                <h2 class="text-3xl font-extrabold text-blue-700 mb-2 text-center tracking-tight">Register Tenant</h2>
                <p class="text-gray-600 text-center mb-6">Lengkapi data berikut untuk mendaftar sebagai penghuni.</p>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700" for="fullname">Full Name</label>
                    <input id="fullname" type="text" v-model="form.fullname" placeholder="Full Name"
                        :class="['border p-3 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition', form.errors.fullname ? 'border-red-600' : 'border-gray-300']" />
                    <div v-if="form.errors.fullname" class="text-red-600 mt-1 text-sm">{{ form.errors.fullname }}</div>
                </div>

                <div>
                    <label for="ktp_photo" class="block mb-2 font-semibold text-gray-700">Foto KTP</label>
                    <div class="flex flex-col items-center">
                        <label for="ktp_photo" class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed rounded-xl p-6 bg-blue-50 hover:bg-blue-100 transition
                            text-blue-700 font-semibold
                            w-full
                            mb-2
                            "
                            :class="form.errors.ktp_photo ? 'border-red-600 bg-red-50 text-red-700' : 'border-blue-300'">
                            <svg class="h-10 w-10 mb-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-5 4v-4m0 0l-2 2m2-2l2 2" />
                            </svg>
                            <span v-if="!form.ktp_photo">Klik untuk upload foto KTP</span>
                            <span v-else class="truncate">{{ form.ktp_photo.name }}</span>
                            <input id="ktp_photo" name="ktp_photo" type="file" @change="handleFileUpload"
                                accept="image/*" class="hidden" />
                        </label>
                    </div>
                    <div v-if="form.errors.ktp_photo" class="text-red-600 mt-1 text-sm">{{ form.errors.ktp_photo }}
                    </div>
                    <div v-if="ktpPreview" class="mt-3 flex justify-center">
                        <img :src="ktpPreview" alt="Preview KTP"
                            class="h-36 rounded-xl shadow-lg border border-blue-200" />
                    </div>
                </div>

                <input type="text" hidden disabled v-model="form.user_id" />

                <button :disabled="submitting" type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-xl font-bold hover:from-blue-600 hover:to-blue-800 transition disabled:opacity-50 flex items-center justify-center shadow-lg">
                    <svg v-if="submitting" class="animate-spin h-5 w-5 mr-2 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    {{ submitting ? 'Submitting...' : 'Submit' }}
                </button>

                <div v-if="generalError" class="text-red-600 mt-4 text-center font-semibold">{{ generalError }}</div>
            </form>
        </div>
    </div>
</template>
