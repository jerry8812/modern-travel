<template>
    <div v-if="message" class="italic text-xs text-red-500 opacity-70">
        {{ message }}
    </div>
</template>

<script setup>
defineProps({
    message: String
})
</script>
