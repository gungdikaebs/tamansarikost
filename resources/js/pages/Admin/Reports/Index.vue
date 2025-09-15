<script setup>
import { router, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
import { ref, watch } from 'vue';
import Swal from 'sweetalert2';


const { props } = usePage();

const filters = ref({
    start_date: '',
    end_date: '',
});

watch(() => props.filters, (newFilters) => {
    filters.value.start_date = newFilters.start_date || '';
    filters.value.end_date = newFilters.end_date || '';
}, { immediate: true });

function applyFilter() {
    router.get('reports', {
        start_date: filters.value.start_date,
        end_date: filters.value.end_date,
    }, {
        preserveState: false,
        replace: true,
    });
}

function dateStr(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

function deleteReport(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/dashboard/reports/${id}`);
        }
    });
}

function submit() {
    form.post('/admin/reports');
}
</script>
<template>
    <div class="min-h-screen bg-gray-50 py-8">
        <DashboardLayouts :auth="props.auth">
            <div class="mx-auto  bg-white  p-8">
                <h1 class="text-2xl font-bold mb-8 text-gray-800 text-center">Laporan Keuangan</h1>
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-8">
                    <!-- Form Filter -->
                    <form @submit.prevent="applyFilter"
                        class="flex flex-col md:flex-row gap-4 items-end w-full md:w-auto">
                        <div>
                            <label class="text-xs text-gray-600 mb-1 block">Mulai</label>
                            <input type="date" v-model="filters.start_date"
                                class="border border-gray-300 px-3 py-2 rounded focus:ring focus:ring-blue-200 text-sm w-full"
                                required />
                        </div>
                        <div>
                            <label class="text-xs text-gray-600 mb-1 block">Selesai</label>
                            <input type="date" v-model="filters.end_date"
                                class="border border-gray-300 px-3 py-2 rounded focus:ring focus:ring-blue-200 text-sm w-full"
                                required />
                        </div>
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow hover:from-blue-700 hover:to-blue-500 transition flex items-center gap-2">
                            <i class='bx bx-filter'></i>
                            Filter
                        </button>
                    </form>
                    <div class="w-full md:w-auto md:ms-auto">
                        <a href="/dashboard/reports/create"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center gap-2 justify-center md:justify-start shadow transition">
                            Tambah Laporan
                            <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Tabel Data Laporan -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm bg-white">
                        <thead>
                            <tr class="border-b bg-gray-100">
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold">Id</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold">Tipe</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold">Jumlah</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-semibold">Deskripsi</th>
                                <th class="px-4 py-3 text-center text-gray-700 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="report in props.reports" :key="report.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-800">{{ report.id }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ dateStr(report.date) }}</td>
                                <td class="px-4 py-3">
                                    <span :class="report.type === 'income' ? 'text-green-600' : 'text-red-600'">
                                        {{ report.type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-semibold"
                                    :class="report.type === 'income' ? 'text-green-600' : 'text-red-600'">
                                    Rp {{ Number(report.amount).toLocaleString('id-ID') }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ report.description }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a :href="`/dashboard/reports/${report.id}/edit`"
                                            class="inline-flex items-center justify-center bg-gray-100 hover:bg-blue-100 text-blue-600 rounded-full p-2 transition shadow-sm"
                                            title="Edit">
                                            <i class="bx bx-edit text-xl"></i>
                                        </a>
                                        <button @click="deleteReport(report.id)"
                                            class="inline-flex items-center justify-center bg-gray-100 hover:bg-red-100 text-red-600 rounded-full p-2 transition shadow-sm">
                                            <i class="bx bx-trash text-xl"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!props.reports || props.reports.length === 0">
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic">Tidak ada data
                                    laporan.
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-4 py-4 text-right text-gray-700 font-semibold">Subtotal :</td>
                                <td class="px-4 py-4 font-bold text-green-700 text-base" colspan="3">
                                    Rp {{ Number(props.subtotalNetto).toLocaleString('id-ID') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </DashboardLayouts>
    </div>
</template>
