<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({
    username: '',
    password: ''
});

function submit() {
    const { username, password } = form.value;
    console.log(form.value);

    // Validasi sederhana
    if (!username || !password) {
        alert('username and Password are required');
        return;
    }

    // Kirim data login ke backend
    router.post('/login', form.value);
}
</script>

<template>
    <div class="bg-[#EDF3FF] min-h-screen text-indigo-900/75 flex items-center ">
        <div
            class="md:max-w-screen-lg max-w-[80%] min-w-[80%]:  mx-auto border-4 border-blue-100/30 bg-white  flex p-2 rounded-xl shadow-lg">
            <div class="md:flex-1 p-5 md:p-10 flex flex-col gap-4 justify-center md:max-w-1/2">
                <h1 class="">
                    <a href="/login" class="text-2xl font-bold text-blue-900 ">.Taman Sari Kost</a>
                </h1>
                <div class="">
                    <h2 class="text-xl font-semibold ">
                        Login
                    </h2>
                    <p class="text-gray-600">jika sudah memiliki akun silahkan anda memasukan data - data sesuai dengan
                        form</p>
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-3">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-col">
                            <label for="username">Username</label>
                            <input type="text" v-model="form.username" name="username" id="username"
                                class="p-1 border w-full  rounded-md">
                        </div>
                        <div class="flex flex-col">
                            <label for="password">Password</label>
                            <input type="password" v-model="form.password" name="password" id="password"
                                class="p-1 border w-full  rounded-md">
                        </div>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="bg-blue-500 text-white p-2 rounded-md w-full hover:bg-blue-600 transition duration-200">
                            Login
                        </button>
                    </div>
                </form>
                <div class="flex justify-between ">
                    <a href="/register" class="text-center flex items-center"> <i
                            class='bx bx-chevron-left text-2xl'></i>
                        Register
                    </a>
                    <a href="/forgot-password" class="text-blue-500">Forgot Password</a>
                </div>
            </div>
            <div class="md:flex-1 hidden md:flex items-center ">
                <img src="https://i.pinimg.com/736x/bd/6e/e2/bd6ee2241cd5a4527bbd57047e5ce4b2.jpg" alt=""
                    class="object-cover h-full rounded">
            </div>


        </div>
    </div>

</template>