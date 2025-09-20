<template>
    <nav class="navbar-main">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="/dashboard" class="logo-link">
                <div class="logo-container">
                    <span class="logo-text">TamanSariKost.</span>
                </div>
            </a>

            <!-- Hamburger Button / X Button -->
            <button @click="toggleMenu" type="button" :class="['hamburger-btn', isOpen ? 'hamburger-active' : '']"
                aria-label="Toggle menu">
                <span class="sr-only">Open main menu</span>
                <div class="hamburger-icon" v-if="!isOpen">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </div>
                <div v-else class="hamburger-x-icon">
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Mobile Menu Overlay -->
            <div v-if="isOpen" class="mobile-overlay"></div>

            <!-- Navigation Links -->
            <div :class="[
                'mobile-menu',
                isOpen ? 'mobile-menu-open' : 'mobile-menu-closed'
            ]" id="navbar-default" ref="menuRef">
                <ul class="nav-list">
                    <li v-for="(item, index) in menuItems" :key="index"
                        :style="{ animationDelay: isOpen ? `${index * 0.1}s` : '0s' }"
                        :class="['nav-item', isOpen ? 'nav-item-show' : '']">
                        <a :href="item.href" @click="closeMenu"
                            :class="['nav-link', item.isButton ? 'nav-button' : 'nav-regular']">
                            <i v-if="item.icon" :class="[item.icon, 'nav-icon']"></i>
                            <span>{{ item.label }}</span>
                            <div v-if="!item.isButton" class=""></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const isOpen = ref(false)
const menuRef = ref(null)

const menuItems = [
    { label: 'Home', href: '#', icon: 'bx bx-home' },
    { label: 'Facilities', href: '#facilities', icon: 'bx bx-building' },
    { label: 'FAQ', href: '#faq', icon: 'bx bx-help-circle' },
    { label: 'Testimoni', href: '#testimoni', icon: 'bx bx-star' },
    { label: 'Contact us', href: '#contact-us', icon: 'bx bx-phone' },
    { label: 'Sign Up', href: '/register', icon: 'bx bx-user-plus', isButton: true }
]

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}

const closeMenu = () => {
    isOpen.value = false
    document.body.style.overflow = 'auto'
}

const handleKeydown = (e) => {
    if (e.key === 'Escape' && isOpen.value) closeMenu()
}

// Detect click outside for closing menu
const handleClickOutside = (e) => {
    if (!isOpen.value) return
    // Don't close if click is inside menu content or on hamburger
    if (
        menuRef.value &&
        !menuRef.value.contains(e.target) &&
        !e.target.closest('.hamburger-btn')
    ) {
        closeMenu()
    }
}

