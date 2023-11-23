<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    modelValue: String,
    name: String,
    type: String,
    label: String,
    checked: Boolean,
    theme: {
        type: String,
        default: 'primary'
    }

})

const input = ref(null)

const classMap = {
    primary: 'radio-primary',
    secondary: 'radio-secondary',
    accent: 'radio-accent',
    success: 'radio-success',
    warning: 'radio-warning',
    info: 'radio-info',
    error: 'radio-error'
}

const computedClass = computed(() => {
    if (props.theme) {
        return classMap[props.theme]
    }
    return ''
})

defineEmits(['update:modelValue', 'change'])

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
    <div class="form-control">
        <label :for="inputId" class="label cursor-pointer flex justify-start gap-3 items-start">
            <input
                :id="inputId"
                type="radio"
                :name="name"
                :class="computedClass"
                :checked="checked"
                @change="$emit('change')"
            >
            <span class="label-text">{{ label }}</span>
        </label>
    </div>
</template>

<script>
export default {
    inheritAttrs: false, // set inheritAttrs to false
    computed: {
        inputId() {
            return this.$attrs.id || `input-${this._uid}`
        }
    }
}
</script>
