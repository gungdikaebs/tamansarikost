<script setup>
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import Swal from 'sweetalert2';
import { router, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const page = usePage();
const alertMessage = page.props.flash?.success || null;

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

console.log(page.props.announcements);

function deleteAnnouncement(id) {
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
            router.delete(`/dashboard/announcements/${id}`, {
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

function truncateHtml(html, maxLength) {
    const div = document.createElement('div');
    div.innerHTML = html;
    const text = div.textContent || div.innerText || '';
    if (text.length <= maxLength) {
        return html;
    }
    // potong teks murni
    const truncatedText = text.slice(0, maxLength) + '...';

    // kembalikan teks biasa (tanpa HTML) sebagai fallback
    return truncatedText;
}

</script>

<template>
    <div>
        <DashboardLayouts :auth="page.props.auth">
            <div class="flex justify-between my-4">
                <h1 class="text-2xl font-bold mb-4">Daftar Pengumuman</h1>
                <a href="/dashboard/announcements/create"
                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                    Tambah Information
                    <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
            <div class="relative overflow-x-auto p-4 sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-5">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Id</th>
                            <th scope="col" class="px-6 py-3">Judul</th>
                            <th scope="col" class="px-6 py-3">Deskripsi</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody v-for="announcement in page.props.announcements" :key="announcement.id">
                        <tr class="odd:bg-white border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ announcement.id }}
                            </th>
                            <td class="px-6 py-4">{{ announcement.title }}</td>
                            <td class="px-6 py-4" v-html="truncateHtml(announcement.content, 20)"></td>
                            <td class="px-6 py-4 flex gap-3 mx-auto">
                                <a :href="`/dashboard/announcements/${announcement.id}`"
                                    class="font-medium text-gray-600 hover:underline">
                                    <i class="bx bx-show text-2xl"></i>
                                </a>
                                <a :href="`/dashboard/announcements/${announcement.id}/edit`"
                                    class="font-medium text-blue-600 hover:underline">
                                    <i class='bx bx-edit text-2xl'></i>
                                </a>
                                <button @click="deleteAnnouncement(announcement.id)"
                                    class="cursor-pointer text-red-600 hover:underline">
                                    <i class='bx bx-trash text-2xl'></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </DashboardLayouts>
    </div>
</template>