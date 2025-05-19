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
    <div class="bg-[#EDF3FF] min-h-screen text-indigo-900/75 flex items-center">
        <div
            class="md:max-w-screen-xl max-w-[90%] mx-auto border-4 border-blue-100/30 bg-white flex p-2 rounded-xl shadow-lg">
            <div class="md:flex-1 p-10 md:p-28 flex flex-col gap-4 justify-center md:max-w-1/2">
                <h1>
                    <a href="/login" class="text-2xl font-bold text-blue-900">.Taman Sari Kost</a>
                </h1>
                <div>
                    <h2 class="text-xl font-semibold text-blue-950">Selamat datang kembali 👋</h2>
                    <p class="text-gray-600">Silakan isi data sesuai dengan formulir di
                        bawah
                        ini.

                    </p>
                </div>

                <form @submit.prevent="submit" class="flex flex-col gap-3">
                    <!-- Global auth error -->
                    <p v-if="authError" class="text-lg text-red-500  mt-2">
                        {{ authError }}
                    </p>

                    <div class="flex flex-col gap-2">
                        <!-- Username -->
                        <div class="flex flex-col">
                            <label for="username">Username</label>
                            <div class="relative">
                                <i
                                    class='bx bx-user absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.username" type="text" id="username"
                                    class="p-2 px-8 border w-full rounded-md" />
                            </div>
                            <p v-if="errors.username" class="text-sm text-red-500">{{ errors.username }}</p>
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col">
                            <label for="password">Password</label>
                            <div class="relative">
                                <i
                                    class='bx bx-lock-alt absolute left-2 top-1/2 transform -translate-y-1/2 text-indigo-950/50'></i>
                                <input v-model="form.password" :type="showPassword ? 'text' : 'password'" id="password"
                                    class="p-2 px-8 border w-full rounded-md" />
                                <i :class="showPassword ? 'bx bx-show' : 'bx bx-hide'"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 cursor-pointer text-indigo-950/50"
                                    @click="showPassword = !showPassword" />
                            </div>
                            <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password }}</p>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="w-full">
                        <button type="submit"
                            class="bg-blue-500 text-white p-2 rounded-md w-full hover:bg-blue-600 transition duration-200">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Links -->
                <div class="flex justify-between">
                    <a href="/register" class="text-center flex items-center font-bold text-blue-900">
                        <i class='bx bx-user text-xl pr-2'></i> Register
                    </a>
                    <a href="/forgot-password" class="text-blue-500">Forgot Password</a>
                </div>
            </div>

            <!-- Right image -->
            <div class="md:flex-1 hidden md:flex items-center">
                <img src="https://i.pinimg.com/736x/bd/6e/e2/bd6ee2241cd5a4527bbd57047e5ce4b2.jpg" alt=""
                    class="object-cover h-full rounded" />
            </div>
        </div>
    </div>
</template>
