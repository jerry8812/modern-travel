<template>
  <Head>
    <title>Trips | Modern Travel</title>
  </Head>
  <PagePanel>
    <div class="relative grid items-center gap-2 mb-8 lg:grid-cols-3 sm:gap-4">
      <TextInput
        theme="primary"
        label="Filter trips"
        type="text"
        placeholder="Keyword"
        @input="keywordHasInput"
      />
      <SelectDropdown
        v-model="filters.client"
        label="Client"
        name="clientOptions"
        :options="clientOptions"
      />
    </div>
    <div class="hidden sm:block">
      <div class="border-b border-gray-200">
        <div class="flex items-end justify-between">
          <nav class="mt-2 -mb-px space-x-8" aria-label="Tabs">
            <a
              v-for="tab in tabs"
              :key="tab.id"
              class="cursor-pointer"
              :class="[filters.currentTab == tab.id
                ? 'border-purple-500 text-purple-600'
                : 'border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700', 'whitespace-nowrap border-b-2 py-0.5 px-1 text-sm font-medium']"
              @click="filters.currentTab = tab.id"
            >
              <span class="capitalize">{{ tab.name }}</span>
            </a>
          </nav>
          <div>
            <button class="btn btn-blue" type="button" @click="router.get(route('create-trip'))">
              <i class="fas fa-plane-departure" /> New Trip
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4">
      <div class="mt-5 overflow-hidden border rounded-xl">
        <table class="w-full text-sm text-left text-gray-500 shadow-md">
          <thead class="text-white uppercase bg-[#34495e] sticky top-0 rounded">
            <tr>
              <th class="py-4 pl-2">
                start
              </th>
              <th class="py-4 pl-2">
                finish
              </th>
              <th class="py-4">
                price
              </th>
              <th class="py-4 pl-2">
                source
              </th>
              <th class="py-4 pl-2">
                tour guide
              </th>
              <th class="py-4 pl-2">
                rental car
              </th>
              <th class="py-4">
                Tourists
              </th>
              <th class="py-4">
                Comments
              </th>
              <th class="py-4" />
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="trip in trips"
              :key="trip.id"
              class="even:bg-gray-100 font-semibold hover:bg-orange-50 border-b border-gray-300 text-[15px]"
              :class="[trip.bgColour]"
            >
              <td class="px-2 py-4 text-left">
                {{ trip.start_date }}
              </td>
              <td class="px-2 py-4 text-left">
                {{ trip.end_date }}
              </td>
              <td class="py-4 text-left">
                {{ formatNZCurrency(trip.total_price) }}
              </td>
              <td class="px-2 py-4">
                {{ trip.source }}
              </td>
              <td class="px-2 py-4">
                {{ trip.tourGuides }}
              </td>
              <td class="py-4 pl-4">
                {{ trip.rentalCars }}
              </td>
              <td class="py-4 text-left">
                {{ trip.amount_of_people }}
              </td>
              <td class="py-4 max-w-[8rem] truncate" :title="trip.comment">
                {{ trip.comment }}
              </td>
              <td class="pl-1">
                <span
                  class="inline-block text-2xl text-green-600 cursor-pointer hover:scale-110"
                  @click="router.get(route('trips.edit', trip.id))"
                ><i class="fas fa-calendar-edit" /></span>
                <span
                  class="inline-block pl-3 text-2xl text-red-600 cursor-pointer hover:scale-110"
                  @click="cancelTrip(trip)"
                >
                  <i class="fas fa-plane-slash" /></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </PagePanel>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import { onMounted, ref, watch } from 'vue'
import axios from 'axios'

import PagePanel from '@/Components/Common/PagePanel.vue'
import { uniq, filter, debounce } from 'lodash'
import { confirmModal } from '@/Helpers/modals.js'
import { formatNZCurrency } from '@/Helpers/helper.js'
import { differenceInDays } from 'date-fns'

import TextInput from '@/Components/Common/Form/TextInput.vue'
import SelectDropdown from '@/Components/Common/Form/SelectDropdown.vue'

const trips = ref([])
const clientOptions = ref([])

const tabs = [
  { id: 'active', name: 'Active' },
  { id: 'not-invoiced', name: 'Not Invoiced' },
  { id: 'completed', name: 'Completed' },
  { id: 'cancelled', name: 'Cancelled' }
]

const filters = ref({
  keyword: '',
  client: '',
  currentTab: 'active'
})

// const rowBGColours = [
//   'rgba(186,255,201,0.3)',
//   'rgba(255,255,186,0.35)',
//   'rgba(255,223,186,0.3)',
//   'rgba(186,225,255,0.3)',
//   'rgba(255,179,186,0.2)'
// ]

onMounted(() => {
  getAllTrips()
})

const getAllTrips = () => {
  axios.get(route('api.trips.index', { filters: filters.value }))
    .then(res => {
      clientOptions.value = res.data.clientOptions
      trips.value = res.data.trips.map(trip => {
        if (filters.value.currentTab !== 'active') {
          trip.status = filters.value.currentTab
          return trip
        }

        // different row background colour based on when the trip start
        const diff = differenceInDays(new Date(trip.start_date), new Date())
        switch (true) {
          case (diff < 0):
            trip.bgColour = '!bg-[rgba(186,255,201,0.5)]'
            trip.status = 'Ongoing'
            break
          case (diff >= 0 && diff<=5):
            trip.bgColour = '!bg-[rgba(186,225,255,0.5)]'
            trip.status = 'Upcoming'
            break
          default:
            trip.status = 'New'
            break
        }

        const tourGuides = trip.trip_days.map(tripDay => tripDay.tour_guide_name)
        trip.tourGuides = uniq(tourGuides).join(', ')
        const rentalCars = trip.trip_days.map(tripDay => tripDay.rental_car_name)
        trip.rentalCars = uniq(rentalCars).join(', ')

        if (!trip.tourGuides) {
          trip.bgColour = '!bg-[rgba(255,179,186,0.5)]'
          trip.status = 'Missing tour guide'
        }
        return trip
      })
    })
}

const keywordHasInput = debounce((event) => {
  filters.value.keyword = event.target.value
}, 800)

watch(() => filters, () => getAllTrips(), { deep: true })

const cancelTrip = async (trip) => {
  await confirmModal(
    'This action is irreversible!',
    'Are you sure you want to continue?'
  )
  axios.delete(route('api.trips.destroy', trip.id)).then(() => {
    trips.value = filter(trips.value, t => t.id !== trip.id)
  })
}
</script>
