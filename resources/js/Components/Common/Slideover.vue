<template>
    <div v-if="buttonLabel" class="inline-block">
        <PrimaryButton
            type="button"
            :theme="currentTheme"
            @click="open = !open"
        >
            {{ buttonLabel }}
        </PrimaryButton>
    </div>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="onClose">
            <TransitionChild
                as="template"
                enter="ease-in-out duration-500"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in-out duration-500"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none">
                        <TransitionChild
                            as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full"
                            enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0"
                            leave-to="translate-x-full"
                        >
                            <DialogPanel class="relative w-screen max-w-md pointer-events-auto">
                                <TransitionChild
                                    as="template"
                                    enter="ease-in-out duration-500"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="ease-in-out duration-500"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0"
                                >
                                    <div class="absolute top-0 left-0 flex pt-4 pr-2 -ml-8 sm:-ml-10 sm:pr-4">
                                        <button
                                            type="button"
                                            class="text-gray-300 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            @click="open = false"
                                        >
                                            <span class="sr-only">Close panel</span>
                                            <XMarkIcon class="w-6 h-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                </TransitionChild>
                                <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                                    <h2 class="px-4 sm:px-6">
                                        <DialogTitle>
                                            {{ title }}
                                        </DialogTitle>
                                    </h2>
                                    <div class="relative flex-1 px-4 mt-6 sm:px-6">
                                        <component
                                            :is="formComponent"
                                            :form-data="formData"
                                            @form-saved="open = false"
                                        />
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, computed, watchEffect, watch } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { confirmModal } from '@/Helpers/modals.js'
import Swal from 'sweetalert2'

const open = ref(false)

const props = defineProps({
    formComponent: Object,
    formData: {
        type: Object,
        default: () => {}
    },
    doShow: {
        type: Boolean
    },
    buttonLabel: {
        type: String,
        default: null
    },
    title: String,
    theme: String
})

const emit = defineEmits(['close'])

watchEffect(() => {
    open.value = props.doShow
})

// emit the close event when the open ref is set to false internally
watch(open, (value) => {
    if (!value) {
        emit('close')
    }
})

const currentTheme = computed(() => {
    if (props.theme) return props.theme
    // if we haven't explicitly defined a theme then we choose primary styles and normal size for adding, small size when editing
    return props.formData.entity && props.formData.entity.id ? 'primary small' : 'primary'
})

const onClose = async () => {
    const result = await Swal.fire({
        title: 'Are you sure you want to close this form?',
        icon: 'warning',
        showCancelButton: true
    })

    if (result.isConfirmed) open.value = false
}
</script>
