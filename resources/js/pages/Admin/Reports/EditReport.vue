<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const { props } = usePage();
const form = useForm({
    amount: props.report.amount,
    type: props.report.type,
    description: props.report.description,
    date: props.report.date
});

function submit() {
    form.put(`/dashboard/reports/${props.report.id}`, {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            console.log('validation errors:', props.errors)
        }
    })
}
</script>

<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <h1 class="text-2xl font-bold mb-4 text-center p-6">Edit Pembayaran</h1>
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                    <input type="number" v-model="form.amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5" />
                </div>
                <div class="mb-5">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Tipe</label>
                    <select name="type" id="type" v-model="form.type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5">
                        <option value="income">Pemasukan</option>
                        <option value="outcome">Pengeluaran</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea id="description" v-model="form.description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5"></textarea>
                </div>
                <div class="mb-5">
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                    <input type="date" v-model="form.date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5" />
                    <div class="mt-2 text-sm text-gray-700">Tanggal dipilih: {{ form.date }}</div>
                </div>
                <div class="mb-5">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Update Report
                    </button>
                </div>
            </form>
        </DashboardLayouts>
    </div>
</template>