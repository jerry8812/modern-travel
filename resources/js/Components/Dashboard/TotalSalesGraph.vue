<template>
    <div>
        <div class="flex items-end justify-between w-2/3 mb-4">
            <GraphTimePicker :update-value-callback="refetchData" />
            <div><span class="font-semibold">Total Sales:</span> <span class="text-lg">{{ formatNZCurrency(totalSales) }}</span></div>
        </div>
            <Pie id="replacement-chart" :data="chartData" :options="chartOptions" class="mt-14"/>
    </div>
</template>

<script setup>
import GraphTimePicker from './GraphTimePicker.vue'

import { Chart, registerables } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { ref } from 'vue'

import { formatNZCurrency } from '@/Helpers/helper.js'

Chart.register(...registerables)

const chartData = ref({
    labels: [],
    datasets: []
})

const totalSales = ref(null)

const chartOptions = {
    responsive: true,
    aspectRatio: 1|2,
    plugins: {
        legend: {
            display: true,
            position: 'left'
        }
    }
}

const refetchData = (startDate, endDate) => {
    axios.get(route('api.dashboard.get-sales-graph-data'), {
        params: { startDate, endDate }
    })
        .then(res => {
            chartData.value = {
                labels: res.data.labels,
                datasets: [{ data: res.data.datasets }]
            }

            totalSales.value = res.data.totalSales
        })
}
</script>
