<template>
    <div :class="[{'flex gap-4':isHorizontally}]" class="pt-1">
        <div v-for="option in options" :key="option">
            <div class="form-control">
                <label :for="fieldName + '-' + option" class="flex items-start justify-start gap-2 cursor-pointer label">
                    <input
                        :id="fieldName + '-' + option"
                        v-model="value"
                        type="radio"
                        :name="fieldName"
                        :class="computedClass"
                        :value="option"
                        :required="required"
                    >
                    <span class="label-text">{{ option }}</span>
                </label>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { uniqueId } from 'lodash-es'

const props = defineProps({
    modelValue: String,
    isHorizontally: Boolean,
    options: Array,
    required: Boolean,
    theme: {
        type: String,
        default: 'primary'
    }
})

const computedClass = computed(() => {
    const classMap = {
        primary: 'radio-primary',
        secondary: 'radio-secondary',
        accent: 'radio-accent',
        success: 'radio-success',
        warning: 'radio-warning',
        info: 'radio-info',
        error: 'radio-error'
    }

    return classMap[props.theme]
})

const emit = defineEmits(['update:modelValue'])

const value = computed({
    get: () => props.modelValue || null,
    set: (data) => emit('update:modelValue', data)
})

// combine all props.options into a single string
const fieldName = uniqueId('radio-group-')
</script>
