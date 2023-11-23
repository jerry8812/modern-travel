<template>
    <div v-for="option in options" :key="option">
        <div class="max-w-max form-control">
            <label :for="fieldName + '-' + option" class="flex items-center justify-start gap-3 cursor-pointer label">
                <input
                    :id="fieldName + '-' + option"
                    v-model="selectedOptions"
                    type="checkbox"
                    :name="fieldName"
                    :class="computedClass"
                    :value="option"
                    :required="required"
                >
                <span class="label-text">{{ option }}</span>
            </label>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { uniqueId } from 'lodash-es'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    defaultValue: Array,
    options: Array,
    theme: {
        type: String,
        default: 'primary'
    },
    required: Boolean
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

const emit = defineEmits(['update:modelValue'])

const selectedOptions = computed({
    get: () => props.modelValue || [],
    set: (data) => {
        emit('update:modelValue', data)
    }
})

const fieldName = uniqueId('checkbox-group-')
</script>
