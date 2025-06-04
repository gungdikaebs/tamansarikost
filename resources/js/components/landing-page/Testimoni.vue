<!-- ADD MODAL IN TESTIMONI -->
<!-- CONNECT THE REVIEW IN DATABASE -->

<script setup>
const testimonials = [
    {
        name: 'Bruce Hardy',
        tinggal: '2 Bulan',
        image: 'https://randomuser.me/api/portraits/women/68.jpg',
        text: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugiat mollitia illo, odio dolore eveniet eaque ullam, vitae, repellat aliquam nihil labore voluptatum esse adipisci perferendis? Sunt beatae ipsam dicta harum, distinctio modi quaerat,',
        rating: 5,
    },
    {
        name: 'Mark Smith',
        tinggal: '1 Tahun',
        image: 'https://randomuser.me/api/portraits/men/75.jpg',
        text: 'When, while lovely valley teems with vapour around meand meridian sun strikes the upper impenetrable.',
        rating: 4,
    },
    {
        name: 'Mark Smith',
        tinggal: '3 Bulan',
        image: 'https://randomuser.me/api/portraits/women/65.jpg',
        text: 'When, while lovely valley teems with vapour around meand meridian sun strikes the upper impenetrable.',
        rating: 4,
    },
    {
        name: 'Vera Duncan',
        tinggal: '4 bulan',
        image: 'https://randomuser.me/api/portraits/men/47.jpg',
        text: 'When, while lovely valley teems with vapour around meand meridian sun strikes the upper impenetrable.',
        rating: 5,
    },
]
</script>

<template>

    <div class="bg-white py-12 pb-20" id='testimoni'>
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:items-center">
            <div class="mb-20 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0A1B59]">What People <span
                        class="text-[#FFC74F]">Thinks?</span></h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-14 md:gap-5 ">
                <div v-for="(testimonial, index) in testimonials" :key="index"
                    class="bg-white rounded-xl shadow-blue-200 shadow-md p-6 text-center hover:scale-105 duration-300">
                    <div class="flex justify-center -mt-16 mb-4">
                        <img :src="testimonial.image"
                            class="w-24 h-24 object-cover rounded-full border-4 border-white shadow-blue-600 shadow-md"
                            alt="avatar" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ testimonial.name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ testimonial.tinggal }}</p>
                    <p class="text-sm text-gray-600 mb-4">{{ testimonial.text }}</p>
                    <div class="flex justify-center space-x-1">
                        <span v-for="n in 5" :key="n" class="text-xl"
                            :class="n <= testimonial.rating ? 'text-pink-500' : 'text-gray-300'">
                            ★
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>