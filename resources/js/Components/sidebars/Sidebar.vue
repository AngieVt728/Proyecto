<script setup>
import Anchor from "@/Components/anchors/Anchor.vue";
import AnchorAccordion from "@/Components/anchors/AnchorAccordion.vue";
import Logo from "@/Components/branding/Logo.vue";
import { useSidebar } from "@/Composables/useSidebar";
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
            class="fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
        >
            <Logo :is-login="false" />
            <nav class="mt-10">
                <Anchor
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    icon="hi-solid-chart-pie"
                    name="Panel de control"
                />
                <Anchor
                    :href="route('users.index')"
                    :active="route().current('users.*')"
                    icon="hi-solid-user-group"
                    name="Usuarios"
                />
                <anchor-accordion
                    name="Gestión Comercial"
                    icon="hi-solid-shopping-cart"
                >
                    <Anchor
                        :href="route('customers.index')"
                        :active="route().current('customers.*')"
                        icon="hi-solid-users"
                        name="Clientes"
                    />
                    <Anchor
                        :href="route('retail-outlets.index')"
                        :active="route().current('retail-outlets.*')"
                        icon="hi-solid-map"
                        name="Puntos de Venta"
                    />
                    <Anchor
                        :href="route('orders.index')"
                        :active="route().current('orders.*')"
                        icon="hi-solid-hand"
                        name="Pedidos"
                    />
                    <Anchor
                        :href="route('payments.index')"
                        :active="route().current('payments.index')"
                        icon="hi-solid-currency-dollar"
                        name="Pagos"
                    />
                </anchor-accordion>
                <anchor-accordion name="Inventario Productos" icon="hi-inbox">
                    <Anchor
                        :href="route('products.index')"
                        :active="route().current('products.*')"
                        icon="hi-inbox"
                        name="Productos"
                    />
                    <Anchor
                        :href="route('revenues.index')"
                        :active="route().current('revenues.*')"
                        icon="hi-solid-clipboard-copy"
                        name="Ingresos"
                    />
                    <Anchor
                        :href="route('sales.index')"
                        :active="route().current('sales.*')"
                        icon="hi-solid-clipboard-check"
                        name="Ventas"
                    />
                </anchor-accordion>
                <anchor-accordion
                    name="Inventario Materia Prima"
                    icon="hi-solid-inbox"
                >
                    <Anchor
                        :href="route('suppliers.index')"
                        :active="route().current('suppliers.*')"
                        icon="hi-users"
                        name="Proveedores"
                    />
                    <Anchor
                        :href="route('raw-materials.index')"
                        :active="route().current('raw-materials.*')"
                        icon="hi-solid-inbox"
                        name="Materia Prima"
                    />
                    <Anchor
                        :href="route('entries.index')"
                        :active="route().current('entries.*')"
                        icon="hi-solid-login"
                        name="Entradas"
                    />
                    <Anchor
                        :href="route('outflows.index')"
                        :active="route().current('outflows.*')"
                        icon="hi-solid-logout"
                        name="Salidas"
                    />
                </anchor-accordion>
            </nav>
        </div>
    </div>
</template>

<style scoped>
/* width */
::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #111827;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #030712;
    border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #1f2937;
}
</style>
