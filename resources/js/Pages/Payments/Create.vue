<script setup>
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const form = useForm({
    payment_date: "",
    payment_balance: "",
    details: "",
    order_id: "",
});

const handleSubmit = () => {
    form.post(route("payments.store"), {
        onSuccess: () => toast.success("Pago creado"),
        onError: (errors) =>
            Object.values(errors).forEach((message) => {
                toast.error(message);
            }),
    });
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
                    v-model="form.payment_date"
                    :error="form.errors.payment_date"
                    type="date"
                />
                <Input
                    id="payment_balance"
                    label-text="Balance del Pago"
                    v-model="form.payment_balance"
                    :error="form.errors.payment_balance"
                    type="number"
                />
                <Input
                    id="details"
                    label-text="Detalles"
                    v-model="form.details"
                    :error="form.errors.details"
                    type="text"
                />
                <Input
                    id="order_id"
                    label-text="ID del Pedido"
                    v-model="form.order_id"
                    :error="form.errors.order_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
