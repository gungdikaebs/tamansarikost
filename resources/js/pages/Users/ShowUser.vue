<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
console.log(page.props.user);
</script>

<template>
    <div>
        test
    </div>
</template>