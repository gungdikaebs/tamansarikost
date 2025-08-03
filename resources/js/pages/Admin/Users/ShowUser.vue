<script setup>
import { usePage } from '@inertiajs/vue3';
import DashboardLayouts from '../../../components/layouts/DashboardLayouts.vue';

const page = usePage();
console.log(page.props.user);



</script>

<template>
    <div>
        <DashboardLayouts :auth="page.props.auth">
            <div class="grid md:grid-cols-5 md:grid-rows-3 grid-cols-1  md:gap-3 gap-1">
                <!-- Kolom Profil Pengguna -->
                <div class="md:col-span-2 md:row-span-3 flex items-center bg-gray-50 p-4 rounded-lg gap-5 ">
                    <img :src="page.props.user.profile_picture" alt="Profile picture"
                        class="rounded-full w-20 h-20 object-cover " />
                    <div class="flex flex-col gap-2">
                        <p class="text-xl font-semibold text-gray-700">{{ page.props.user.username }}</p>
                        <a :href="`https://api.whatsapp.com/send/?phone=${page.props.user.phone}`" target="_blank"
                            class="text-blue-500">Chat via WhatsApp</a>
                    </div>
                </div>
                <div class="md:col-span-3 md:row-span-3 col-span-1 flex items-center bg-gray-50 p-4 rounded-lg gap-5 ">
                    <div class="flex flex-col gap-2 mx-4 ">
                        <p class=" text-gray-700">
                            <i class='bx bx-envelope'></i>
                            Email : <a :href="`mailto:${page.props.user.email}`" class="text-blue-900 font-semibold">{{
                                page.props.user.email }}</a>
                        </p>
                        <p class=" text-gray-700">
                            <i class='bx bx-phone'></i>
                            Phone : <a :href="`tel:${page.props.user.phone}`" class="font-semibold text-blue-900">{{
                                page.props.user.phone }}</a>
                        </p>
                        <!-- <p class=" text-gray-700"></p> -->
                    </div>
                </div>
                <div
                    class="md:col-span-3 col-span-1 md:row-span-3 flex items-center justify-center bg-gray-50 p-4 rounded-lg gap-5 ">
                    <div class="flex flex-col gap-2 mx-4 ">
                        <p class="font-semibold text-xl mx-auto mb-3">KTP PHOTO</p>
                        <img :src="page.props.user.tenant.ktp_photo" width="300" alt="Test">
                        <p>{{ page.props.user.tenant.ktp_photo_url }}</p>
                    </div>
                </div>
                <div class="md:col-span-2 col-span-1 md:row-span-3 flex  bg-gray-50 p-4 rounded-lg gap-5 ">
                    <div class="flex flex-col gap-2 mx-4 ">
                        <p class=" text-gray-700">
                            <i class='bx bx-tag-alt'></i>
                            Nama Lengkap : {{ page.props.user.tenant.fullname }}
                        </p>
                        <p class=" text-gray-700">
                            <i class='bx bx-buildings'></i>
                            Kamar : {{ page.props.user.tenant.room_tenants.length > 0 ?
                                page.props.user.tenant.room_tenants[0].room.room_number : 'Tidak ada kamar' }}
                        </p>
                        <!-- loop room Tenant -->

                    </div>
                </div>

            </div>

        </DashboardLayouts>
    </div>
</template>