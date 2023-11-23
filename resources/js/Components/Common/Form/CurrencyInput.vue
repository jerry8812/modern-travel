<template>
    <div class="relative">
        <input
            v-model="currencyFormat"
            type="text"
            class="w-full h-full text-sm border-0 rounded focus:ring"
            :class="style"
            @focus="isFormatting = false"
            @blur="isFormatting = true"
        >
        <span v-if="!isFormatting" class="absolute left-[1px] top-[7px]">$</span>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { formatCurrency } from '@/Helpers/helper.js'
import { debounce } from 'lodash-es'

const props = defineProps({
    modelValue: [Number, String],
    style: String
})

const emit = defineEmits(['update:modelValue'])

const isFormatting = ref(true)

const currencyFormat = computed({
    get: () => {
        const value = props.modelValue ?? 0
        if (isFormatting.value) {
            return formatCurrency(value)
        } else {
            return value
        }
    },
    set: debounce(data => {
        let newValue = parseFloat(data.replaceAll(',', ''))
        if (isNaN(newValue)) newValue = 0
        emit('update:modelValue', newValue)
    }, 100)
})
</script>
