<script setup>
import { ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();

const form = ref({
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    phone: ''
});

const errors = ref({
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    phone: ''
});

const showPassword = ref(false);

function validateForm() {
    let valid = true;
    errors.value = {
        email: '',
        username: '',
        password: '',
        password_confirmation: '',
        phone: ''
    };

    if (!form.value.email) {
        errors.value.email = 'Email wajib diisi';
        valid = false;
    }

    if (!form.value.username) {
        errors.value.username = 'Username wajib diisi';
        valid = false;
    }

    const pwd = form.value.password;
    const specialOrDigit = /[0-9!@#$%^&*(),.?":{}|<>]/;
    if (!pwd) {
        errors.value.password = 'Password wajib diisi';
        valid = false;
    } else if (pwd.length < 8) {
        errors.value.password = 'Password minimal 8 karakter';
        valid = false;
    } else if (!specialOrDigit.test(pwd)) {
        errors.value.password = 'Password harus mengandung angka atau simbol khusus';
        valid = false;
    }

    const pwdConf = form.value.password_confirmation;
    if (!pwdConf) {
        errors.value.password_confirmation = 'Konfirmasi password wajib diisi';
        valid = false;
    } else if (pwd !== pwdConf) {
        errors.value.password_confirmation = 'Password tidak cocok';
        valid = false;
    }

    if (!form.value.phone) {
        errors.value.phone = 'Nomor HP wajib diisi';
        valid = false;
    } else if (!/^((\+62)|0)[0-9]{9,13}$/.test(form.value.phone)) {
        errors.value.phone = 'Format nomor HP tidak valid';
        valid = false;
    }

    return valid;
}

// Sync Laravel errors
watch(() => page.props.errors, (newErrors) => {
    for (const key in errors.value) {
        errors.value[key] = newErrors[key] ?? '';
    }
}, { immediate: true });

function submit() {
    if (!validateForm()) return;
    router.post('/register', form.value);
}
</script>

<template>
    <div class="bg-[#EDF3FF] min-h-screen text-indigo-900/75 flex items-center">
        <div
            class="md:max-w-screen-xl max-w-[90%] mx-auto border-4 border-blue-100/30 bg-white flex p-2 rounded-xl shadow-lg">
            <div class="md:flex-1 p-10 md:p-28 flex flex-col gap-4 justify-center md:max-w-1/2">
                <h1><a href="/register" class="text-2xl font-bold text-blue-900">.Taman Sari Kost</a></h1>
                <div>
                    <h2 class="text-xl font-semibold">Register</h2>
                    <p class="text-gray-600">Gabung bersama kami di Taman Sari Kost!</p>
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-col">
                            <label for="email">Email</label>
                            <div class="relative">
                                <i
                                    class='bx bx-envelope absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.email" type="email" id="email" placeholder="masukkan email anda"
                                    class="p-2 px-8 border w-full rounded-md" />
                            </div>
                            <p v-if="errors.email" class="text-sm text-red-500">{{ errors.email }}</p>
                        </div>

                        <div class="flex flex-col">
                            <label for="username">Username</label>
                            <div class="relative">
                                <i
                                    class='bx bx-user absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.username" type="text" id="username"
                                    placeholder="masukkan username anda" class="p-2 px-8 border w-full rounded-md" />
                            </div>
                            <p v-if="errors.username" class="text-sm text-red-500">{{ errors.username }}</p>
                        </div>

                        <div class="flex justify-between gap-2">
                            <div class="flex flex-col w-full">
                                <label for="password">Password</label>
                                <div class="relative">
                                    <i
                                        class='bx bx-lock-alt absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                    <input v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                        id="password" placeholder="password"
                                        class="p-2 px-8 border w-full rounded-md" />
                                    <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-950/50"
                                        @click="showPassword = !showPassword" />
                                </div>
                                <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password }}</p>
                            </div>

                            <div class="flex flex-col w-full">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <div class="relative">
                                    <i
                                        class='bx bx-key absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                    <input v-model="form.password_confirmation"
                                        :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                        placeholder="konfirmasi password" class="p-2 px-8 border w-full rounded-md" />
                                    <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-950/50"
                                        @click="showPassword = !showPassword" />
                                </div>
                                <p v-if="errors.password_confirmation" class="text-sm text-red-500">{{
                                    errors.password_confirmation }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="phone">Nomor Handphone</label>
                            <div class="relative">
                                <i
                                    class='bx bx-phone absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.phone" type="text" id="phone"
                                    placeholder="masukkan no telepon anda" class="p-2 px-8 border w-full rounded-md" />
                            </div>
                            <p v-if="errors.phone" class="text-sm text-red-500">{{ errors.phone }}</p>
                        </div>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="bg-blue-500 text-white p-2 rounded-md w-full hover:bg-blue-600 transition duration-200">🚀
                            Register Sekarang</button>
                    </div>
                </form>
                <div class="flex justify-between">
                    <a href="/" class="text-center flex items-center font-bold text-blue-900">
                        <i class="bx bx-chevron-left text-xl"></i> Back
                    </a>
                    <p class="text-gray-600">Sudah punya akun? <a href="/login"
                            class="text-blue-500 font-bold">Login</a></p>
                </div>
            </div>
            <div class="md:flex-1 hidden md:flex items-center">
                <img src="https://i.pinimg.com/736x/05/b8/80/05b880c6b5200ad94f953b8f2f7874d7.jpg   " alt=""
                    class="object-cover h-full rounded" />
            </div>
        </div>
    </div>
</template>
