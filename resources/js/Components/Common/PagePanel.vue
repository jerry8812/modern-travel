<template>
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="p-6">
            <div v-if="title" class="border-b border-gray-200 mb-3">
                <h2>{{ titles }}</h2>
            </div>
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String
})
</script>
