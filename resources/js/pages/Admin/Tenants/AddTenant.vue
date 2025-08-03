<script setup>
import { useForm } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: Object,
    users: Array,
});

console.log(props);
const form = useForm({
    user_id: '',
    fullname: '',
    ktp_photo: null,
});

function handleFileUpload(event) {
    form.ktp_photo = event.target.files[0];
}

function submit() {
    form.post('/dashboard/tenants', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}

console.log(props.auth.user);
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="my-4 mx-auto">
            <h1 class="text-2xl font-bold mb-4 text-center">Insert Data Penghuni </h1>
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 ">User</label>
                    <select v-model="form.user_id" id="user_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5">
                        <option value="" disabled selected>Pilih Username yang terkait</option>
                        <option v-for="user in props.users" :key="user.id" :value="user.id">
                            {{ user.username }}
                        </option>
                    </select>
                    <div v-if="form.errors.user_id">{{ form.errors.user_id }}</div>
                </div>

                <div class="mb-5">
                    <label for="fullname" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Lengkap</label>
                    <input v-model="form.fullname" type="text" id="fullname"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan nama lengkap!" required />
                    <div v-if="form.errors.user_id">{{ form.errors.user_id }}</div>

                </div>

                <div class="mb-5">
                    <label for="ktp_photo" class="block mb-1 font-medium">Foto KTP</label>
                    <input id="ktp_photo" name="ktp_photo" type="file" @change="handleFileUpload" accept="image/*"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5" />
                    <div v-if="form.errors.ktp_photo">{{ form.errors.ktp_photo }}</div>

                </div>

                <button type="submit" :disabled="form.processing"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
            </form>
        </div>
    </DashboardLayouts>

</template>