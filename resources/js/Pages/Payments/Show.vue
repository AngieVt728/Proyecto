<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Select from "@/Components/Inputs/Select.vue";

const props = defineProps<{ payment: Object; orders: Object }>();

const handleSubmit = () => {
    router(route("payments.index"));
};
</script>

<template>
    <Head title="Crear nuevo pago" />
    <authenticated-layout>
        <Form title="Pago" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="payment_date"
                    label-text="Fecha del Pago"
                    v-model="payment.payment_date"
                    type="date"
                    :disabled="true"
                />
                <Input
                    id="payment_balance"
                    label-text="Balance del Pago"
                    v-model="payment.payment_balance"
                    type="number"
                    :disabled="true"
                />
                <Input
                    id="details"
                    label-text="Detalles"
                    v-model="payment.details"
                    type="text"
                    :disabled="true"
                />
                <Select
                    id="role"
                    label-text="Pedido fecha"
                    v-model="payment.order_id"
                    :options="orders"
                    name="created_at"
                    :disabled="true"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
