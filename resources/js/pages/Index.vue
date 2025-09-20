<script setup>
import { onMounted } from 'vue';
import Navbar from '../components/landing-page/Navbar.vue'
import Hero from '../components/landing-page/Hero.vue';
import Facilities from '../components/landing-page/Facilities.vue';
import FAQ from '../components/landing-page/FAQ.vue';
import Testimoni from '../components/landing-page/Testimoni.vue';
import ContactUs from '../components/landing-page/ContactUs.vue';
import Footer from '../components/landing-page/Footer.vue';
import Aos from 'aos';
import 'aos/dist/aos.css';

onMounted(() => {
    Aos.init();
});
</script>

<template>

    <Head>
        <title>Taman Sari Kost</title>
    </Head>
    <div class="bg-[#EBF0FF] smooth-scroll transition-all duration-300 ease-in-out">
        <Navbar />
        <div data-aos="fade-up">
            <Hero class="fade-in" />
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
            <Facilities />
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
            <FAQ />
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
            <Testimoni />
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
            <ContactUs />
        </div>
        <Footer />
    </div>
</template>