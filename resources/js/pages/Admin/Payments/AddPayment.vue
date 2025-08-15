<script setup>
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import Swal from 'sweetalert2'

const props = defineProps({
    auth: Object,
    roomTenants: Array,
    errors: Object
})

// Form state dengan InertiaJS useForm
const form = useForm({
    room_tenant_id: '',
    amount: 0,
    billing_period: '',
    payment_date: null,
    payment_method: null, // default value
    payment_status: null, // default value
    penalty_fee: 0,
    payment_photo: null,
})

// Untuk reference input file agar bisa diakses saat upload
const fileInput = ref(null)

// Computed property untuk harga kamar otomatis berdasarkan tenant yang dipilih
const selectedRoomPrice = computed(() => {
    if (!form.room_tenant_id) return 0
    const selected = props.roomTenants.find(rt => rt.id === form.room_tenant_id)
    return selected ? selected.room.price : 0
})

// Watch perubahan tenant agar otomatis update jumlah bayar sesuai harga kamar
watch(() => form.room_tenant_id, (newVal) => {
    const selected = props.roomTenants.find(rt => rt.id === newVal)
    if (selected) {
        form.amount = selected.room.price
    } else {
        form.amount = 0
    }
})
function submit() {
    // Ambil file dari input manual dan masukkan ke form data sebelum kirim
    if (fileInput.value && fileInput.value.files.length > 0) {
        form.payment_photo = fileInput.value.files[0]
    }
    form.post('/dashboard/payments', {
        onError: () => {
            console.log('validation errors:', props.errors)
        }
    })
}
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6 mx-auto bg-white rounded-lg">
            <h1 class="text-2xl font-bold mb-4 text-center">Tambah Pembayaran Baru</h1>
            <form @submit.prevent="submit" class="space-y-4 max-w-lg mx-auto" enctype="multipart/form-data">
                <!-- Dropdown Select Room Tenant -->
                <div class="mb-5">
                    <label for="room_tenant_id" class="block mb-2 text-sm font-medium text-gray-900 ">Pilih Penghuni
                        (Tenant)</label>
                    <select v-model="form.room_tenant_id" id="room_tenant_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option value="" disabled>Pilih Tenant</option>
                        <option v-for="rt in props.roomTenants" :key="rt.id" :value="rt.id">
                            {{ rt.payee.fullname }} - {{ rt.room.room_number }}
                        </option>
                    </select>
                    <p v-if="props.errors.room_tenant_id" class="text-red-600 text-sm mt-1">
                        {{ props.errors.room_tenant_id }}</p>
                </div>

                <!-- Input Jumlah Pembayaran (auto terisi, bisa diedit) -->
                <div class="mb-5">
                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Pembayaran</label>
                    <input v-model="form.amount" id="amount" type="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    <p v-if="props.errors.amount" class="text-red-600 text-sm mt-1">{{ props.errors.amount }}</p>
                </div>

                <!-- Input Tanggal Pembayaran -->
                <div class="mb-5">
                    <label for="payment_date" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal
                        Pembayaran</label>
                    <input v-model="form.payment_date" id="payment_date" type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    <p v-if="props.errors.payment_date" class="text-red-600 text-sm mt-1">{{ props.errors.payment_date
                    }}</p>
                </div>

                <!-- Input Jatuh Tempo Pembayaran -->
                <div class="mb-5">
                    <label for="billing_period" class="block mb-2 text-sm font-medium text-gray-900 ">Jatuh Tempo
                        Pembayaran</label>
                    <input v-model="form.billing_period" id="billing_period" type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    <p v-if="props.errors.billing_period" class="text-red-600 text-sm mt-1">{{
                        props.errors.billing_period }}</p>
                </div>

                <!-- payment method -->
                <div class="mb-5">
                    <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900 ">Metode
                        Pembayaran</label>
                    <select v-model="form.payment_method" id="payment_method"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                    <p v-if="props.errors.payment_method" class="text-red-600 text-sm mt-1">{{
                        props.errors.payment_method }}</p>
                </div>

                <!-- Select Status Pembayaran -->
                <div class="mb-5">
                    <label for="payment_status" class="block mb-2 text-sm font-medium text-gray-900 ">Status
                        Pembayaran</label>
                    <select v-model="form.payment_status" id="payment_status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option value="unpaid">Unpaid</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="failed">Failed</option>
                    </select>
                    <p v-if="props.errors.payment_status" class="text-red-600 text-sm mt-1">{{
                        props.errors.payment_status }}</p>
                </div>

                <!-- Input Penalty Fee -->
                <div class="mb-5">
                    <label for="penalty_fee" class="block mb-2 text-sm font-medium text-gray-900 ">Penalty Fee
                        (Denda)</label>
                    <input v-model="form.penalty_fee" id="penalty_fee" type="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    <p v-if="props.errors.penalty_fee" class="text-red-600 text-sm mt-1">{{ props.errors.penalty_fee }}
                    </p>
                </div>

                <!-- Payment Photo (input file) -->
                <div class="mb-5">
                    <label for="payment_photo" class="block mb-2 text-sm font-medium text-gray-900 ">Foto
                        Pembayaran</label>
                    <input ref="fileInput" type="file" id="payment_photo" accept="image/*"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                    <p class="text-gray-500 text-sm mt-1 ml-1">Opsional, upload bukti pembayaran jika ada.</p>
                </div>

                <!-- Submit button -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white rounded py-2 px-4 hover:bg-blue-700">
                        Tambah Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayouts>
</template>
