<script setup>
import { ref, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import Search from '../../../components/dashboard/Search.vue';

const page = usePage();
const props = defineProps(
    {
        search: Object
    }
)

console.log(page.props.complaints);

const search = ref(props.search);

watch(search, (newSearch) => {
    router.get('/dashboard/complaints', { search: newSearch }, { preserveState: true, replace: true });
});

function truncateText(text, length = 20) {
    if (!text) return '';
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
}

function deleteComplaint(complaintId) {
    if (confirm('Apakah Anda yakin ingin menghapus Complaint ini?')) {
        router.delete(`/dashboard/complaints/${complaintId}`)
            .then(() => {
                // Handle success, e.g., show a success message or refresh the page
                window.location.reload();
            })
            .catch(error => {
                // Handle error, e.g., show an error message
                console.error('Error deleting tenant:', error);
            });
    }
}

function changeStatus(complaintId, status) {
    router.put(`/dashboard/complaints/${complaintId}/status`, { status })
        .then(() => {
            // Handle success, e.g., show a success message or refresh the page
            window.location.reload();
        })
        .catch(error => {
            // Handle error, e.g., show an error message
            console.error('Error updating complaint status:', error);
        });
}
</script>

<template>
    <DashboardLayouts :auth="page.props.auth">
        <div>
            <div class="flex justify-between my-4">
                <h1 class="text-2xl font-bold mb-4">Daftar Complaints</h1>
            </div>
            <div class="relative overflow-x-auto sm:rounded-lg p-4">
                <Search v-model:search="search" placeholder="Cari Complaint..." />

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Id</th>
                            <th scope="col" class="px-6 py-3">Penghuni</th>
                            <th scope="col" class="px-6 py-3">TItle</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="complaint in page.props.complaints" :key="complaint.id">
                        <tr class="odd:bg-white border-b  border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                {{ complaint.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ complaint.tenant.fullname }}
                            </td>
                            <td class="px-6 py-4">
                                {{ complaint.title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ truncateText(complaint.description, 20) }}
                            </td>
                            <td class="px-6 py-4">
                                <select :value="complaint.status"
                                    @change="changeStatus(complaint.id, $event.target.value)" :class="[
                                        'border rounded px-2 py-1',
                                        complaint.status === 'resolved' ? 'bg-green-100 text-green-700 border-green-400' :
                                            complaint.status === 'pending' ? 'bg-blue-100 text-blue-700 border-blue-400' :
                                                complaint.status === 'closed' ? 'bg-red-100 text-red-700 border-red-400' : ''
                                    ]">
                                    <option value="pending">Pending</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 flex gap-3 mx-auto">
                                <a :href="`/dashboard/complaints/${complaint.id}`"
                                    class="font-medium text-gray-600 hover:underline">
                                    <i class="bx bx-show text-2xl"></i>
                                </a>
                                <button @click="deleteComplaint(complaint.id)"
                                    class="cursor-pointer text-red-600 hover:underline"><i
                                        class='bx bx-trash text-2xl'></i></button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayouts>
</template>