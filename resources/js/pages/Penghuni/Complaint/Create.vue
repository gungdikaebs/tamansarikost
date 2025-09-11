<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const { props } = usePage();
console.log(props.tenant);

const form = useForm({
    title: '',
    description: '',
    image: null,
    status: 'pending',
    tenant_id: props.tenant
});


const previewImg = ref(null);

function handleImageChange(e) {
    const file = e.target.files[0];
    form.image = file;
    if (file) {
        previewImg.value = URL.createObjectURL(file);
    } else {
        previewImg.value = null;
    }
}

const submitting = ref(false);

function submit() {
    submitting.value = true;
    form.post('/dashboard/complaint', {
        onSuccess: () => {
            form.reset();
            previewImg.value = null;
            submitting.value = false;
        },
        onError: () => {
            submitting.value = false;
        }
    });
}
</script>

<template>

    <Head>
        <title>Buat Pengaduan</title>
    </Head>
    <DashboardLayouts :auth="$page.props.auth">
        <div class="max-w-3xl mx-auto mt-10 bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Buat Pengaduan Baru</h2>
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Judul Pengaduan</label>
                    <input v-model="form.title" type="text"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 border-gray-300"
                        placeholder="Masukkan judul pengaduan" />
                    <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea v-model="form.description" rows="5"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 border-gray-300"
                        placeholder="Jelaskan masalah yang ingin Anda laporkan"></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Unggah Gambar (Opsional)</label>
                    <input @change="handleImageChange" type="file" accept="image/*"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 border-gray-300" />
                    <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
                    <div v-if="previewImg" class="mt-4">
                        <p class="text-gray-600 mb-2">Preview Gambar:</p>
                        <img :src="previewImg" alt="Preview" class="max-w-full h-auto rounded" />
                    </div>
                </div>
                <div class="hidden">
                    <label>Status</label>
                    <input v-model="form.status" type="text" readonly />
                </div>
                <div class="hidden">
                    <label>Tenant Id</label>
                    <input v-model="form.tenant_id" type="text" readonly />
                </div>
                <button type="submit" :disabled="submitting"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    {{ submitting ? 'Mengirim...' : 'Kirim Pengaduan' }}
                </button>
            </form>
        </div>
    </DashboardLayouts>
</template>

<style scoped>
body {
    background: #f3f4f6;
}
</style>