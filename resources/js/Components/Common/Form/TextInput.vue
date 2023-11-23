<template>
    <div class="flex flex-col w-full ">
        <label v-if="label" :for="name" class="block text-sm font-medium leading-6 text-gray-900 label">{{ label }}</label>
        <input
            :id="name"
            :name="name"
            :value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :type="type"
            :disabled="disabled"
            class="rounded-md input input-bordered"
            :class="[{ 'bg-slate-50': disabled }, { 'max-w-[100px]': isNumberField }]"
            :min="minimumValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
    </div>
</template>

<script setup>
import { computed } from 'vue'

// computed property to check if input is for a number
const isNumberField = computed(() => props.type === 'number')

const props = defineProps({
    label: String,
    name: String,
    type: {
        type: String,
        default: 'text'
    },
    required: Boolean,
    disabled: Boolean,
    modelValue: [String, Number],
    placeholder: String,
    minimumValue: Number
})

defineEmits(['update:modelValue'])
</script>
