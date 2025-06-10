<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue'
import { defineProps } from 'vue'

const props = defineProps({
    auth: Object,
    roomTenants: Array,
    errors: Object
})

console.log(props.roomTenants);

// State untuk form input
const form = ref({
    room_tenant_id: '',
    amount: '',
    payment_date: '',
    payment_status: 'pending', // default status
    penalty_fee: 0
})

function submit() {
    Inertia.post('/payments', form.value, {
        onError: () => {
            console.log('validation errors:', props.errors)
        }
    })
}
</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Tambah Pembayaran Baru</h1>
            <form @submit.prevent="submit" class="space-y-4 max-w-lg">
                <!-- Dropdown Select Room Tenant -->
                <div>
                    <label for="room_tenant_id" class="block mb-1 font-medium">Pilih Penghuni (Tenant)</label>
                    <select v-model="form.room_tenant_id" id="room_tenant_id" class="w-full border rounded p-2">
                        <option value="" disabled>Pilih Tenant</option>
                        <option v-for="rt in props.roomTenants" :key="rt.id" :value="rt.id">
                            {{ rt.tenant.fullname }} - {{ rt.room.room_number }}
                        </option>
                    </select>
                    <p v-if="props.errors.room_tenant_id" class="text-red-600 text-sm mt-1">{{
                        props.errors.room_tenant_id }}</p>
                </div>

                <!-- Input Jumlah Pembayaran -->
                <div>
                    <label for="amount" class="block mb-1 font-medium">Jumlah Pembayaran</label>
                    <input v-model="form.amount" id="amount" type="number" class="w-full border rounded p-2" />
                    <p v-if="props.errors.amount" class="text-red-600 text-sm mt-1">{{ props.errors.amount }}</p>
                </div>

                <!-- Input Tanggal Pembayaran -->
                <div>
                    <label for="payment_date" class="block mb-1 font-medium">Tanggal Pembayaran</label>
                    <input v-model="form.payment_date" id="payment_date" type="date"
                        class="w-full border rounded p-2" />
                    <p v-if="props.errors.payment_date" class="text-red-600 text-sm mt-1">{{ props.errors.payment_date
                        }}</p>
                </div>

                <!-- Select Status Pembayaran -->
                <div>
                    <label for="payment_status" class="block mb-1 font-medium">Status Pembayaran</label>
                    <select v-model="form.payment_status" id="payment_status" class="w-full border rounded p-2">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                    </select>
                    <p v-if="props.errors.payment_status" class="text-red-600 text-sm mt-1">{{
                        props.errors.payment_status }}</p>
                </div>

                <!-- Input Penalty Fee -->
                <div>
                    <label for="penalty_fee" class="block mb-1 font-medium">Penalty Fee (Denda)</label>
                    <input v-model="form.penalty_fee" id="penalty_fee" type="number"
                        class="w-full border rounded p-2" />
                    <p v-if="props.errors.penalty_fee" class="text-red-600 text-sm mt-1">{{ props.errors.penalty_fee }}
                    </p>
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