onMounted(() => {
    document.addEventListener('keydown', handleKeydown)
    document.addEventListener('mousedown', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.removeEventListener('mousedown', handleClickOutside)
    document.body.style.overflow = 'auto'
})
</script>

<style scoped>
/* Navbar Main */
.navbar-main {
    background: linear-gradient(to right, #EBF0FF 0%, #F0F4FF 50%, #EBF0FF 100%);
    border-bottom: 1px solid #e5e7eb;
    padding: 12px 0;
    position: sticky;
    top: 0;
    z-index: 50;
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
    backdrop-filter: blur(16px);
    background-color: rgba(235, 240, 255, 0.95);
}

.navbar-container {
    max-width: 1280px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    margin: 0 auto;
    padding: 0 24px;
}

/* Logo Styles */
.logo-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}

.logo-container {
    position: relative;
}

.logo-text {
    align-self: center;
    font-size: 1.5rem;
    font-weight: 700;
    white-space: nowrap;
    background: linear-gradient(135deg, #152B6B 0%, #2E5DE8 50%, #152B6B 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 3s ease-in-out infinite;
    transition: all 0.3s ease;
}

.logo-container:hover .logo-text {
    transform: scale(1.05);
    filter: drop-shadow(0 0 8px rgba(46, 93, 232, 0.3));
}

@keyframes gradientShift {

    0%,
    100% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }
}

/* Hamburger Button */
.hamburger-btn {
    z-index: 60;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    width: 48px;
    height: 48px;
    font-size: 14px;
    border-radius: 12px;
    transition: all 0.3s ease-in-out;
    transform: scale(1);
    outline: none;
    border: none;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
}

.hamburger-btn:hover {
    background: rgba(59, 130, 246, 0.1);
    transform: scale(1.05);
}

.hamburger-btn:focus {
    outline: 2px solid rgba(59, 130, 246, 0.5);
    outline-offset: 2px;
}

.hamburger-active {
    background: rgba(59, 130, 246, 0.1);
}

/* Hide on desktop */
@media (min-width: 768px) {
    .hamburger-btn {
        display: none;
    }
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.hamburger-icon {
    width: 24px;
    height: 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
}

.hamburger-line {
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #152B6B, #2E5DE8);
    border-radius: 2px;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    transform-origin: center;
}

.hamburger-x-icon {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 24px;
    height: 24px;
    position: relative;
    z-index: 60;
}

.hamburger-x-icon span {
    position: absolute;
    width: 24px;
    height: 3px;
    background: linear-gradient(90deg, #152B6B, #2E5DE8);
    border-radius: 2px;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.hamburger-x-icon span:first-child {
    transform: rotate(45deg);
}

.hamburger-x-icon span:last-child {
    transform: rotate(-45deg);
}

/* Mobile Overlay */
.mobile-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(8px);
    z-index: 40;
    animation: fadeIn 0.3s ease-out;
}

@media (min-width: 768px) {
    .mobile-overlay {
        display: none;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Mobile Menu */
.mobile-menu {
    width: 100%;
}

.mobile-menu-closed {
    display: none;
}

.mobile-menu-open {
    display: block;
    position: fixed;
    top: 0;
    right: 0;
    width: 85%;
    max-width: 400px;
    height: 100vh;
    background: linear-gradient(135deg, rgba(235, 240, 255, 0.98) 0%, rgba(240, 244, 255, 0.95) 50%, rgba(235, 240, 255, 0.98) 100%);
    backdrop-filter: blur(20px);
    border-left: 1px solid rgba(46, 93, 232, 0.2);
    box-shadow: -10px 0 50px rgba(46, 93, 232, 0.1);
    z-index: 50;
    animation: slideInRight 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    overflow-y: auto;
}

/* Desktop Menu */
@media (min-width: 768px) {
    .mobile-menu {
        display: block !important;
        position: static;
        width: auto;
        height: auto;
        background: transparent;
        backdrop-filter: none;
        border: none;
        box-shadow: none;
        animation: none;
        overflow: visible;
    }

    .mobile-menu-closed {
        display: block;
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Navigation List */
.nav-list {
    font-weight: 500;
    display: flex;
    flex-direction: column;
    padding: 24px;
    margin-top: 64px;
    gap: 8px;
}

@media (min-width: 768px) {
    .nav-list {
        flex-direction: row;
        gap: 32px;
        margin-top: 0;
        padding: 0;
        background: transparent;
    }
}

/* Navigation Items */
.nav-item {
    opacity: 0;
    transform: translateX(30px);
    transition: all 0.3s ease;
}

.nav-item-show {
    opacity: 1;
    transform: translateX(0);
    animation: slideInLeft 0.5s ease forwards;
}

@media (min-width: 768px) {
    .nav-item {
        opacity: 1;
        transform: translateX(0);
    }

    .nav-item-show {
        animation: none;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Navigation Links */
.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    transition: all 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

@media (min-width: 768px) {
    .nav-link {
        padding: 8px 12px;
        gap: 8px;
    }
}

.nav-regular {
    color: #1f2937;
}

.nav-regular:hover {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
}

@media (min-width: 768px) {
    .nav-regular:hover {
        background: transparent;
        border: 0;
    }
}

.nav-regular:hover .nav-icon {
    transform: scale(1.1);
    color: #2563eb;
}

.nav-button {
    color: white;
    font-weight: 600;
    background-color: #0A1B59;
    box-shadow: 0 4px 14px 0 rgba(46, 93, 232, 0.3);
}

.nav-button:hover {
    background: linear-gradient(135deg, #2E5DE8 0%, #152B6B 100%);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px 0 rgba(46, 93, 232, 0.4);
}

@media (min-width: 768px) {
    .nav-button {
        border-radius: 9999px;
        padding: 8px 24px;
    }
}

/* Icons */
.nav-icon {
    font-size: 1.25rem;
    transition: all 0.3s ease;
}

@media (min-width: 768px) {
    .nav-icon {
        display: none;
    }
}


.nav-regular:hover .nav-underline {
    width: 100%;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}
</style>