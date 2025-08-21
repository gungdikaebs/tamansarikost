<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const form = useForm({
    title: '',
    description: '',
});

const submitting = ref(false);

function submit() {
    submitting.value = true;
    form.post(route('complaint.store'), {
        onFinish: () => submitting.value = false,
    });
}
</script>

<template>
    <DashboardLayouts :auth="$page.props.auth">
        <div class="max-w-3xl mx-auto mt-10 bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Buat Pengaduan Baru</h2>
            <form @submit.prevent="submit" class="space-y-5">
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