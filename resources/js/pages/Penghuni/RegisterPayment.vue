<script setup>
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Breadcrumb from '../../components/dashboard/Breadcrumb.vue';

const props = defineProps({
    roomTenant: Object,
    breadcrumbs: Array
})

console.log(props.roomTenant.room.price);
console.log(props.roomTenant);

const form = useForm({
    room_tenant_id: props.roomTenant.id,
    amount: props.roomTenant.room.price,
    payment_date: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
    payment_status: 'pending',
    payment_method: '',
    payment_photo: null,
    penalty_fee: 0

});

function handleFileUpload(event) {
    form.payment_photo = event.target.files[0];
}

function submit() {
    form.post('/dashboard/register-payment', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}
</script>

<template>
    <div class="max-w-screen-lg min-h-screen m-auto">
        <div class="p-6 mt-10">
            <Breadcrumb :breadcrumbs="breadcrumbs" />
            <form enctype="multipart/form-data" class="max-w-xl mx-auto my-10" @submit.prevent="submit">
                <h2>Register Pembayaran</h2>
                <div class="mb-4">
                    <input type="text" v-model="form.room_tenant_id" class="w-full p-2 border rounded"
                        placeholder="ID Penghuni" />
                </div>
                <div class="mb-4">
                    <input type="number" v-model="form.amount" class="w-full p-2 border rounded" placeholder="Amount" />
                </div>
                <div class="mb-4">
                    <input type="date" v-model="form.payment_date" class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <select v-model="form.payment_method" class="w-full p-2 border rounded">
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Tunai</option>
                    </select>
                </div>
                <div class="mb-4">
                    <input type="file" @change="handleFileUpload" class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <input type="number" v-model="form.penalty_fee" class="w-full p-2 border rounded"
                        placeholder="Denda (jika ada)" />
                </div>
                <div class="mb-4">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>