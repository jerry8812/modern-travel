<template>
  <div v-for="tourGuide in tourGuides" :key="tourGuide.id">
    <TwoMonthsCalendarView :tour-guide="tourGuide" />
  </div>
</template>

<script setup>
import axios from 'axios'

import { ref, onMounted } from 'vue'
import TwoMonthsCalendarView from '@/Components/Common/TwoMonthsCalendarView.vue'

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
