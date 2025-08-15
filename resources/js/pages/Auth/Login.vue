<script setup>
import { ref, computed, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage();
const authError = computed(() => page.props?.errors?.auth || '');

const form = ref({
    username: '',
    password: ''
});

const errors = ref({
    username: '',
    password: ''
});

const showPassword = ref(false);

function validateForm() {
    let valid = true;
    errors.value = { username: '', password: '' };

    if (!form.value.username) {
        errors.value.username = 'Username wajib diisi';
        valid = false;
    }

    if (!form.value.password) {
        errors.value.password = 'Password wajib diisi';
        valid = false;
    }

    return valid;
}

function submit() {
    if (!validateForm()) return;
    router.post('/login', form.value);
}

watch(() => [form.value.username, form.value.password], () => {
    errors.value.username = '';
    errors.value.password = '';
});
</script>

<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-indigo-200 to-pink-100">
        <div
            class="max-w-4xl w-full mx-auto bg-white rounded-3xl shadow-2xl flex overflow-hidden animate-fade-in border border-blue-100/40">
            <div class="flex-1 p-10 md:p-20 flex flex-col gap-6 justify-center">
                <div class="flex flex-col items-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo"
                        class="w-16 h-16 mb-2 drop-shadow-lg" />
                    <h1>
                        <a href="/login" class="text-3xl font-extrabold text-blue-900 tracking-wide drop-shadow">Taman
                            Sari Kost</a>
                    </h1>
                </div>
                <div class="text-center mb-2">
                    <h2 class="text-xl font-semibold text-blue-950">Selamat datang kembali 👋</h2>
                    <p class="text-gray-600">Silakan isi data sesuai dengan formulir di bawah ini.</p>
                </div>

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <p v-if="authError" class="text-lg text-red-500 mt-2 text-center animate-shake">
                        {{ authError }}
                    </p>

                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col">
                            <label for="username" class="font-medium text-blue-900 mb-1">Username</label>
                            <div class="relative">
                                <i
                                    class='bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.username" type="text" id="username"
                                    class="p-3 pl-10 border-2 border-blue-100 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                                    placeholder="Masukkan username" />
                            </div>
                            <p v-if="errors.username" class="text-sm text-red-500 mt-1">{{ errors.username }}</p>
                        </div>

                        <div class="flex flex-col">
                            <label for="password" class="font-medium text-blue-900 mb-1">Password</label>
                            <div class="relative">
                                <i
                                    class='bx bx-lock-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.password" :type="showPassword ? 'text' : 'password'" id="password"
                                    class="p-3 pl-10 pr-10 border-2 border-blue-100 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                                    placeholder="Masukkan password" />
                                <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-950/50 hover:text-blue-500 transition"
                                    @click="showPassword = !showPassword" />
                            </div>
                            <p v-if="errors.password" class="text-sm text-red-500 mt-1">{{ errors.password }}</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold p-3 rounded-lg w-full hover:from-blue-600 hover:to-indigo-600 transition duration-200 shadow-md">
                        Login
                    </button>
                </form>

                <div class="flex justify-between mt-6 text-sm">
                    <a href="/register" class="flex items-center font-bold text-blue-900 ">
                        <i class='bx bx-user text-xl pr-2'></i> Register
                    </a>
                    <a href="/forgot-password" class="text-blue-500 hover:underline">Forgot Password?</a>
                </div>
            </div>

            <div
                class="flex-1 hidden md:flex items-center justify-center bg-gradient-to-tr from-blue-100 via-indigo-100 to-pink-100">
                <img src="https://i.pinimg.com/736x/bd/6e/e2/bd6ee2241cd5a4527bbd57047e5ce4b2.jpg" alt=""
                    class="object-cover h-full rounded-2xl shadow-lg border-4 border-blue-100/30" />
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

@keyframes shake {

    0%,
    100% {
        transform: translateX(0);
    }

    20%,
    60% {
        transform: translateX(-6px);
    }

    40%,
    80% {
        transform: translateX(6px);
    }
}

.animate-shake {
    animation: shake 0.4s;
}
</style>
