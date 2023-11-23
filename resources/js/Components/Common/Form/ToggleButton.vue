<template>
    <!--
        Use this toggle button for fields which are intended to contain booleans.

        Regarding its label, pass in as props either:
        1- ONLY label: To show the toggle button next to static label.
        2- title, trueLabel and falseLabel: To show the toggle button under the title with a label which will dinamically change.
     -->
    <div class="flex flex-col items-start justify-start w-full gap-3 cursor-pointer label">
        <span v-if="title" class="block text-sm font-medium leading-6 text-gray-900">{{ title }}</span>
        <SwitchGroup as="div" class="flex items-center">
            <Switch v-model="enabled" class="relative inline-flex h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer shrink-0 w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-wsp-blue" :class="[enabled ? 'bg-green-500' : 'bg-gray-500']">
                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow pointer-events-none ring-0" :class="[enabled ? 'translate-x-5' : 'translate-x-0']" />
            </Switch>
            <SwitchLabel as="span" class="ml-2 text-sm leading-4 text-gray-900 cursor-pointer">
                <span class="label-text">{{ formattedLabel }}</span>
            </SwitchLabel>
        </SwitchGroup>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

const props = defineProps({
    title: String,
    label: String,
    modelValue: Boolean,
    trueLabel: String,
    falseLabel: String
})

const emit = defineEmits(['update:modelValue'])

const enabled = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const formattedLabel = computed(() => {
    if (props.title && props.trueLabel && props.falseLabel) {
        return props.modelValue ? props.trueLabel : props.falseLabel
    }

    return props.label
})
</script>
