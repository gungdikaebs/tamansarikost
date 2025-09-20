<script setup>
import { ref } from 'vue'

const username = ref('')
const pesan = ref('')

const sendMessageToWhatsapp = () => {
    const phoneNumber = '6281237397984' // Ganti dengan nomor WhatsApp tujuan
    const message = `*Username:* ${username.value} \n *Pesan:* ${pesan.value}`
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
                            <h3 class="text-2xl font-bold text-[#152B6B]">Contact Information</h3>
                            <p class="text-[#787878] mt-3">
                                Jika ada pertanyaan atau ingin melakukan reservasi, silahkan hubungi kami melalui
                                kontak dibawah ini.
                            </p>
                        </div>
                        <div>
                            <a href="https://maps.app.goo.gl/9C6DEwp5xeVRB7GW7" target="_blank">
                                <div class="flex flex-row items-start gap-2 mt-8 ">
                                    <i
                                        class='bx bx-map text-2xl text-[#152B6B] bg-white p-3 rounded-xl hover:bg-[#0A1B59] hover:text-white transition-all duration-500'></i>
                                    <div class="flex flex-col">
                                        <p class="font-bold text-[#152B6B]">Address</p>
                                        <p class="text-[#787878]">Jl. Glogor Carik Gg. Ratna Sari II No.6, Pemogan,
                                            Denpasar
                                            Selatan, Kota Denpasar, Bali 80221</p>
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.9579740651734!2d115.19150311732177!3d-8.695541028488428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd241d16b4f29c1%3A0x56daf61a550cde43!2sTaman%20Sari%20Kost!5e0!3m2!1sid!2sid!4v1747232680170!5m2!1sid!2sid"
                                            width="500" height="200" style="border:0;" allowfullscreen="true"
                                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            class="duration-300 hover:scale-105 rounded-xl my-5 hidden md:block">
                                        </iframe>
                                    </div>
                                </div>
                            </a>
                            <a href="https://wa.me/6281237397984" target="_blank">
                                <div class="flex flex-row items-start gap-2 mt-8 ">

                                    <i
                                        class='bx bx-phone text-2xl text-[#152B6B] bg-white p-3 rounded-xl hover:bg-[#0A1B59] hover:text-white transition-all duration-500'></i>
                                    <div class="flex flex-col">
                                        <p class="font-bold text-[#152B6B]">Phone</p>
                                        <p class="text-[#787878]">+62 812 3739 7984</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="bg-white/60 rounded-2xl shadow-xl p-10 border border-[#dbeafe]">
                        <div class="flex flex-col gap-2 mb-6">
                            <h3 class="text-2xl font-bold text-[#152B6B]">Send Us Message</h3>
                            <p class="text-[#414141]/90">Silahkan tinggalkan pesan jika ingin bertanya, jika pertanyaan
                                anda belum menemukan jawaban pada halaman FAQ.</p>
                        </div>
                        <form @submit.prevent="sendMessageToWhatsapp" class="flex flex-col gap-6">
                            <div class="flex flex-col gap-2">
                                <label for="username" class="font-semibold text-[#152B6B]">Username</label>
                                <input type="text" name="username" id="username" v-model="username"
                                    placeholder="Enter Your Username"
                                    class="border px-5 py-2 rounded-lg border-[#dbeafe] focus:outline-none focus:ring-2 focus:ring-[#2E5DE8] transition"
                                    required>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="Pesan" class="font-semibold text-[#152B6B]">Pesan</label>
                                <textarea name="Pesan" id="Pesan" v-model="pesan" placeholder="Enter Your Message"
                                    rows="4"
                                    class="border px-5 py-2 rounded-lg border-[#dbeafe] focus:outline-none focus:ring-2 focus:ring-[#2E5DE8] transition resize-none"
                                    required></textarea>
                            </div>
                            <div class="flex justify-center mt-4">
                                <button type="submit"
                                    class="w-[60%] py-3 bg-gradient-to-tr from-[#0A1B59] to-[#2E5DE8] text-white font-bold hover:from-[#2E5DE8] hover:to-[#0A1B59] hover:scale-105 transition rounded-lg shadow-lg flex items-center justify-center gap-2">
                                    Kirim Pesan <i class='bx bx-send text-xl'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>