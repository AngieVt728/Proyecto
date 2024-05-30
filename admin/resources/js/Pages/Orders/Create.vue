<script setup>
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const form = useForm({
    detail: "",
    order_date: "",
    deliver_date: "",
    customer_id: "",
});

const handleSubmit = () => {
    form.post(route("orders.store"), {
        onSuccess: () => toast.success("Pedido creado"),
        onError: (errors) =>
            Object.values(errors).forEach((message) => {
                toast.error(message);
            }),
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
                    :error="form.errors.detail"
                    type="text"
                />
                <Input
                    id="order_date"
                    label-text="Fecha del Pedido"
                    v-model="form.order_date"
                    :error="form.errors.order_date"
                    type="date"
                />
                <Input
                    id="delivery_deadline"
                    label-text="Fecha de Entrega"
                    v-model="form.deliver_date"
                    :error="form.errors.deliver_date"
                    type="date"
                />
                <Input
                    id="customer_id"
                    label-text="ID del Cliente"
                    v-model="form.customer_id"
                    :error="form.errors.customer_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
