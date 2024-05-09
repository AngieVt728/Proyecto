<script setup>
import Anchor from "@/Components/anchors/Anchor.vue";
import Logo from "@/Components/branding/Logo.vue";
import { useSidebar } from "@/Composables/useSidebar";
import AnchorAccordion from "@/Components/anchors/AnchorAccordion.vue";
const { isOpen } = useSidebar();
</script>

<template>
    <div class="flex">
        <div
            :class="isOpen ? 'block' : 'hidden'"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"
            @click="isOpen = false"
        />
        <div
            :class="
                isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'
            "
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
        >
            <router-link to="/">
                <Logo
                    :size="'w-12 h-12'"
                    :text-style="'mx-2 text-xl text-white'"
                    :margin-top="'mt-8'"
                />
            </router-link>
            <nav class="mt-10">
                <Anchor
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    icon="hi-solid-chart-pie"
                    name="Panel de control"
                />
                <Anchor
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                    icon="hi-solid-user-group"
                    name="Usuarios"
                />
                <Anchor
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    icon="hi-solid-users"
                    name="Clientes"
                />
                <Anchor
                    :href="route('suppliers.index')"
                    :active="route().current('suppliers.index')"
                    icon="hi-users"
                    name="Proveedores"
                />
                <Anchor
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                    icon="hi-solid-map"
                    name="Puntos de Venta"
                />
                <anchor-accordion name="Inventario Productos" icon="hi-inbox">
                    <Anchor
                        :href="route('users.index')"
                        :active="route().current('users.index')"
                        icon="hi-inbox"
                        name="Productos"
                    />
                    <Anchor
                        :href="route('users.index')"
                        :active="route().current('users.index')"
                        icon="hi-solid-clipboard-copy"
                        name="Ingresos"
                    />
                    <Anchor
                        :href="route('users.index')"
                        :active="route().current('users.index')"
                        icon="hi-solid-clipboard-check"
                        name="Ventas"
                    />
                </anchor-accordion>
                <anchor-accordion
                    name="Inventario Materia Prima"
                    icon="hi-solid-inbox"
                >
                    <Anchor
                        :href="route('raw-materials.index')"
                        :active="route().current('raw-materials.index')"
                        icon="hi-solid-inbox"
                        name="Materia Prima"
                    />
                    <Anchor
                        :href="route('users.index')"
                        :active="route().current('users.index')"
                        icon="hi-solid-login"
                        name="Entradas"
                    />
                    <Anchor
                        :href="route('users.index')"
                        :active="route().current('users.index')"
                        icon="hi-solid-logout"
                        name="Salidas"
                    />
                </anchor-accordion>
                <Anchor
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                    icon="hi-solid-hand"
                    name="Pedidos"
                />
                <Anchor
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                    icon="hi-solid-currency-dollar"
                    name="Pagos"
                />
            </nav>
        </div>
    </div>
</template>
