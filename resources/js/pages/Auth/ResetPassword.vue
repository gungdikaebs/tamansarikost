<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
        <form class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md flex flex-col gap-5" @submit.prevent="submit">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">🔒 Reset Password</h2>
            <div class="flex flex-col gap-1">
                <label for="email" class="text-gray-600 text-sm">Email</label>
                <input v-model="form.email" id="email" type="email" placeholder="Enter your email" required
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                <span class="text-red-500 text-xs mt-1" v-if="form.errors.email">{{ form.errors.email }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="text-gray-600 text-sm">New Password</label>
                <input v-model="form.password" id="password" type="password" placeholder="New password" required
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                <span class="text-red-500 text-xs mt-1" v-if="form.errors.password">{{ form.errors.password }}</span>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password_confirmation" class="text-gray-600 text-sm">Confirm Password</label>
                <input v-model="form.password_confirmation" id="password_confirmation" type="password"
                    placeholder="Confirm password" required
                    class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
            </div>
            <input type="hidden" v-model="form.token" />
            <button type="submit" :disabled="form.processing"
                class="bg-blue-600 text-white py-3 rounded-lg font-semibold text-base transition hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
                {{ form.processing ? 'Resetting...' : 'Reset Password' }}
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
const page = usePage()
const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
    token: page.props.token
})

function submit() {
    form.post('/reset-password')
}
</script>
