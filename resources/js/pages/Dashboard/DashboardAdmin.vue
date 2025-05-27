<script setup>
import BigCard from '../../components/dashboard/BigCard.vue';
import DashboardLayouts from '../../components/layouts/DashboardLayouts.vue';
import SmallCard from '../../components/dashboard/SmallCard.vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
});

console.log(props.auth.user);
</script>
<template>
    <div>
        <DashboardLayouts :auth="props.auth">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <SmallCard />
                <SmallCard />
                <SmallCard />
                <SmallCard />
            </div>
            <BigCard />
        </DashboardLayouts>
    </div>
</template>