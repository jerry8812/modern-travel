<template>
    <div>
        <div class="gap-8 items-ce lg:flex">
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

// function to take a date object and format it to the string yyyy-mm-dd
const formatDateToString = (date) => format(date, 'yyyy-MM-dd')

// when user types date in input field, change selected time period to 'Custom dates' and update comparison dates
const onChange = () => {
    props.updateValueCallback(startDate.value, endDate.value)
}

// set initial values for start date and end date
onMounted(() => {
    const now = new Date()
    endDate.value = formatDateToString(now)
    props.updateValueCallback(startDate.value, endDate.value)
})
</script>
