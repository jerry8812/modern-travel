<template>
    <Combobox v-model="selectedClient">
        <div class="w-full px-4 sm:px-10 md:px-0 md:relative">
            <div class="relative w-full text-white focus-within:text-gray-400">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none ">
                    <div class="h-5 w-5 mb-[4px]">
                        <i class="fa-solid fa-magnifying-glass" />
                    </div>
                </div>
                <ComboboxInput
                    class="block w-full py-2 pl-10 pr-3 leading-5 placeholder-white bg-gray-500 bg-opacity-100 border border-transparent rounded-md focus:border-white focus:bg-white focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-white sm:text-sm"
                    placeholder="Search"
                    @change="doGlobalSearch"
                />
            </div>
            <ComboboxOptions v-if="searchResults.length > 0" class="absolute right-0 z-50 w-full py-2 mt-1 bg-white border border-gray-700 rounded-md top-14 md:top-10">
                <ComboboxOption
                    v-for="item in searchResults"
                    :key="item.id"
                    v-slot="{ active }"
                    as="template"
                    :value="item.id"
                >
                    <li
                        class="px-3 py-1 text-sm leading-4 cursor-pointer"
                        :class="{ 'bg-gray-100': active }"
                    >
                        <span>{{ item.name }} </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<script setup>
import {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption
} from '@headlessui/vue'
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios'
import { debounce } from 'lodash'
import { computed, ref, watch } from 'vue'

// hide global search from marketer
const isMarketer = computed(() => usePage().props.value.auth.user.user_type === 'Marketer')
const selectedClient = ref(null)

const searchResults = ref([])

watch(selectedClient, clientId => {
    if (clientId) {

    }
})

const doGlobalSearch = debounce(async (e) => {
    const keyword = e.target.value

}, 600)
</script>
