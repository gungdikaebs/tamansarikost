<script setup>
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import { defineProps, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Search from '../../components/dashboard/Search.vue';

const props = defineProps({
    auth: {
        type: Object,
        required: false,
    },
    tenants: {
        type: Object,
        required: true
    },
    search: {
        type: String,
        default: '',
    },

});

const search = ref(props.search);

watch(search, (newSearch) => {
    router.get('/dashboard/tenants', { search: newSearch }, { preserveState: true, replace: true });
});


const selectedPhoto = ref(null);
const isModalVisible = ref(false);

function showPhotoPreview(photoUrl) {
    selectedPhoto.value = photoUrl;
    isModalVisible.value = true;
}

function closeModal() {
    isModalVisible.value = false;
    selectedPhoto.value = null;
}

function deleteTenant(tenantId) {
    if (confirm('Apakah Anda yakin ingin menghapus penghuni ini?')) {
        router.delete(`/dashboard/tenants/${tenantId}`)
            .then(response => {
                // Handle success, e.g., show a success message or refresh the page
                window.location.reload();
            })
            .catch(error => {
                // Handle error, e.g., show an error message
                console.error('Error deleting tenant:', error);
            });
    }
}

console.log(props.tenants);
</script>

<template>
    <DashboardLayouts :auth='props.auth'>
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Penghuni</h1>
            <a href="/dashboard/tenants/create"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah Penghuni
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
        <div class="relative overflow-x-auto sm:rounded-lg p-4">
            <Search v-model:search="search" placeholder="Cari Penghuni..." />
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fullname
                        </th>
                        <th scope="col" class="px-6 py-3">
                            KTP Foto
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>

                    </tr>
                </thead>
                <tbody v-for="tenant in props.tenants" :key="tenant.id">
                    <tr class="odd:bg-white border-b  border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                            {{ tenant.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ tenant.user.username }}
                        </td>
                        <td class="px-6 py-4">
                            {{ tenant.fullname }}
                        </td>

                        <td class="px-6 py-4">
                            <img :src="tenant.ktp_photo_url" alt="" class="w-24 cursor-pointer"
                                @click="showPhotoPreview(tenant.ktp_photo_url)" />
                        </td>

                        <td class="px-6 py-4 flex gap-3 mx-auto">
                            <a :href="`/dashboard/users/${tenant.user_id}`"
                                class="font-medium text-gray-600 hover:underline">
                                <i class="bx bx-show text-2xl"></i>
                            </a>
                            <a :href="'/dashboard/tenants/' + tenant.id + '/edit'"
                                class="font-medium text-blue-600 hover:underline"><i
                                    class='bx bx-edit text-2xl'></i></a>
                            <button @click="deleteTenant(tenant.id)"
                                class="cursor-pointer text-red-600 hover:underline"><i
                                    class='bx bx-trash text-2xl'></i></button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="isModalVisible" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
            @click.self="closeModal">
            <div class="bg-white p-10 rounded shadow-lg max-w-3xl max-h-full overflow-auto relative">
                <button @click="closeModal"
                    class="absolute top-2 right-2 text-red-600 font-bold text-xl leading-none hover:text-red-800">
                    <i class='bx bx-x text-3xl'></i>
                </button>
                <img :src="selectedPhoto" alt="Preview Foto" class="max-w-full max-h-[80vh]" />
            </div>
        </div>
    </DashboardLayouts>
</template>