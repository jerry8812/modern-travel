<template>
  <div class="w-full">
    <select
      :id="id"
      :value="modelValue"
      :name="id"
      class="block w-full px-2 border-gray-300 border rounded-md shadow-sm sm:text-sm focus:ring-slate-400 focus:border-slate-400"
      :class="[displayLarge ? 'py-2' : 'py-1.5']"
      @input="updateValue"
    >
      <!-- Note: Setting this to null results in issues - rather than saving null, the JS will take the 'Any' string instead. This also breaks the 'selected' prop. -->
      <option v-if="!hideNull" selected value="">
        Any
      </option>
      <!-- Lookup entries are objects with 'id' and 'value' keys. -->
      <template v-if="lookupIsObject">
        <option v-for="object in lookup" :key="object.id" :value="object.id">
          {{ object.name }}
        </option>
      </template>
      <!-- Lookups are flat string values. -->
      <template v-else>
        <option v-for="(value, index) in lookup" :key="index" :value="value">
          {{ value }}
        </option>
      </template>
    </select>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  lookup: Array,
  id: String,
  lookupIsObject: Boolean,
  hideNull: Boolean,
  displayLarge: Boolean
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (event) => {
  let value = event.target.value
  emit('update:modelValue', value == '' || !value ? null : value)
}
</script>
