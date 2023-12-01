<template>
    <div
        class="badge rounded-lg font-headings border-none text-xs py-2 lg:text-base md:py-3.5 whitespace-nowrap"
        :class="stageClass.colourClasses"
    >
        <span class="mr-1.5 " aria-hidden="true"><i :class="stageClass.icon" /></span>
        {{ status }}
    </div>

    <div v-if="isFailed" class="badge rounded-lg ml-2 border-none text-xs py-2 lg:text-base md:py-3.5 bg-red-50 text-red-600 whitespace-nowrap ">
        <span class="mr-1.5  text-red-400" aria-hidden="true"><i class="fa-solid fa-circle-xmark" /></span>
        Failed
    </div>

    <div v-if="applicationStatus" class="badge rounded-lg font-headings ml-2 border-none text-xs py-2 lg:text-base md:py-3.5 bg-green-50 text-green-600 whitespace-nowrap">
        <span class="mr-1.5  text-green-600" aria-hidden="true"><i class="fa-solid fa-pen-to-square" /></span>
        {{ props.applicationStatus }}
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: {
        type: String
    },
    clientStage: {
        type: String,
        default: 'lead'
    },
    isFailed: {
        type: String
    },
    applicationStatus: {
        type: String
    }
})

const stageData = {
    lead: {
        colourClasses: 'bg-blue-50 text-blue-600',
        icon: 'fa-solid fa-signal-fair'
    },
    advice: {
        colourClasses: 'bg-purple-50 text-purple-600',
        icon: 'fa-solid fa-signal-good'
    },
    pipeline: {
        colourClasses: 'bg-yellow-50 text-yellow-600',
        icon: 'fa-solid fa-signal-bars-strong'
    },
    client: {
        colourClasses: 'bg-green-50 text-green-600',
        icon: 'fa-sharp fa-solid fa-circle-check'
    }
}

const stageClass = computed(() => stageData[props.clientStage])
</script>
