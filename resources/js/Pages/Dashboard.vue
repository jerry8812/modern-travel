<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div>
    <button class="btn btn-blue" type="button" @click="Inertia.get(route('create-trip'))">
      Create Trip
    </button>
    <div class="mt-5 overflow-hidden border rounded-xl">
      <table class="w-full text-sm text-left text-gray-500 shadow-md">
        <thead class="text-white uppercase bg-[#34495e] sticky top-0 rounded">
          <tr class="text-base">
            <th class="py-4 pl-2">
              trip number
            </th>
            <th class="py-4 pl-2">
              status
            </th>
            <th class="py-4 pl-2">
              start date
            </th>
            <th class="py-4 pl-2">
              end date
            </th>
            <th class="py-4 max-w-[7rem]">
              Tourists
            </th>
            <th class="py-4">
              total price
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
              Comments
            </th>
            <th />
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
              {{ trip.trip_number }}
            </td>
            <td class="px-2 py-4 text-left">
              {{ trip.status }}
            </td>
            <td class="px-2 py-4 text-left">
              {{ trip.start_date }}
            </td>
            <td class="px-2 py-4 text-left">
              {{ trip.end_date }}
            </td>
            <td class="py-4 text-left">
              {{ trip.amount_of_people }}
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
            <td class="py-4">
              {{ trip.comment }}
            </td>
            <td class="pl-1">
              <span
                class="inline-block text-2xl text-green-600 cursor-pointer hover:scale-110"
                @click="Inertia.get(route('trips.edit', trip.id))"
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
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios'

import { uniq, filter } from 'lodash'
import { confirmModal } from '@/Helpers/modals.js'
import { formatNZCurrency } from '@/Helpers/helper.js'
import { differenceInDays } from 'date-fns'

const trips = ref([])

// const rowBGColours = [
//   'rgba(186,255,201,0.3)',
//   'rgba(255,255,186,0.35)',
//   'rgba(255,223,186,0.3)',
//   'rgba(186,225,255,0.3)',
//   'rgba(255,179,186,0.2)'
// ]

onMounted(async () => {
  await axios.get(route('api.trips.index'))
    .then(res => {
      trips.value = res.data.map(trip => {
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
})

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
