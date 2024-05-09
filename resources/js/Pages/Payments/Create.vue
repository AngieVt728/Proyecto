<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    payment_date: "",
    payment_balance: "",
    details: "",
    order_id: "",
});

const handleSubmit = () => {
    form.post(route("pagos.store"), {
        onFinish: () =>
            form.reset(
                "payment_date",
                "payment_balance",
                "details",
                "order_id",
            ),
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
                    type="date"
                />
                <Input
                    id="payment_balance"
                    label-text="Balance del Pago"
                    v-model="form.payment_balance"
                    type="number"
                />
                <Input
                    id="details"
                    label-text="Detalles"
                    v-model="form.details"
                    type="text"
                />
                <Input
                    id="order_id"
                    label-text="ID del Pedido"
                    v-model="form.order_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
