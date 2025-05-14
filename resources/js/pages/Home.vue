<script setup>
import Navbar from '../components/landing-page/Navbar.vue'
import Hero from '../components/landing-page/Hero.vue';
import Facilities from '../components/landing-page/Facilities.vue';
import FAQ from '../components/landing-page/FAQ.vue';
import Testimoni from '../components/landing-page/Testimoni.vue';

</script>
<template>
    <div class="bg-[#EBF0FF] smooth-scroll transition-all duration-300 ease-in-out">
        <Navbar />
        <Hero />
        <Facilities />
        <FAQ />
        <Testimoni />
    </div>
</template>