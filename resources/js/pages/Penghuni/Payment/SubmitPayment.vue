<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { usePage, useForm, router } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';
const page = usePage();

const defineProps = defineProps({
    flash: {
        type: Object,
        required: true,
    }
});

const form = useForm({
    payment_id: page.props.payment.id,
    amount: page.props.payment.amount,
    payment_date: new Date().toISOString().slice(0, 10),
    billing_period: page.props.payment.billing_period,
    payment_method: null,
    payment_status: 'pending',
    penalty_fee: page.props.payment.penalty_fee,
    room_tenant_id: page.props.payment.room_tenant_id,
    payment_photo: null,
});

console.log(page.props.payment);

function submitForm() {
    router.post('/dashboard/payment', form, {
        method: 'put',
        onSuccess: () => {
            form.reset();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Pembayaran berhasil diajukan!',
                timer: 3000,
                showConfirmButton: false
            });
        },
        onError: () => {
            // Ambil pesan error dari props flash
            const errorMsg = defineProps.flash?.error || 'Terjadi kesalahan saat mengirim pembayaran.';
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: errorMsg,
            });
        }
    });
}

</script>



<template>
    <DashboardLayouts :auth="page.props.auth">
        <div class=" mx-auto bg-gradient-to-br from-blue-50 to-white p-8 rounded-xl shadow-lg space-y-8">
            <div class="flex items-center space-x-3">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-3xl font-extrabold text-blue-500">Form Pembayaran</h2>
            </div>
            <div class="bg-white rounded-lg shadow p-5 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-400">
                    <span class="text-gray-700">Jumlah Tagihan</span>
                    <span class="font-semibold text-gray-900">Rp {{ form.amount.toLocaleString() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-400">
                    <span class="text-gray-700">Denda</span>
                    <span class="font-semibold text-red-600">Rp {{ form.penalty_fee.toLocaleString() }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-700">Total Bayar</span>
                    <span class="font-bold text-blue-700 text-lg">
                        Rp {{ (Number(form.amount) + Number(form.penalty_fee)).toLocaleString() }}
                    </span>
                </div>
            </div>
            <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Pembayaran</label>
                    <input type="date" v-model="form.payment_date"
                        class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>

                    <div class="flex items-center space-x-4 my-4">
                        <div class="flex items-center">
                            <input type="radio" v-model="form.payment_method" value="transfer" class="mr-2" />
                            <label class="flex flex-col">
                                <span class="font-medium">Transfer</span>
                                <span class="text-md text-gray-500">Bank Mandiri : 1450014322321
                                    <br>
                                    A.A. Dika Surya Putra</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 my-4">
                        <div class="flex items-center">
                            <input type="radio" v-model="form.payment_method" value="cash" class="mr-2" />
                            <label class="flex flex-col">
                                <span class="font-medium">Tunai</span>
                                <span class="text-md text-gray-500">Anda Bisa Langsung melakukan pembayaran kepada
                                    Petugas</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Foto Bukti Pembayaran</label>
                    <input type="file" @change="e => form.payment_photo = e.target.files[0]"
                        class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                </div>
                <button type="submit" :disabled="form.processing"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-400 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-500 transition shadow">
                    <span v-if="form.processing">
                        <svg class="inline w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Mengirim...
                    </span>
                    <span v-else>Kirim Pembayaran</span>
                </button>
            </form>
        </div>
    </DashboardLayouts>
</template>
