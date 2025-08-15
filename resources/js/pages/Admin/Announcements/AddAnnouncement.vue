<script setup>
import { usePage, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import TipTap from '../../../components/dashboard/TipTap.vue';

const page = usePage()
const form = useForm({
    title: '',
    content: '',
    image: null
});



const fileInput = ref(null);
function submit() {
    if (fileInput.value && fileInput.value.files.length > 0) {
        form.image = fileInput.value.files[0];
    }
    form.post('/dashboard/announcements', {
        preserveState: true,
        onError: () => {
            console.log('validation errors:', page.props.errors);
        },
        onSuccess: () => {
            console.log('Redirect success, Inertia should navigate automatically.');
        },
    });
}
</script>

<template>
    <DashboardLayouts :auth="page.props.auth">
        <div class="p-6 mx-auto bg-white rounded-lg">
            <h1 class="text-2xl font-bold mb-4 text-center">Tambah Information Baru</h1>
            <form @submit.prevent="submit" class="space-y-4 max-w-xl mx-auto" enctype="multipart/form-data">
                <!-- Input Jumlah Pembayaran (auto terisi, bisa diedit) -->
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">Title</label>
                    <input v-model="form.title" id="title" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                </div>
                <div class="mb-5">
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 ">Content</label>
                    <TipTap v-model="form.content" class="border-1" />
                </div>
                <!-- Input Gambar -->
                <div class="mb-5">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 ">Gambar</label>
                    <input ref="fileInput" id="image" type="file" accept="image/*"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                </div>
                <!-- Submit button -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white rounded py-2 px-4 hover:bg-blue-700">
                        Tambah Information
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayouts>
</template>