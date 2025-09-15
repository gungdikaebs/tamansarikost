<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const { props } = usePage();
console.log(props.tenant);

const userForm = useForm({
    _method: 'put',
    profile_picture: null, // <-- File object for upload only
    profile_picture_preview: props.user.profile_picture || null, // <-- For preview
    username: props.user.username || '',
    phone: props.user.phone || '',
    email: props.user.email || '',
    password: '',
    confirm_password: '',
});

function handleProfilePictureChange(e) {
    const file = e.target.files[0];
    if (file) {
        userForm.profile_picture = file; // <-- File for upload
        userForm.profile_picture_preview = URL.createObjectURL(file); // <-- Preview
    }
}

function submitUser() {
    if (userForm.password !== userForm.confirm_password) {
        alert('Password dan konfirmasi password tidak sesuai!');
        return;
    }
    userForm.post('/dashboard/settings/user', {
        forceFormData: true,
        onSuccess: () => {
            userForm.reset(['password', 'confirm_password']);
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}


const tenantForm = useForm({
    _method: 'put',
    ktp_photo: null,
    ktp_photo_preview: props.tenant.ktp_photo || null,
    fullname: props.tenant.fullname || '',
});

function handleKtpPhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        tenantForm.ktp_photo = file;
        tenantForm.ktp_photo_preview = URL.createObjectURL(file);
    }
}

function submitTenant() {
    tenantForm.post('/dashboard/settings/tenant', {
        _method: 'put',
        forceFormData: true,
        onSuccess: () => {
            tenantForm.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}


</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="mx-auto mt-8 p-4 sm:p-6 max-w-full ">
            <h2
                class="text-center mb-8 text-2xl sm:text-3xl font-bold text-blue-700 flex items-center justify-center gap-2">
                <i class='bx bx-cog'></i>
                Account Settings
            </h2>
            <div class="flex flex-col md:flex-row gap-6">
                <form class="grid grid-cols-2 gap-6 bg-white p-8 rounded-xl shadow-lg flex-1 border border-blue-100"
                    enctype="multipart/form-data" @submit.prevent="submitUser">
                    <div class="flex flex-col items-center mb-4 col-span-2">
                        <div class="relative">
                            <img :src="userForm.profile_picture_preview ? userForm.profile_picture_preview : 'https://ui-avatars.com/api/?name=' + props.user.username"
                                alt="Profile Picture"
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-blue-200 shadow">
                            <label for="profile_picture"
                                class="absolute bottom-2 right-2 bg-blue-600 p-2 rounded-full cursor-pointer shadow-lg">
                                <i class='bx bx-camera text-white'></i> </label>
                        </div>
                        <input type="file" id="profile_picture" class="hidden" @change="handleProfilePictureChange">

                    </div>
                    <div class="col-span-2 text-center mb-4">
                        <label for="username" class="flex items-center gap-2 font-semibold text-gray-700 mb-1">
                            <i class='bx bx-user'></i>
                            Username
                        </label>
                        <input type="text" id="username" v-model="userForm.username"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            placeholder="Masukkan username">
                    </div>
                    <div class="col-span-2">
                        <label for="no_hp" class="flex items-center gap-2 font-semibold text-gray-700 mb-1">
                            <i class='bx bx-phone'></i> No Handphone
                        </label>
                        <input type="text" id="no_hp" v-model="userForm.phone"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            placeholder="Masukkan no handphone">
                    </div>
                    <div class="col-span-2">
                        <label for="email" class="flex items-center gap-2 font-semibold text-gray-700 mb-1">
                            <i class='bx bx-envelope'></i> Email
                        </label>
                        <input type="email" id="email" v-model="userForm.email"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            placeholder="Masukkan email">
                    </div>
                    <div>
                        <label for="password" class="flex items-center gap-2 font-semibold text-gray-700 mb-1">
                            <i class='bx bx-lock'></i> Password
                        </label>
                        <input type="password" id="password" v-model="userForm.password"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            placeholder="Masukkan password baru">
                    </div>
                    <div>
                        <label for="confirm_password" class="flex items-center gap-2 font-semibold text-gray-700 mb-1">
                            <i class='bx bx-lock-alt'></i> Konfirmasi Password
                        </label>
                        <input type="password" id="confirm_password" v-model="userForm.confirm_password"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            placeholder="Masukkan konfirmasi password baru">
                    </div>
                    <div class="col-span-2  mt-6 ">
                        <button type="submit"
                            class=" w-full text-center gap-2 bg-blue-600 text-white px-6 sm:px-8 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                            <i class='bx bx-save text-white'></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
                <form class="grid grid-cols-2 gap-6 bg-white p-8 rounded-xl shadow-lg flex-1 border border-blue-100"
                    enctype="multipart/form-data" @submit.prevent="submitTenant">
                    <div class="col-span-2 flex flex-col items-center mb-6">
                        <label for="ktp_photo" class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <i class='bx bx-id-card'></i> Foto KTP
                        </label>
                        <div class="relative w-full h-72 rounded-lg overflow-hidden border-2 border-blue-300 shadow">
                            <img :src="tenantForm.ktp_photo_preview ? tenantForm.ktp_photo_preview : 'https://ui-avatars.com/api/?name=' + props.tenant.fullname"
                                alt="Foto KTP"
                                class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            <label for="ktp_photo"
                                class="absolute bottom-2 right-2 bg-blue-600 p-2 rounded-full cursor-pointer shadow-lg hover:bg-blue-700 transition">
                                <i class='bx bx-camera text-white'></i>
                            </label>
                        </div>
                        <input type="file" id="ktp_photo" class="hidden" @change="handleKtpPhotoChange">
                    </div>
                    <div class="col-span-2 flex flex-col mb-4">
                        <label for="fullname" class="flex items-center gap-2 font-semibold text-gray-700 mb-1 ">
                            <i class='bx bx-user'></i> Nama Lengkap
                        </label>
                        <input type="text" id="fullname" v-model="tenantForm.fullname"
                            class="px-4 py-2 border border-blue-300 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-500 w-full shadow-sm"
                            placeholder="Masukkan Nama Lengkap">
                    </div>
                    <div class="col-span-2 mt-6">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-400 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">
                            <i class='bx bx-save text-white'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </DashboardLayouts>
</template>
