<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    options: Array,
    theme: String,
    hideNull: Boolean,
    required: Boolean
})

const input = ref(null)

const classMap = {
    primary: 'select-primary',
    secondary: 'select-secondary',
    accent: 'select-accent',
    success: 'select-success',
    warning: 'select-warning',
    info: 'select-info',
    error: 'select-error'
}
const computedClass = computed(() => {
    if (props.theme) {
        return classMap[props.theme]
    }
    return ''
})
defineEmits(['update:modelValue'])
</script>

<template>
    <div class="w-full form-control">
        <label v-if="label" for="select-drop-down" class="block text-sm font-medium leading-6 text-gray-900 label">{{ label }}</label>
        <select
            ref="input"
            :value="modelValue"
            name="select-drop-down"
            :required="required"
            class="w-full rounded-md select select-bordered"
            :class="computedClass"
            v-bind="$attrs"
            @input="$emit('update:modelValue', $event.target.value)"
        >
            <option v-if="!hideNull" value="">
                Select
            </option>
            <option v-for="userType in options" :key="userType" :value="userType">
                {{ userType }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    inheritAttrs: false, // set inheritAttrs to false
    computed: {
        selectId() {
            return this.$attrs.id || `input-${this._uid}`
        }
    }
}
</script>
