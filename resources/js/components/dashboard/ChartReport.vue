<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-7">

        <!-- Line Chart -->
        <div class="bg-white rounded-xl p-5 shadow">
            <h2 class="font-bold mb-3 text-blue-700">Trend Income & Outcome 12 Bulan</h2>
            <canvas ref="lineRef" height="300" width="500"></canvas>
        </div>
        <!-- Pie Chart -->
        <div class="bg-white rounded-xl p-5 shadow ">
            <h2 class="font-bold mb-3 text-blue-700">Perbandingan Income & Outcome (Bulan Ini)</h2>
            <canvas ref="pieRef" height="300" width="300"></canvas>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { LineController, Chart, PieController, ArcElement, Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement } from 'chart.js'

Chart.register(LineController, LineElement, PointElement, CategoryScale, LinearScale, Tooltip, Legend, PieController, ArcElement);


const props = defineProps({
    chart: {
        type: Object,
        required: true,
        default: () => ({
            pie: { income: 0, outcome: 0 },
            trend: [],
        }),
    },
})

const pieRef = ref(null)
const lineRef = ref(null)
let pieChart = null
let lineChart = null


const renderPie = () => {
    if (pieChart) pieChart.destroy()
    pieChart = new Chart(pieRef.value, {
        type: 'pie',
        data: {
            labels: ['Income', 'Outcome'],
            datasets: [{
                data: [props.chart.pie.income, props.chart.pie.outcome],
                backgroundColor: ['#1D4ED8', '#EF4444'],
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: Rp ${ctx.parsed.toLocaleString('id-ID')}`
                    }
                }
            }
        }
    })
}

const renderLine = () => {
    if (lineChart) lineChart.destroy()
    lineChart = new Chart(lineRef.value, {
        type: 'line',
        data: {
            labels: props.chart.trend.map(t => t.label),
            datasets: [
                {
                    label: 'Income',
                    data: props.chart.trend.map(t => t.income),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16,185,129,0.15)',
                    fill: false,
                    tension: 0.4
                },
                {
                    label: 'Outcome',
                    data: props.chart.trend.map(t => t.outcome),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239,68,68,0.10)',
                    fill: false,
                    tension: 0.4
                }
            ]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: Rp ${ctx.parsed.y.toLocaleString('id-ID')}`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    })
}

onMounted(() => {
    renderPie()
    renderLine()
})

// Re-render chart if props.chart changes (for reactive data)
watch(() => props.chart, () => {
    renderPie()
    renderLine()
}, { deep: true })
</script>

<style scoped>
canvas {
    max-width: 100% !important;
    height: auto !important;
    display: block;
    margin: 0 auto;
}
</style>