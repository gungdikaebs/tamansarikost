<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const { props } = usePage();
const form = useForm({
    amount: null,
    type: null,
    description: null,
    date: null
});

function submit() {
    form.post('/dashboard/reports');
}

</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div class="p-6 mx-auto bg-white rounded-lg">
                <h1 class="text-2xl font-bold mb-4 text-center">Tambah Report Baru</h1>
                <form @submit.prevent="submit" class="space-y-4 max-w-lg mx-auto" enctype="multipart/form-data">
                    <div class="mb-5">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah</label>
                        <input v-model="form.amount" id="amount" type="number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    </div>
                    <div class="mb-5">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 ">Tipe</label>
                        <select v-model="form.type" id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option disabled>Pilih Jenis Transaksi</option>
                            <option value="outcome">Penegeluaran</option>
                            <option value="income">Pemasukan</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 ">Deskripsi</label>
                        <textarea v-model="form.description" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </textarea>
                    </div>
                    <div class="mb-5">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal</label>
                        <input v-model="form.date" id="date" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    </div>
                    <div class="mb-5">
                        <button type="submit"
                            class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Tambah Report
                        </button>
                    </div>
                </form>
            </div>
        </DashboardLayouts>
    </div>
</template>