<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div v-if="toasts.length > 0" aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <template v-for="toast in toasts" :key="toast.id">
                <transition
                    enter-active-class="transform ease-out duration-500 transition"
                    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                    leave-active-class="transition ease-in duration-100"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="toast.show"
                        class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                        :class="toast.type === 'error' ? 'bg-red-100' : 'bg-green-100'"
                    >
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 text-lg">
                                    <span v-if="toast.type === 'error'" class="text-red-500"><i class="fa-solid fa-thumbs-down" /></span>
                                    <span v-else class="text-green-500"><i class="fa-regular fa-circle-check" /></span>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ toast.message }}
                                    </p>
                                </div>
                                <div class="ml-4 flex flex-shrink-0">
                                    <button type="button" class="inline-flex rounded-md  text-gray-600 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="hideToast(toast)">
                                        <span class="sr-only">Close</span>
                                        <i class="fa-solid fa-xmark" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </template>
        </div>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3'
import { defer, delay } from 'lodash-es'
import { ref, watch } from 'vue'

const TIME_TO_SHOW = 5000 // 5 seconds
const toasts = ref([])

watch(() => usePage().props.value.toast.id, () => {
    const message = usePage().props.value.toast.message
    const type = usePage().props.value.toast.type
    const id = usePage().props.value.toast.id

    if (message) {
        toasts.value.unshift({
            id,
            message,
            type,
            show: false
        })

        defer(() => {
            toasts.value[0].show = true
        })

        // we only want to show a toast for 5 seconds
        delay(() => {
            if (toasts.value.length === 0) {
                return
            }
            // first set show to false for the last item in toasts array so the transition can run
            toasts.value[toasts.value.length - 1].show = false

            // then remove from array after a delay (transition is 100ms)
            delay(() => {
                toasts.value.pop()
            }, 150)
        }, TIME_TO_SHOW)
    }
})

const hideToast = (toast) => {
    toasts.value.splice(toasts.value.indexOf(toast), 1)
}
</script>
