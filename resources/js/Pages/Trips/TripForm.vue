<template>
  <div class="mx-auto w-full">
    <p class="mb-6 font-semibold text-2xl">
      Create a Trip
    </p>
    <div class="w-full border-2 border-slate-100 rounded-lg shadow-sm px-6 pt-3 pb-4">
      <form class="mb-6 space-y-5">
        <div class="w-full grid grid-cols-3 gap-6">
          <div>
            <label for="start_date" class="form-label">Start Date <span class="text-red-500">*</span></label>
            <input
              id="start_date"
              v-model="tripForm.start_date"
              type="date"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg w-full py-2 px-5"
            >
          </div>
          <div>
            <label for="end_date" class="form-label">End Date <span class="text-red-500">*</span></label>
            <input
              id="end_date"
              v-model="tripForm.end_date"
              type="date"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg w-full py-2 px-5"
            >
          </div>
          <div>
            <label for="amount_of_people" class="form-label">Amount of People <span class="text-red-500">*</span></label>
            <input
              id="amount_of_people"
              v-model="tripForm.amount_of_people"
              type="number"
              min="0"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg w-full py-2 px-5"
            >
          </div>
        </div>
        <div class="w-full grid grid-cols-3 gap-6">
          <div>
            <label for="source" class="form-label">Source</label>
            <input
              id="source"
              v-model="tripForm.source"
              type="text"
              class="border border-gray-300 text-gray-900 rounded-lg focus:border-blue-500 block w-full py-1.5 px-2"
            >
          </div>
          <div>
            <label for="status" class="form-label">Status</label>
            <SimpleSelect
              v-model="tripForm.status"
              :lookup="tripStatusLookup"
              display-large
            />
          </div>
          <div>
            <label for="total_price" class="form-label">Total Price</label>
            <input
              id="total_price"
              v-model="tripForm.total_price"
              type="number"
              min="0"
              step="50"
              class="border border-gray-300 text-gray-900 rounded-lg focus:border-blue-500 block w-full py-1.5 px-2"
            >
          </div>
        </div>
        <div class="w-full grid grid-cols-3 gap-6">
          <div>
            <label for="tour_guide" class="form-label">Tour Guide</label>
            <SimpleSelect
              v-model="tripForm.tour_guide"
              :lookup="availableTourGuides"
              display-large
              lookup-is-object
            />
          </div>
          <div>
            <label for="rental_car" class="form-label">Rental Car</label>
            <SimpleSelect v-model="tripForm.rental_car" :lookup="availableCars" display-large lookup-is-object />
          </div>
          <div>
            <label for="comment" class="form-label">Comment</label>
            <textarea
              id="comment"
              v-model="tripForm.comment"
              class="border border-gray-300 text-gray-900 rounded-lg focus:border-blue-500 block w-full py-1.5 px-2"
            />
          </div>
        </div>

        <span class="form-label block mb-3">Trip Details <span class="text-red-500">*</span></span>
        <div v-if="tripForm.trip_days.length" class="max-h-96 overflow-auto">
          <table class="shadow-md w-full text-sm text-left text-gray-500 rounded">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
              <tr>
                <th class="px-3 py-3">
                  Day
                </th>
                <th class="px-3 py-3">
                  Date
                </th>
                <th class="px-3 py-3">
                  Location
                </th>
                <th class="px-3 py-3">
                  Rental Car
                </th>
                <th class="px-3 py-3">
                  Tour Guide
                </th>
                <th class="px-3 py-3">
                  Rental Fee
                </th>
                <th class="px-3 py-3">
                  Comment
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="day in tripForm.trip_days"
                :key="day.date"
                class="even:bg-slate-100"
              >
                <td class="px-3 py-2 text-left">
                  <span class="font-semibold">{{ day.day_number }}</span>
                </td>
                <td class="px-3 py-2 text-left">
                  <span class="font-semibold">{{ day.date }}</span>
                </td>
                <td class="px-3 py-2">
                  <SimpleSelect v-model="day.location" :lookup="townLookup" />
                </td>
                <td class="px-3 py-2">
                  <SimpleSelect v-model="day.rental_car_id" :lookup="availableCars" lookup-is-object />
                </td>
                <td class="px-3 py-2">
                  <SimpleSelect v-model="day.tour_guide_id" :lookup="availableTourGuides" lookup-is-object />
                </td>
                <td class="px-3 py-2">
                  <input
                    id="rental_fee"
                    v-model="day.rental_fee"
                    type="number"
                    min="0"
                    step="50"
                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg max-w-[6rem]
                    focus:border-blue-500 block w-full py-1.5 px-2"
                  >
                </td>
                <td class="px-3 py-2">
                  <input
                    v-model="day.comment"
                    type="text"
                    class="bg-white w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 py-1.5 px-2"
                    placeholder="Enter comments ..."
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </form>
      <div class="flex justify-start gap-6">
        <button type="button" class="btn-submit" @click="saveTrip">
          Submit
        </button>
        <button type="button" class="btn-cancel" @click="Inertia.get(route('trips'))">
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { format, differenceInCalendarDays, addDays } from 'date-fns'
import { debounce } from 'lodash'
import { TRIP_BASE } from '@/constants.js'

