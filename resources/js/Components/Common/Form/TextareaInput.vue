<template>
    <div class="w-full form-control">
        <label v-if="label" :for="name">
            <span class="label-text label">{{ label }}</span>
        </label>
        <div>
            <textarea
                :id="name"
                :name="name"
                class="w-full rounded-md textarea textarea-bordered"
                :class="computedClass"
                :value="modelValue"
                :rows="rows"
                :required="required"
                :placeholder="placeholder"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, watch, watchEffect } from 'vue'

const props = defineProps({
    name: String,
    rows: Number,
    modelValue: String,
    label: String,
    placeholder: String,
    theme: {
        type: String,
        default: 'primary'
    },
    required: Boolean,
    takeFocus: Boolean
})

const classMap = {
    primary: 'textarea-primary',
    secondary: 'textarea-secondary',
    accent: 'textareat-accent',
    success: 'textarea-success',
    warning: 'textarea-warning',
    info: 'textarea-info',
    error: 'textarea-error'
}
const computedClass = computed(() => {
    if (props.theme) {
        return classMap[props.theme]
    }
    return ''
})

onMounted(() => {
    if (props.takeFocus) {
        const textarea = document.getElementById(props.name)
        textarea.focus()
    }
})

defineEmits(['update:modelValue'])
</script>

