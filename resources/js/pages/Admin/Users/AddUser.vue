<script setup>
import { defineProps } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: false,
    }
});

const form = useForm({
    email: '',
    username: '',
    password: '',
    phone: '',
    role: 'penghuni'
});

function submit() {

    router.post('/dashboard/users', form, {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            // error backend otomatis masuk ke form.errors
            console.error(errors);
            for (const key in errors) {
                form.setError(key, errors[key])
            }
        }
    });
}

// console.log(props.auth.user);
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="my-4 mx-auto bg-white shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">Insert Data User</h1>
            <form class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                    <input v-model="form.email" type="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan Email Disini!" required />
                    <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>

                </div>
                <div class="mb-5">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 ">Username</label>
                    <input v-model="form.username" type="text" id="username" placeholder="Masukkan Username Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5  "
                        required />
                    <p v-if="form.errors.username" class="text-red-500 text-sm mt-1">{{ form.errors.username }}</p>

                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                    <input v-model="form.password" type="password" id="password"
                        placeholder="Masukkan Deskripsi Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5  "
                        required />
                    <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>

                </div>
                <div class="mb-5">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">Phone</label>
                    <input v-model="form.phone" type="text" id="phone" placeholder="Masukkan Deskripsi Kamar Disini!"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5  "
                        required />
                    <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>

                </div>
                <div class="mb-5" hidden>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 ">Role</label>
                    <input type="text" v-model="form.role">
                    <p v-if="form.errors.role" class="text-red-500 text-sm mt-1">{{ form.errors.role }}</p>

                </div>
                <button @click.prevent="submit" :disabled="form.processing"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Submit</button>
            </form>
        </div>
    </DashboardLayouts>

</template>