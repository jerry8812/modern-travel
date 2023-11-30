<template>
    <div class="min-h-full">
        <Popover v-slot="{ open }" as="header" class="pb-24 bg-gradient-to-r from-sky-800 to-cyan-600">
            <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="relative flex flex-wrap items-center justify-center lg:justify-between">
                    <!-- Logo -->
                    <div class="absolute left-0 flex-shrink-0 py-5 lg:static">
                        <Link :href="route('dashboard')">
                            <span class="sr-only">Modern Travel</span>
                            <img src="/images/logo_new.png" class="h-16 mr-3" alt="Modern Travel Logo">
                        </Link>
                    </div>

                    <!-- Right section on desktop -->
                    <div class="hidden lg:ml-4 lg:flex lg:items-center lg:py-5 lg:pr-0.5">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="relative flex-shrink-0 ml-4">
                            <div class="flex gap-2">
                                <MenuButton class="flex items-end justify-end gap-2 leading-none text-white">
                                    <span class="sr-only">Open user menu</span>
                                    <span>Hello, {{ $page.props.auth.user.name }}</span>
                                    <i class="fas fa-caret-down" />
                                </MenuButton>
                            </div>
                            <transition leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                                <MenuItems class="absolute z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg -right-2 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                    </MenuItem>
                                    <MenuItem>
                                        <Link as="button" method="POST" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-800" :href="route('logout')">
                                            Sign out
                                        </Link>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>

                    <div class="w-full py-5 lg:border-t lg:border-white lg:border-opacity-20">
                        <div class="lg:grid lg:grid-cols-3 lg:items-center lg:gap-8">
                            <!-- Left nav -->
                            <div class="hidden lg:col-span-2 lg:block">
                                <nav class="flex space-x-4">
                                    <Link
                                        v-for="item in navigation"
                                        :key="item.name"
                                        :href="item.href"
                                        :class="[item.current ? 'text-white bg-opacity-20' : 'text-cyan-100 bg-opacity-0', 'rounded-md bg-white px-3 py-2 text-sm font-medium hover:bg-opacity-10']"
                                        :aria-current="item.current ? 'page' : undefined"
                                    >
                                        {{ item.name }}
                                    </Link>
                                </nav>
                            </div>
                            <!-- Search -->
                            <GlobalSearch />
                        </div>
                    </div>

                    <!-- Menu button -->
                    <div class="absolute right-0 flex-shrink-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <PopoverButton class="inline-flex items-center justify-center p-2 bg-transparent rounded-md text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <i v-if="!open" class=" fa-regular fa-bars" />
                            <i v-else class="fa-regular fa-xmark" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                </div>
            </div>

            <TransitionRoot as="template" :show="open">
                <div class="lg:hidden">
                    <TransitionChild
                        as="template"
                        enter="duration-150 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-150 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <PopoverOverlay class="fixed inset-0 z-20 bg-black bg-opacity-25" />
                    </TransitionChild>

                    <TransitionChild
                        as="template"
                        enter="duration-150 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-150 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <PopoverPanel focus class="absolute inset-x-0 top-0 z-30 w-full max-w-3xl p-2 mx-auto transition origin-top transform">
                            <div class="bg-white divide-y divide-gray-200 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="pt-3 pb-2">
                                    <div class="flex items-center justify-between px-4">
                                        <div>
                                            <img class="w-auto h-8" src="/images/Invicta-Logo-dark.png" alt="Invicta Financial">
                                        </div>
                                        <div class="-mr-2">
                                            <PopoverButton class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                                                <span class="sr-only">Close menu</span>
                                                <i class="fa-regular fa-xmark" aria-hidden="true" />
                                            </PopoverButton>
                                        </div>
                                    </div>
                                    <div class="px-2 mt-3 space-y-1">
                                        <a v-for="item in navigation" :key="item.name" :href="item.href" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                                    </div>
                                </div>
                                <div class="pt-4 pb-2">
                                    <div class="flex items-center px-5">
                                        <div class="flex-shrink-0">
                                            <span>Hello, {{ $page.props.auth.user.name }}</span>
                                        </div>
                                    </div>
                                    <div class="px-2 mt-3 space-y-1">
                                        <a v-for="item in userNavigation" :key="item.name" :href="item.href" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                                        <Link as="button" method="POST" class="block w-full px-3 py-2 text-base font-medium text-left text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800" :href="route('logout')">
                                            Sign out
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </PopoverPanel>
                    </TransitionChild>
                </div>
            </TransitionRoot>
        </Popover>
        <main class="pb-8 -mt-24">
            <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <slot />
            </div>
        </main>
        <footer>
            <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="py-8 text-sm text-center text-gray-500 border-t border-gray-200 sm:text-left">
                    <span class="block sm:inline">&copy; 2023 Modern Travel  </span> <span class="block sm:inline">All rights reserved.</span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverOverlay, PopoverPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'

import GlobalSearch from '@/Components/GlobalSearch.vue'
import { router, Link } from '@inertiajs/vue3';

const navigation = [
            { name: 'Dashboard', href: route('dashboard'), current: route().current('dashboard') },
            { name: 'Trips', href: route('trips.index'), current: route().current('rips.index') },
            { name: 'Tour Guides', href: route('tour-guide'), current: route().current('tour-guide') },
            { name: 'Rental Cars', href: route('rental-car'), current: route().current('rental-car') }
        ]

const userNavigation = [
    { name: 'Your profile', href: route('profile.edit') }
]

const leaveImpersonation = () => {
    const currentPage = route().current()
    router.post(route('users.leave-impersonation'), {}, {
        onSuccess: () => {
            // if we were already on the buildings index page then reload the page to bring in a fresh list of buildings
            if (currentPage === 'clients.index') {
                location.reload()
            }
        }
    })
}
</script>
