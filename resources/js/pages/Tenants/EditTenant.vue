<script setup>
import { defineProps, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    auth: Object,
    tenant: Object,
    users: Array
});

const form = useForm({
    _method: 'put',
    user_id: props.tenant.user_id,
    fullname: props.tenant.fullname,
    ktp_photo: null,
});

const previewUrl = ref(props.tenant.ktp_photo ? `/storage/${props.tenant.ktp_photo}` : null);

function handleKtpChange(e) {
    const file = e.target.files[0];
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
        form.ktp_photo = file;
    }
}

function submit() {
    form.post(`/dashboard/tenants/${props.tenant.id}`, {
        forceFormData: true,
    });
}
</script>

<template>
    <DashboardLayouts :auth="auth">
        <div class="my-4 mx-auto max-w-xl">
            <h1 class="text-2xl font-bold mb-4">Edit Data Penghuni</h1>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <!-- User Select -->
                <div class="mb-5">
                    <label for="user_id" class="block mb-2 text-sm font-medium">User</label>
                    <select v-model="form.user_id" id="user_id"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5">
                        <option value="" disabled>Pilih User</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.username }}</option>
                    </select>
                    <p v-if="form.errors.user_id" class="text-red-500 text-sm">{{ form.errors.user_id }}</p>
                </div>

                <!-- Fullname -->
                <div class="mb-5">
                    <label for="fullname" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                    <input v-model="form.fullname" type="text" id="fullname"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5" />
                    <p v-if="form.errors.fullname" class="text-red-500 text-sm">{{ form.errors.fullname }}</p>
                </div>

                <!-- KTP Photo -->
                <div class="mb-5">
                    <label for="ktp_photo" class="block mb-2 text-sm font-medium">Foto KTP</label>

                    <img v-if="previewUrl" :src="previewUrl" class="w-32 mb-2 rounded" />

                    <input type="file" id="ktp_photo" @change="handleKtpChange"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" />
                    <p v-if="form.errors.ktp_photo" class="text-red-500 text-sm">{{ form.errors.ktp_photo }}</p>
                </div>

                <!-- Submit -->
                <button type="submit" :disabled="form.processing"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-5 py-2.5">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </DashboardLayouts>
</template>
