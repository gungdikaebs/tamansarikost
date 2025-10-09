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
    <div
        class="bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 min-h-screen flex items-center justify-center">
        <div
            class="max-w-4xl w-full mx-auto bg-white/90 rounded-2xl shadow-2xl flex overflow-hidden border-2 border-blue-200/40 animate-fade-in">
            <!-- Left Side: Form -->
            <div class="flex-1 p-8 md:p-16 flex flex-col justify-center gap-6">
                <div class="mb-2 flex flex-col items-center justify-center gap-2">
                    <img src="../../../assets/Images/Logo_Utama.svg" alt="Logo" class="w-20 h-20 mb-2 drop-shadow-lg" />
                    <h1>
                        <a href="/register"
                            class="text-3xl font-extrabold text-indigo-900 tracking-wide drop-shadow ">Taman
                            Sari
                            Kost</a>
                    </h1>
                    <p class="text-gray-500">Gabung bersama kami di Taman Sari Kost!</p>

                </div>

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-3">
                        <div>
                            <label for="email" class="font-semibold text-indigo-900">Email</label>
                            <div class="relative mt-1">
                                <i
                                    class='bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400'></i>
                                <input v-model="form.email" type="email" id="email" placeholder="Masukkan email anda"
                                    class="p-3 pl-10 border border-indigo-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-300 transition" />
                            </div>
                            <p v-if="errors.email" class="text-xs text-red-500 mt-1">{{ errors.email }}</p>
                        </div>
                        <div>
                            <label for="username" class="font-semibold text-indigo-900">Username</label>
                            <div class="relative mt-1">
                                <i
                                    class='bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400'></i>
                                <input v-model="form.username" type="text" id="username"
                                    placeholder="Masukkan username anda"
                                    class="p-3 pl-10 border border-indigo-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-300 transition" />
                            </div>
                            <p v-if="errors.username" class="text-xs text-red-500 mt-1">{{ errors.username }}</p>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-1/2">
                                <label for="password" class="font-semibold text-indigo-900">Password</label>
                                <div class="relative mt-1">
                                    <i
                                        class='bx bx-lock-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400'></i>
                                    <input v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                        id="password" placeholder="Password"
                                        class="p-3 pl-10 border border-indigo-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-300 transition" />
                                    <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-400"
                                        @click="showPassword = !showPassword" />
                                </div>
                                <p v-if="errors.password" class="text-xs text-red-500 mt-1">{{ errors.password }}</p>
                            </div>
                            <div class="w-1/2">
                                <label for="password_confirmation" class="font-semibold text-indigo-900">Konfirmasi
                                    Password</label>
                                <div class="relative mt-1">
                                    <i
                                        class='bx bx-key absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400'></i>
                                    <input v-model="form.password_confirmation"
                                        :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                        placeholder="Konfirmasi password"
                                        class="p-3 pl-10 border border-indigo-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-300 transition" />
                                    <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-400"
                                        @click="showPassword = !showPassword" />
                                </div>
                                <p v-if="errors.password_confirmation" class="text-xs text-red-500 mt-1">{{
                                    errors.password_confirmation }}</p>
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="font-semibold text-indigo-900">Nomor Handphone</label>
                            <div class="relative mt-1">
                                <i
                                    class='bx bx-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-400'></i>
                                <input v-model="form.phone" type="text" id="phone"
                                    placeholder="Masukkan no telepon anda"
                                    class="p-3 pl-10 border border-indigo-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-300 transition" />
                            </div>
                            <p v-if="errors.phone" class="text-xs text-red-500 mt-1">{{ errors.phone }}</p>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-3 rounded-lg w-full shadow hover:scale-105 hover:from-indigo-600 hover:to-blue-600 transition duration-200 flex items-center justify-center gap-2">
                        <span>🚀 Register Sekarang</span>
                    </button>
                </form>
                <div class="flex justify-between items-center mt-4 text-sm">
                    <a href="/" class="flex items-center font-bold text-blue-700 hover:underline">
                        <i class="bx bx-chevron-left text-xl"></i> Back
                    </a>
                    <p class="text-gray-500">Sudah punya akun?
                        <a href="/login" class="text-indigo-600 font-bold hover:underline">Login</a>
                    </p>
                </div>
            </div>
            <!-- Right Side: Image -->
            <div
                class="flex-1 hidden md:flex items-center justify-center bg-gradient-to-tr from-indigo-100 to-blue-100">
                <img src="https://i.pinimg.com/736x/05/b8/80/05b880c6b5200ad94f953b8f2f7874d7.jpg"
                    alt="Kost Illustration"
                    class="object-cover h-full  rounded-xl shadow-lg border-4 border-indigo-200" />
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.7s cubic-bezier(.4, 0, .2, 1);
}
</style>
