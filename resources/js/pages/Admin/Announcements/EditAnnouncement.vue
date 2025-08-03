<script setup>
import TipTap from '../../../components/dashboard/TipTap.vue';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const page = usePage();
console.log(page.props.announcement);

const form = useForm({
    _method: 'put',
    title: page.props.announcement.title || '',
    content: page.props.announcement.content || '',
    image: null
});


const previewUrl = ref(page.props.announcement.image ? `/storage/${page.props.announcement.image}` : null);

function handleImageChange(e) {
    const file = e.target.files[0];
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
        form.image = file;
    }
}

function submit() {
    if (form.image) {
        form.post(`/dashboard/announcements/${page.props.announcement.id}`, {
            forceFormData: true,
            onSuccess: () => {
                console.log('Announcement updated successfully');
            },
            onError: (errors) => {
                console.error('Error updating announcement:', errors);
            }
        });
    } else {
        form.post(`/dashboard/announcements/${page.props.announcement.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Announcement updated successfully without image');
            },
            onError: (errors) => {
                console.error('Error updating announcement:', errors);
            }
        });
    }
}

</script>

<template>
    <DashboardLayouts :auth="page.props.auth">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">Edit Information</h1>
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input v-model="form.title" id="title" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                </div>
                <div class="mb-5">
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                    <TipTap v-model="form.content" class="border-1" />
                </div>
                <div class="mb-5">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                    <img v-if="previewUrl" :src="previewUrl" alt="Preview Image" class="mb-2 w-full h-auto rounded">
                    <input type="file" id="image" @change="handleImageChange"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />

                </div>
                <div>
                    <button type="submit" class="bg-blue-600 text-white rounded py-2 px-4 hover:bg-blue-700">Update
                        Information</button>
                </div>

            </form>
        </div>


    </DashboardLayouts>
</template>