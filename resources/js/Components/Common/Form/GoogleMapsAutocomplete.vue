<template>
    <div class="flex flex-col w-full ">
        <label v-if="label" for="autocomplete_address" class="block text-sm font-medium leading-6 text-gray-900 label">{{ label }}</label>
        <input
            id="autocomplete_address"
            ref="autocompleteRef"
            v-model="autocompleteText"
            name="autocomplete_address"
            placeholder="Start typing"
            type="text"
            class="rounded-md input input-bordered"
            :required="required"
        >
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'

const props = defineProps({
    modelValue: String,
    label: String,
    required: Boolean,
    country: {
        type: [String, Array],
        default: () => ['nz']
    },
    types: {
        type: String,
        default: 'address'
    }
})

const emit = defineEmits(['update:modelValue', 'no-results-found'])

const autocompleteRef = ref(null)

const autocompleteText = computed({
    get: () => props.modelValue || null,
    set: (data) => emit('update:modelValue', data)
})

onMounted(() => {
    const options = {}

    // Set additional options if passed in as props.
    if (props.types) {
        options.types = [props.types]
    }

    if (props.country) {
        options.componentRestrictions = {
            country: props.country
        }
    }

    // Load google API into script.
    const autocomplete = new google.maps.places.Autocomplete(
        autocompleteRef.value,
        options
    )

    google.maps.event.addListener(autocomplete, 'place_changed', () => {
        const place = autocomplete.getPlace()

        if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
            emit('no-results-found', place, props.id)
            return
        }

        if (place.formatted_address !== undefined) {
        // Update autocompleteText.value to show on input and also fire update:modelValue
            autocompleteText.value = place.formatted_address
        }
    })

})
</script>
