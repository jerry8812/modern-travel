<template>
    <div>
        <div class="items-end gap-8 lg:flex">
             <select
                v-model="selectedTimePeriod"
                class="text-sm text-gray-900 border border-gray-300 rounded-md py-1.5 font-semibold mr-4 max-h-10"
                @change="setStartAndEndDate"
            >
                <option
                    v-for="option in timePickerOptions"
                    :key="option.id"
                    :value="option.id"
                >
                    {{ option.value }}
                </option>
            </select>

            <div>
                <label for="start_date" class="block mb-1">Start date</label>
                <input
                    id="start_date"
                    v-model="startDate"
                    type="date"
                    class="border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none pl-4 p-1.5"
                    @change="onChange"
                >
            </div>
            <div>
                <label for="end_date" class="block mb-1">End date</label>
                <input
                    id="end_date"
                    v-model="endDate"
                    type="date"
                    class="border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none pl-4 p-1.5"
                    @change="onChange"
                >
            </div>
        </div>
        <div v-if="!datesAreValid" class="m-2 text-sm italic text-red-500">
            <i class="fa fa-exclamation-circle" /> Please choose a valid date period.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { format } from 'date-fns'

const props = defineProps({
    updateValueCallback: Function
})

const timePickerOptions = [
    { id: 'last-3-months', value: 'Last 3 Months' },
    { id: 'last-6-months', value: 'Last 6 Months' },
    { id: 'last-year', value: 'Last Year' },
    { id: 'custom-period', value: 'Custom period' }
]

const selectedTimePeriod = ref('custom-period')

const startDate = ref(null)
const endDate = ref(null)

// computed property to check that the start and end dates are valid
// return false if dates are outside 2000-01-01 and 2099-12-31 inclusive or if end date preceeds start date
const datesAreValid = computed(() => {
    const dateCheckRegex = /^(?:20\d{2})-(?:0[1-9]|1[0-2])-(?:0[1-9]|[1-2]\d|3[0-1])$/

    if (!startDate.value) {
        return dateCheckRegex.test(endDate.value)
    }

    return (dateCheckRegex.test(startDate.value) && dateCheckRegex.test(endDate.value) && (endDate.value >= startDate.value))
})

const setStartAndEndDate = () => {
    const now = new Date()
    endDate.value = formatDateToString(now)

    if (selectedTimePeriod.value == 'custom-period') {
        props.updateValueCallback(startDate.value, endDate.value)
        return
    }

    switch (selectedTimePeriod.value) {
        case 'last-3-months':
            // set end date to be 30th of June of current year
            startDate.value = formatDateToString(now.setMonth(now.getMonth() -3 ))
            break

        case 'last-6-months': // Last 6 months
            // start date of 6 months prior to today
            startDate.value = formatDateToString(now.setMonth(now.getMonth() -6 ))
            break

        case 'last-year': // Last 12 months
        startDate.value = formatDateToString(now.setFullYear(now.getFullYear() -1 ))
            break
    }
    props.updateValueCallback(startDate.value, endDate.value)
}

// function to take a date object and format it to the string yyyy-mm-dd
const formatDateToString = (date) => format(date, 'yyyy-MM-dd')

// when user types date in input field, change selected time period to 'Custom dates' and update comparison dates
const onChange = () => {
    selectedTimePeriod.value = 'custom-period'
    props.updateValueCallback(startDate.value, endDate.value)
}

// set initial values for start date and end date
onMounted(() => {
    setStartAndEndDate()
})
</script>
