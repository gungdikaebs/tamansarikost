<script setup>
import { defineProps, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Breadcrumb from '../../components/dashboard/Breadcrumb.vue';

const props = defineProps({
    roomTenant: Object,
    breadcrumbs: Array
});

const form = useForm({
    room_tenant_id: props.roomTenant.id,
    amount: props.roomTenant.room.price,
    payment_date: new Date().toISOString().split('T')[0],
    payment_status: 'pending',
    payment_method: '',
    payment_photo: null,
    penalty_fee: 0
});

const paymentPreview = ref(null);

function handleFileUpload(event) {
    const file = event.target.files[0];
    form.payment_photo = file;
    if (file) {
        paymentPreview.value = URL.createObjectURL(file);
    } else {
        paymentPreview.value = null;
    }
}

function submit() {
    form.post('/dashboard/register-payment', {
        onSuccess: () => {
            form.reset();
            paymentPreview.value = null;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}
</script>

<template>
    <div
        class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen flex items-center justify-center ">
        <div class="shadow-2xl py-10 rounded-2xl bg-white max-w-xl w-full p-10 mt-10 border border-blue-200 relative">
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                <div class="bg-blue-600 rounded-full p-4 shadow-lg">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <Breadcrumb :breadcrumbs="breadcrumbs" />
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-8 mt-14">
                <h2 class="text-3xl font-extrabold text-blue-700 mb-2 text-center tracking-tight">Register Pembayaran
                </h2>
                <p class="text-gray-600 text-center mb-6">Lengkapi data berikut untuk mendaftarkan pembayaran penghuni.
                </p>
                <!-- Invoice Section -->
                <div class="bg-gray-50 rounded-xl p-5 mb-6 shadow">
                    <h3 class="text-lg font-bold text-blue-700 mb-4">Invoice</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700 font-semibold">Harga</span>
                        <span class="text-gray-900 font-bold">Rp {{ Number(form.amount).toLocaleString() }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700 font-semibold">Denda</span>
                        <span class="text-gray-900 font-bold">Rp {{ Number(form.penalty_fee).toLocaleString() }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between items-center">
                        <span class="text-blue-700 font-bold">Total</span>
                        <span class="text-blue-700 font-extrabold text-xl">
                            Rp {{ (Number(form.amount) + Number(form.penalty_fee)).toLocaleString() }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700" for="payment_date">Tanggal Pembayaran</label>
                    <input id="payment_date" type="date" v-model="form.payment_date"
                        :class="['border p-3 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition', form.errors.payment_date ? 'border-red-600' : 'border-gray-300']" />
                    <div v-if="form.errors.payment_date" class="text-red-600 mt-1 text-sm">{{ form.errors.payment_date
                        }}</div>
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
                    <label class="block mb-2 font-semibold text-gray-700" for="payment_photo">Bukti Pembayaran</label>
                    <input id="payment_photo" name="payment_photo" type="file" @change="handleFileUpload"
                        accept="image/*"
                        :class="['border p-3 rounded-xl w-full focus:outline-none focus:ring-2 focus:ring-blue-400 transition', form.errors.payment_photo ? 'border-red-600' : 'border-gray-300']" />
                    <div v-if="form.errors.payment_photo" class="text-red-600 mt-1 text-sm">{{ form.errors.payment_photo
                        }}</div>
                    <div v-if="paymentPreview" class="mt-3 flex justify-center">
                        <img :src="paymentPreview" alt="Preview Bukti Pembayaran"
                            class="h-36 rounded-xl shadow-lg border border-blue-200" />
                    </div>
                </div>

                <button :disabled="form.processing" type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-xl font-bold hover:from-blue-600 hover:to-blue-800 transition disabled:opacity-50 flex items-center justify-center shadow-lg">
                    <svg v-if="form.processing" class="animate-spin h-5 w-5 mr-2 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    {{ form.processing ? 'Submitting...' : 'Submit' }}
                </button>
            </form>
        </div>
    </div>
</template>
