<template>
    <span :class="[highlightOverdue && isPastOrToday(date) ? 'text-red-500' : '', highlightOverdue && isWellOverdue ? 'font-bold' : '','whitespace-nowrap']">
        <span v-if="highlightOverdue && isPastOrToday(date)"><i class="fad fa-calendar-exclamation" /></span>
        {{ formattedDate }}
    </span>
</template>

<script setup>
import { computed } from 'vue'
import { differenceInDays, format as frmt, isBefore, isToday } from 'date-fns'

const props = defineProps({
    date: {
        type: String,
        required: true
    },
    format: {
        type: String,
        default: 'dd/MM/yyyy'
    },
    highlightOverdue: {
        type: Boolean
    }
})

const formattedDate = computed(() => frmt(new Date(props.date), props.format))

// if more than 20 days overdue
const isWellOverdue = computed(() => {
    const dateObj = new Date(props.date)
    const daysDiff = differenceInDays(new Date(), dateObj)
    return isBefore(dateObj, new Date()) && daysDiff > 20
})

function isPastOrToday(date) {
    const dateObj = new Date(date)
    return isBefore(dateObj, new Date()) || isToday(dateObj)
}
</script>
