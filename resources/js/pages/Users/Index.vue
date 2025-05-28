<script setup>
import { defineProps } from 'vue';
// import { router } from '@inertiajs/vue3';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';

const props = defineProps({
    users: {
        type: Object,
        required: true
    },
    auth: {
        type: Object,
        required: true
    },
    flash: {
        type: Object,
        default: () => ({})
    }

});
console.log(props.users[1]);

</script>

<template>
    <DashboardLayouts :auth="props.auth">
        <div class="flex justify-between my-4">
            <h1 class="text-2xl font-bold mb-4">Daftar Users</h1>
            <a href="/dashboard/users/add"
                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                Tambah User
                <svg class="w-3.5 h-3.5 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                    </tr>
                </thead>
                <tbody v-for="user in props.users" :key="user.id">
                    <tr class="odd:bg-white border-b  border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                            {{ user.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ user.email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.phone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ user.role }}
                        </td>
                        <td class="px-6 py-4 flex gap-3 mx-auto">
                            <a :href="'/dashboard/users/' + user.id + '/edit'"
                                class="font-medium text-blue-600 hover:underline">Edit</a>
                            <button class=" text-red-600 hover:underline">Delete</button>

                        </td>

                    </tr>


                </tbody>
            </table>
        </div>
    </DashboardLayouts>


</template>
