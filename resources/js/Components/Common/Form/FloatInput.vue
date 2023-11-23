<template>
    <div class="flex flex-col w-full ">
        <label v-if="label" :for="name" class="block text-sm font-medium leading-6 text-gray-900 label">{{ label }}</label>
        <input
            :id="name"
            :name="name"
            :value="modelValue"
            :required="required"
            type="number"
            :step="step"
            min="0"
            :disabled="disabled"
            class="rounded-md input input-bordered"
            :class="[{ 'bg-slate-50': disabled }]"
            @input="$emit('update:modelValue', $event.target.value)"
        >
    </div>
</template>

<script setup>
defineProps({
    label: String,
    name: String,
    type: {
        type: String,
        default: 'text'
    },
    required: Boolean,
    disabled: Boolean,
    modelValue: [Number, String],
    placeholder: String,
    step: {
        type: String,
        default: '0.01'
    }
})

defineEmits(['update:modelValue'])
</script>
