<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    payment: Object,
    auth: Object
})

console.log(props.payment.room_tenant.payee_id);

// Form state dengan InertiaJS useForm
const form = useForm({
    _method: 'put', // Untuk mengupdate data
    id: props.payment.id,
    room_tenant_id: props.payment.room_tenant.payee_id,
    amount: props.payment.amount,
    billing_period: props.payment.billing_period,
    payment_date: props.payment.payment_date,
    payment_method: props.payment.payment_method,
    payment_status: props.payment.payment_status,
    penalty_fee: props.payment.penalty_fee,
    payment_photo: null,
})

// Untuk reference input file agar bisa diakses saat upload
function handlePaymentPhotoChange(e) {
    const file = e.target.files[0];
    if (file) {
        previewUrl.value = URL.createObjectURL(file);
        form.payment_photo = file;
    }
}

function submit() {
    form.post(`/dashboard/payments/${form.id}`, {
        forceFormData: true, // Pastikan form data dikirim sebagai FormData
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
    <DashboardLayouts :auth="props.auth">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">Edit Pembayaran</h1>
            <form @submit.prevent="submit" enctype="multipart/form-data" class="max-w-xl mx-auto">
                <div class="mb-5">
                    <label for="room_tenant_id" class="block mb-2 text-sm font-medium text-gray-900">Payee
                        Tenant</label>
                    <input type="text" id="room_tenant_id" v-model="form.room_tenant_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan ID Tenant!" required />
                    <div v-if="form.errors.room_tenant_id">{{ form.errors.room_tenant_id }}</div>
                </div>

                <div class="mb-5">
                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900">Jumlah Bayar</label>
                    <input v-model.number="form.amount" type="number" id="amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan jumlah bayar!" required />
                    <div v-if="form.errors.amount">{{ form.errors.amount }}</div>
                </div>

                <div class="mb-5">
                    <label for="billing_period" class="block mb-2 text-sm font-medium text-gray-900">Periode
                        Tagihan</label>
                    <input v-model="form.billing_period" type="text" id="billing_period"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan periode tagihan!" required />
                    <div v-if="form.errors.billing_period">{{ form.errors.billing_period }}</div>
                </div>

                <div class="mb-5">
                    <label for="payment_date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                        Pembayaran</label>
                    <input v-model="form.payment_date" type="date" id="payment_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 " />
                    <div v-if="form.errors.payment_date">{{ form.errors.payment_date }}</div>
                </div>
                <div class="mb-5">
                    <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900">Metode
                        Pembayaran</label>
                    <input v-model="form.payment_method" type="text" id="payment_method"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan metode pembayaran!" required />
                    <div v-if="form.errors.payment_method">{{ form.errors.payment_method }}</div>
                </div>
                <div class="mb-5">
                    <label for="payment_status" class="block mb-2 text-sm font-medium text-gray-900">Status
                        Pembayaran</label>
                    <select v-model="form.payment_status" id="payment_status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 ">
                        <option value="unpaid">Unpaid</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="failed">Failed</option>
                    </select>
                    <div v-if="form.errors.payment_status">{{ form.errors.payment_status }}</div>
                </div>
                <div class="mb-5">
                    <label for="penalty_fee" class="block mb-2 text-sm font-medium text-gray-900">Denda (Jika
                        Ada)</label>
                    <input v-model.number="form.penalty_fee" type="number" id="penalty_fee"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 "
                        placeholder="Masukkan jumlah denda jika ada" />
                    <div v-if="form.errors.penalty_fee">{{ form.errors.penalty_fee }}</div>
                </div>
                <div class="mb-5">
                    <label for="payment_photo" class="block mb-2 text-sm font-medium text-gray-900">Foto
                        Pembayaran</label>
                    <input type="file" id="payment_photo" @change="handlePaymentPhotoChange"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-blue-500 focus:outline-1 block w-full p-2.5 " />
                    <div v-if="form.errors.payment_photo">{{ form.errors.payment_photo }}</div>
                </div>
                <button type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </DashboardLayouts>

</template>