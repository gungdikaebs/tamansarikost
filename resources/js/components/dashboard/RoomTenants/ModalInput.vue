<script setup>
import { defineProps } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    roomId: Number,
    tenants: Array,
});

const form = useForm({
    room_id: props.roomId,
    status: '',
    tenant_id: '',
    payee_id: '',
    start_date: '',
    end_date: '',
});

console.log(props.roomId);
const submit = () => {

    form.post('/dashboard/room-tenants', {
        onSuccess: () => {
            form.reset();
            window.location.reload();
        },
        onError: (errors) => {
            console.error('Error submitting form:', errors);
        },
    });
};


</script>

<template>
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-[400px] space-y-4">
            <h2 class="text-xl font-bold mb-2">Tambah Penghuni</h2>
            <form @submit.prevent="submit" class="space-y-2">
                <!-- Tenant -->
                <select v-model="form.tenant_id" class="w-full border p-2 rounded">
                    <option disabled value="">Pilih Tenant</option>
                    <option v-for="tenant in tenants" :key="tenant.id" :value="tenant.id">
                        {{ tenant.user.username }} - {{ tenant.fullname }}
                    </option>
                </select>

                <!-- Payee -->
                <select v-model="form.payee_id" class="w-full border p-2 rounded">
                    <option disabled value="">Pilih Penanggung Jawab</option>
                    <option v-for="tenant in tenants" :key="tenant.id" :value="tenant.id">
                        {{ tenant.user.username }} - {{ tenant.fullname }}
                    </option>
                </select>

                <select v-model="form.status" class="w-full border p-2 rounded">
                    <option disabled value="">Pilih Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>



                <!-- Start & End Date -->
                <label for="start-date">Start Date</label>
                <input id="start-date" type="date" v-model="form.start_date" class="w-full border p-2 rounded" />

                <label for="end-date">End Date</label>
                <input id="end-date" type="date" v-model="form.end_date" class="w-full border p-2 rounded" />

                <!-- Buttons -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="$emit('close')" class="text-gray-600">Batal</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</template>
