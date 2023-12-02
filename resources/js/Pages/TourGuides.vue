<template>
    <Head>
        <title>Tour Guides | Modern Travel</title>
    </Head>
    <PagePanel>
        <div v-for="tourGuide in tourGuides" :key="tourGuide.id">
            <TwoMonthsCalendarView :tour-guide="tourGuide" />
        </div>
    </PagePanel>
</template>

<script setup>
import axios from 'axios'

import { ref, onMounted } from 'vue'
import TwoMonthsCalendarView from '@/Components/Common/TwoMonthsCalendarView.vue'
import PagePanel from '@/Components/Common/PagePanel.vue'
import { Head } from '@inertiajs/vue3';

onMounted(() => {
  getTourGuidesWithSchedulesInCalendarView()
})

const tourGuides = ref([])

// get all tour guides or get a specific tour guide of given id
const getTourGuidesWithSchedulesInCalendarView = async () => {
  await axios.get(route('api.tour-guides.index'))
    .then(res => {
      tourGuides.value = res.data
    })
}
</script>