import SimpleSelect from '@/Components/Common/SimpleSelect.vue'
import axiosErrorInterceptor from '@/Helpers/errorHandling.js'
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  trip: Object,
  townLookup: Array,
  tripStatusLookup: Array,
  errors: Object
})

const availableCars = ref([])
const availableTourGuides = ref([])

const tripForm = useForm({
  id: null,
  start_date: format(new Date(), 'yyyy-MM-dd'),
  end_date: null,
  amount_of_people: 0,
  source: '',
  status: 'New',
  total_price: 0,
  tour_guide: null,
  rental_car: null,
  comment: '',
  trip_days: [],
  ...props.trip || []
})

onMounted(() => {
  getAvailableResources()
}),

// calculate difference in calendar days between two selected dates
watch(() => [tripForm.start_date, tripForm.end_date], debounce(() => {
  tripForm.trip_days = []
  // reset trip details if any of date is not seleted
  if (!tripForm.start_date || !tripForm.end_date) return

  const startDate = new Date(tripForm.start_date)
  const endDate = new Date(tripForm.end_date)
  const differences = differenceInCalendarDays(endDate, startDate)

  // we don't have a trip that has more than 30 days
  if (differences >= 30) return

  for (let index = 0; index <= differences; index++) {
    let newDay = {
      id: null,
      day_number: index + 1,
      date: format(addDays(startDate, index), 'yyyy-MM-dd'),
      rental_car_id: null,
      tour_guide_id: null,
      rental_fee: 600,
      location: TRIP_BASE,
      comment: ''
    }
    // get the day that has same date in the database
    const oldDay = props.trip?.trip_days.find(day => day.date === newDay.date)
    if (oldDay) {
      oldDay.day_number = newDay.day_number
      newDay = { ...newDay, ...oldDay }
    }
    tripForm.trip_days.push(newDay)
  }
  getAvailableResources()
}), 300)

// populate rental car and tour guide to each single day
watch(() => [tripForm.tour_guide, tripForm.rental_car], () => {
  tripForm.trip_days.forEach(day => {
    day.rental_car_id = tripForm.rental_car
    day.tour_guide_id = tripForm.tour_guide
  })
})

const saveTrip = () => {
  // update a trip
  if (tripForm.id) {
    tripForm.put(route('trips.update', tripForm.id), {
      onError: () => {
        axiosErrorInterceptor(422, { errors: props.errors })
      }
    })
    return
  }

  // create a new trip
  tripForm.post(route('trips.store'), {
    onError: () => {
      axiosErrorInterceptor(422, { errors: props.errors })
    }
  })
}

const getAvailableResources = debounce(() => {
  if (!tripForm.start_date || !tripForm.end_date) return

  axios.get(route('api.trips.get-available-resources'), {
    params: {
      startDate: tripForm.start_date,
      endDate: tripForm.end_date
    }
  })
    .then(res => {
      availableCars.value = res.data.availableCars
      availableTourGuides.value = res.data.availableTourGuides
    })
}, 500)
</script>
