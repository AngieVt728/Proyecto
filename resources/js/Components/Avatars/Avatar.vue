<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { getUsername } from "@/Composables/usePage";

const username = getUsername();

const dropdownOpen = ref(false);
</script>

<template>
    <Menu as="div" class="relative inline-block text-left z-50">
        <div>
            <MenuButton
                class="inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
            >
                {{ username }}
                <v-icon
                    class="-mr-1 ml-2 h-5 w-5 text-gray-700 hover:text-indigo-500"
                    name="hi-chevron-down"
                />
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
            >
                <!-- <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <Link
                            :class="[
                                active
                                    ? 'bg-indigo-500 text-white'
                                    : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                            :href="route('profile.about')"
                        >
                            <v-icon class="mr-2 h-5 w-5" name="hi-user" />
                            Perfil de usuario
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <Link
                            :class="[
                                active
                                    ? 'bg-indigo-500 text-white'
                                    : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                            :href="route('profile.edit')"
                        >
                            <v-icon class="mr-2 h-5 w-5" name="hi-pencil" />
                            Modificar perfil
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <Link
                            :class="[
                                active
                                    ? 'bg-indigo-500 text-white'
                                    : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                            :href="route('profile.edit')"
                        >
                            <v-icon class="mr-2 h-5 w-5" name="hi-key" />
                            Cambiar contraseña
                        </Link>
                    </MenuItem>
                </div> -->
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <Link
                            :class="[
                                active
                                    ? 'bg-indigo-500 text-white'
                                    : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            <v-icon class="mr-2 h-5 w-5" name="hi-logout" />
                            Cerrar sesión
                        </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>
