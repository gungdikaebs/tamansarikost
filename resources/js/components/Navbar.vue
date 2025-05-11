<template>
    <nav class="bg-[#EBF0FF] border-gray-200 py-2">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-[#152B6B] ">TamanSariKost.</span>
            </a>

            <!-- Toggle Button -->
            <button @click="isOpen = !isOpen" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- Navigation Links -->
            <div :class="[isOpen ? 'block' : 'hidden', 'w-full md:block md:w-auto']" id="navbar-default">
                <ul class="font-medium items-center flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50
                      md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-[#EBF0FF]">
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Facilities</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">FAQ</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-[#A1B9FF] transition-all duration-300 ease-in-out md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Testimoni</a>
                    </li>
                    <li>
                        <a href="#"
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
