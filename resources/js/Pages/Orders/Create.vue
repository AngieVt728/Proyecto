<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    detail: "",
    order_date: "",
    delivery_deadline: "",
    customer_id: "",
});

const handleSubmit = () => {
    form.post(route("pedidos.store"), {
        onFinish: () =>
            form.reset(
                "detail",
                "order_date",
                "delivery_deadline",
                "customer_id"
            ),
    });
};
</script>

<template>
    <Head title="Crear nuevo pedido" />
    <authenticated-layout>
        <Form title="Pedido" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="detail"
                    label-text="Detalle"
                    v-model="form.detail"
                    type="text"
                />
                <Input
                    id="order_date"
                    label-text="Fecha del Pedido"
                    v-model="form.order_date"
                    type="date"
                />
                <Input
                    id="delivery_deadline"
                    label-text="Fecha de Entrega"
                    v-model="form.delivery_deadline"
                    type="date"
                />
                <Input
                    id="customer_id"
                    label-text="ID del Cliente"
                    v-model="form.customer_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
