<script setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false
    },
    value: {
        type: String,
        default: null
    },
    theme: String,
    labelLeft: String,
    labelRight: String,
    name: String
})

const proxyChecked = computed({
    get() {
        return props.checked
    },

    set(val) {
        emit('update:checked', val)
    }
})
const classMap = {
    primary: 'checkbox-primary',
    secondary: 'checkbox-secondary',
    accent: 'checkbox-accent',
    success: 'checkbox-success',
    warning: 'checkbox-warning',
    info: 'checkbox-info',
    error: 'checkbox-error'
}
const computedClass = computed(() => {
    if (props.theme) {
        return classMap[props.theme]
    }
    return ''
})
</script>

<template>
    <label :for="name" class="flex justify-start cursor-pointer label">
        <span v-if="labelLeft" class="mr-2 label-text">{{ labelLeft }}</span>
        <input
            :id="name"
            v-model="proxyChecked"
            type="checkbox"
            :value="value"
            class="checkbox checkbox-xs"
            :class="computedClass"
        >
        <span v-if="labelRight" class="ml-2 label-text">{{ labelRight }}</span>
    </label>
</template>
