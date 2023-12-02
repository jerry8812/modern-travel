<template>
  <div class="flex justify-between px-6 py-2 mb-8 border border-gray-200 rounded-lg shadow bg-gray-50">
    <div class="flex w-3/12 p-2">
      <div class="pr-10 text-lg text-gray-900 xl:pr-0">
        <div class="mb-2">
          <span class="font-semibold">Name: </span>
          {{ currentTourGuide.name }}
        </div>
        <div class="mb-2">
          <span><i class="fas fa-phone-rotary" /></span>
          <span class="pl-2 font-semibold">Phone Number: </span>
          {{ currentTourGuide.phone_number }}
        </div>
        <div class="mb-2">
          <span class="font-semibold"><i class="fas fa-envelope" /></span>
          <span class="pl-2 font-semibold">Email: </span>
          {{ currentTourGuide.email }}
        </div>
        <div class="mb-2">
          <span><i class="fas fa-map-marker-alt" /></span>
          <span class="pl-2 font-semibold">Location: </span>
          {{ currentTourGuide.location }}
        </div>
      </div>
    </div>

    <div class="relative grid w-8/12 grid-cols-1 gap-x-14 md:grid-cols-2">
      <button
        type="button"
        class="absolute -left-1.5 -top-2.5 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500"
        @click="showCalendarViewOf(-2)"
      >
        <span class="text-xl hover:text-gray-800 hover:scale-110"><i class="fas fa-chevron-left" /></span>
      </button>
      <button
        type="button"
        class="absolute -right-1.5 -top-2.5 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500"
        @click="showCalendarViewOf(2)"
      >
        <span class="text-xl hover:text-gray-800 hover:scale-110"><i class="fas fa-chevron-right" /></span>
      </button>
      <section v-for="(month, monthIdx) in months" :key="monthIdx" :class="[monthIdx === months.length - 1 && 'hidden md:block', 'text-center']">
        <h2 class="text-base font-semibold text-gray-900">
          {{ month.name }}
        </h2>
        <div class="grid grid-cols-7 mt-6 text-xs leading-4 text-gray-500">
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thur</div>
          <div>Fri</div>
          <div>Sat</div>
          <div>Sun</div>
        </div>
        <div class="grid grid-cols-7 gap-px mt-2 text-sm bg-gray-200 rounded-lg shadow isolate ring-1 ring-gray-200">
          <button
            v-for="(day, dayIdx) in month.days"
            :key="day.date"
            type="button"
            :class="[day.isCurrentMonth ? 'bg-white text-gray-900' : 'bg-gray-50 text-gray-400', dayIdx === 0 && 'rounded-tl-lg',
                     dayIdx === 6 && 'rounded-tr-lg',
                     dayIdx === month.days.length - 7 && 'rounded-bl-lg',
                     dayIdx === month.days.length - 1 && 'rounded-br-lg', 'relative py-1.5 hover:bg-gray-100 focus:z-10']"
          >
            <time
              :datetime="day.date"
              :class="[day.isToday && 'bg-indigo-600 font-semibold text-white', 'mx-auto flex h-6 w-6 items-center justify-center rounded-full',
                       day.isScheduled && '!bg-red-500 font-semibold text-white', 'mx-auto flex h-6 w-6 items-center justify-center rounded-full'
              ]"
            >
              {{ day.date.split('-').pop().replace(/^0/, '') }}</time>
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  tourGuide: Object
})

const months = computed(() => {
  const months = currentTourGuide.value.months
  const scheduledDays = currentTourGuide.value.trip_days.map(day => day.date) || []
  // set isScheduled on each calendar day
  months.map(month => {
    month.days.map(singleDay => {
      singleDay.isScheduled = scheduledDays.includes(singleDay.date)
    })
  })
  return months
})

const sequenceOfMonth = ref(0)
const currentTourGuide = ref(props.tourGuide)

const showCalendarViewOf = async (monthNumber) => {
  sequenceOfMonth.value += monthNumber
  await axios.get(route('api.tour-guides.index'), {
    params: {
      sequenceOfMonth: sequenceOfMonth.value,
      tour_guide_id: currentTourGuide.value.id
    }
  })
    .then(res => {
      currentTourGuide.value = res.data[0]
    })
}
</script>
