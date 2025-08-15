<script setup>
import Swal from 'sweetalert2';
import { defineProps, onMounted, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Search from '../../../components/dashboard/Search.vue';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    users: Object,
    auth: Object,
    flash: Object,
    search: {
        type: String,
        default: '',
    },
    sort_by: String,
    sort_order: {
        type: String,
        default: 'asc',
    },
});


const search = ref(props.search);

watch(search, (newSearch) => {
    router.get(
        '/dashboard/users',
        { search: newSearch, sort_by: sortBy.value, sort_order: sortOrder.value },
        { preserveState: true, replace: true }
    );
});
let sortBy = ref('');
let sortOrder = ref('');

console.log(props.sort_by, props.sort_order);

function toggleSortRole() {
    if (sortBy.value !== 'role') {
        sortBy.value = 'role';
        sortOrder.value = 'asc';
    } else if (sortOrder.value === 'asc') {
        sortOrder.value = 'desc';
    } else {
        // Anda bisa reset sorting atau loop kembali asc
        sortOrder.value = 'asc';
    }
}

watch([search, sortBy, sortOrder], ([newSearch, newSortBy, newSortOrder]) => {
    router.get('/dashboard/users',
        { search: newSearch, sort_by: newSortBy, sort_order: newSortOrder },
        { preserveState: true, replace: true });
});

onMounted(() => {
    if (alertMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: alertMessage,
            confirmButtonText: 'OK'
        });
    }
});

function deleteUser(userId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Pengumuman ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/dashboard/users/${userId}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire(
                        'Terhapus!',
                        'Pengumuman berhasil dihapus.',
                        'success'
                    );
                },
                onError: () => {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus pengumuman.',
                        'error'
                    );
                }
            });
        }
    });
}

</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Users</h1>
            <a href="/dashboard/users/create"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah User
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg p-4">
            <Search v-model:search="search" placeholder="Cari user..." />

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Id</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Username</th>
                        <th scope="col" class="px-6 py-3">Phone</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" @click="toggleSortRole">
                            Role
                            <span v-if="sortBy === 'role'">
                                <i v-if="sortOrder === 'asc'" class="bx bx-up-arrow-alt"></i>
                                <i v-else class="bx bx-down-arrow-alt"></i>
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody v-for="user in props.users" :key="user.id">
                    <tr class="odd:bg-white border-b  border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                            {{ user.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ user.email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.username }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.phone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.role }}
                        </td>
                        <td class="px-6 py-4 flex gap-3 mx-auto">
                            <a :href="`/dashboard/users/${user.id}`" class="font-medium text-gray-600 hover:underline">
                                <i class="bx bx-show text-2xl"></i>
                            </a>
                            <a :href="'/dashboard/users/' + user.id + '/edit'"
                                class="font-medium text-blue-600 hover:underline"><i class='bx bx-edit text-2xl'></i>
                            </a>

                            <button @click="deleteUser(user.id)" class="cursor-pointer text-red-600 hover:underline"><i
                                    class='bx bx-trash text-2xl'></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayouts>


</template>
