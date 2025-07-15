<script setup>
import { ref } from 'vue'

const username = ref('')
const pesan = ref('')

const sendMessageToWhatsapp = () => {
    const phoneNumber = '6281237397984' // Ganti dengan nomor WhatsApp tujuan
    const message = `Username: ${username.value}\nPesan: ${pesan.value}`
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`
    window.open(url, '_blank')
    username.value = ''
    pesan.value = ''

}
</script>

<template>
    <div class="bg-[#EBF0FF] py-12 pb-20" id="contact-us">
        <div class="max-w-screen-xl mx-auto px-6">
            <div class="flex items-center justify-center pb-2">
                <h3 class="text-4xl font-bold text-[#152B6B]">
                    Contact Us
                </h3>

            </div>
            <div class="flex flex-col justify-between mt-10 gap-10 lg:flex-row">
                <div class="flex-1">
                    <div class="flex flex-col gap-2">
                        <div>
                            <h3 class="text-2xl font-bold text-[#414141]">Contact Information</h3>
                            <p class="text-[#787878] mt-3">
                                Jika ada pertanyaan atau ingin melakukan reservasi, silahkan hubungi kami melalui
                                kontak dibawah ini.
                            </p>
                        </div>
                        <div>
                            <div class="flex flex-row items-start gap-2 mt-8 ">
                                <a href="https://maps.app.goo.gl/9C6DEwp5xeVRB7GW7" target="_blank">
                                    <i
                                        class='bx bx-map text-2xl text-[#787878] bg-white p-3 rounded-xl hover:bg-[#0A1B59] hover:text-white transition-all duration-500'></i>
                                </a>
                                <div class="flex flex-col">
                                    <p class="font-bold text-[#414141]">Address</p>
                                    <p class="text-[#787878]">Jl. Glogor Carik Gg. Ratna Sari II No.6, Pemogan, Denpasar
                                        Selatan, Kota Denpasar, Bali 80221</p>
                                </div>
                            </div>
                            <div class="flex flex-row items-start gap-2 mt-8 ">
                                <a href="https://wa.me/6281237397984" target="_blank">
                                    <i
                                        class='bx bx-phone text-2xl text-[#787878] bg-white p-3 rounded-xl hover:bg-[#0A1B59] hover:text-white transition-all duration-500'></i>
                                </a>
                                <div class="flex flex-col">
                                    <p class="font-bold text-[#414141]">Phone</p>
                                    <p class="text-[#787878]">+62 812 3739 7984</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class=" flex flex-col gap-6 w-full rounded-xl p-8 bg-white  shadow-lg border-black/30">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold text-[#414141] ">Send Us Message</h3>
                            <p class="text-[#414141]/90">Silahkan tinggalkan pesan jika ingin bertanya, jika pertanyaan
                                anda belum menemukan
                                jawaban
                                pada halaman FAQ</p>
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <div class="flex flex-col gap-1">
                                <label for="username" class="font-semibold">Username</label>
                                <input type="text" name="username" id="username" v-model="username"
                                    placeholder="Enter Your Username"
                                    class="border-1 px-5 py-1 rounded border-black/30 focus:outline-black/40">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label for="username" class="font-semibold">Pesan</label>
                                <input type="text" name="Pesan" id="Pesan" v-model="pesan"
                                    placeholder="Enter Your Message"
                                    class="border-1 px-5 py-1 rounded border-black/30 focus:outline-black/40">
                            </div>
                        </div>
                        <div class="flex  justify-center m-2">
                            <button @click="sendMessageToWhatsapp"
                                class="border-1 w-[50%] py-2 md:py-3 bg-[#0A1B59] text-white hover:bg-[#2E5DE8] hover:text-blue-100 text-center rounded-lg duration-500">
                                Kirim Pesan <i class='bx bx-send mx-1'></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>