<script setup>
import { defineProps } from 'vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { router, useForm } from '@inertiajs/vue3';
const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    }
});

const user = useForm({
    email: props.user.email,
    username: props.user.username,
    password: '',
    phone: props.user.phone,
    role: props.user.role
});

function submit() {
    user.put(`/dashboard/users/${props.user.id}`, {
        onSuccess: () => {
            user.reset();
            router.visit('/dashboard/users');
        },
        onError: (errors) => {
            console.error(errors);
            for (const key in errors) {
                form.setError(key, errors[key])
            }
        }
    });
}

console.log(props.user);

</script>

<template>
    <DashboardLayouts :auth=props.auth>
        <div class="my-4 mx-auto">
            <h1 class="text-2xl font-bold mb-4">Edit Data Kamar</h1>
            <form class="max-w-xl" @submit.prevent="submit">
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input v-model="user.email" type="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Masukkan Email Disini!" required />
                    <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
                </div>
                <div class="mb-5">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                    <input v-model="user.username" type="text" id="username" placeholder="Masukkan Username Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required />
                    <p v-if="form.errors.username" class="text-red-500 text-sm mt-1">{{ form.errors.username }}</p>
                </div>
                <div class="mb-5">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                    <input v-model="user.phone" type="text" id="phone" placeholder="Masukkan Phone Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required />
                    <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
                </div>
                <div class="mb-5">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                    <select v-model="user.role" id="role"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="" disabled selected>Pilih Role!</option>
                        <option value="penghuni">Penghuni</option>
                        <option value="guest">guest</option>
                    </select>
                    <p v-if="form.errors.role" class="text-red-500 text-sm mt-1">{{ form.errors.role }}</p>
                </div>
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </DashboardLayouts>
</template>