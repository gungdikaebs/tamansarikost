<template>
    <nav
        class="bg-[#EBF0FF] border-gray-200 py-2 sticky top-0 z-50 shadow-blue-300 shadow md:opacity-90 md:backdrop-blur-xl">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-[#152B6B] ">TamanSariKost.</span>
            </a>

            <!-- Toggle Button -->
            <button @click="isOpen = !isOpen" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-blue-100 ">
                <span class="sr-only">Open main menu</span>
                <div class="transition-all duration-1000 ease-in-out text-[#152B6B]">
                    <div v-if="!isOpen">
                        <i class='bx bx-menu-alt-right text-3xl text-[#152B6B]'></i>
                    </div>
                    <div v-else>
                        <i class='bx bx-x text-3xl'></i>
                    </div>
                </div>
            </button>

            <!-- Navigation Links -->
            <div :class="[isOpen ? 'block' : 'hidden', 'w-full md:block md:w-auto']" id="navbar-default">
                <ul class="font-medium items-center flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50
                      md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-[#EBF0FF] scroll-smooth">
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#facilities"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Facilities</a>
                    </li>
                    <li>
                        <a href="#faq"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">FAQ</a>
                    </li>
                    <li>
                        <a href="#testimoni"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Testimoni</a>
                    </li>
                    <li>
                        <a href="#contact-us"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Contact
                            us</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] md:hover:bg-[#2E5DE8] md:border-0 md:hover:text-blue-100 md:px-4 transition-all duration-300 ease-in-out  md:bg-[#0A1B59] md:text-cyan-50 md:rounded-full">Book
                            Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue'

const isOpen = ref(false)
</script>
