<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    phone: ''
});

function submit() {
    const { email, username, password, password_confirmation, phone } = form.value;

    if (!email || !username || !password || !password_confirmation || !phone) {
        alert('Please fill in all fields');
        return;
    }

    if (password !== password_confirmation) {
        alert('Passwords do not match');
        return;
    }

    router.post('/register', form.value);
}
</script>

<template>
    <div class="bg-[#EDF3FF] min-h-screen text-indigo-900/75 flex items-center">
        <div
            class="md:max-w-screen-lg max-w-[80%] mx-auto border-4 border-blue-100/30 bg-white flex p-2 rounded-xl shadow-lg">
            <div class="md:flex-1 p-5 md:p-10 flex flex-col gap-4 justify-center md:max-w-1/2">
                <h1>
                    <a href="/register" class="text-2xl font-bold text-blue-900">.Taman Sari Kost</a>
                </h1>
                <div>
                    <h2 class="text-xl font-semibold">Register</h2>
                    <p class="text-gray-600">Silahkan melakukan registrasi dengan format yang sudah disediakan</p>
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-col">
                            <label for="email">Email</label>
                            <input v-model="form.email" type="email" id="email"
                                class="p-1 px-2 border w-full rounded-md" />
                        </div>
                        <div class="flex flex-col">
                            <label for="username">Username</label>
                            <input v-model="form.username" type="text" id="username"
                                class="p-1 px-2 border w-full rounded-md" />
                        </div>
                        <div class="flex justify-between gap-2">
                            <div class="flex flex-col">
                                <label for="password">Password</label>
                                <input v-model="form.password" type="password" id="password"
                                    class="p-1 px-2 border w-full rounded-md" />
                            </div>
                            <div class="flex flex-col">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input v-model="form.password_confirmation" type="password" id="password_confirmation"
                                    class="p-1 px-2 border w-full rounded-md" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="phone">Nomor Handphone</label>
                            <input v-model="form.phone" type="text" id="phone"
                                class="p-1 px-2 border w-full rounded-md" />
                        </div>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="bg-blue-500 text-white p-2 rounded-md w-full hover:bg-blue-600 transition duration-200">
                            Register Now
                        </button>
                    </div>
                </form>
                <div class="flex justify-between">
                    <a href="/" class="text-center flex items-center">
                        <i class="bx bx-chevron-left text-2xl"></i> Back
                    </a>
                    <p class="text-gray-600">Sudah punya akun? <a href="/login" class="text-blue-500">Login</a></p>
                </div>
            </div>
            <div class="md:flex-1 hidden md:flex items-center">
                <img src="https://i.pinimg.com/736x/bd/6e/e2/bd6ee2241cd5a4527bbd57047e5ce4b2.jpg" alt=""
                    class="object-cover h-full rounded" />
            </div>
        </div>
    </div>
</template>
