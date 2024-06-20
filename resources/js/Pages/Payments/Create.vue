<script setup lang="ts">
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { goodDialogs } from "gooddialogs";
import Select from "@/Components/Inputs/Select.vue";
import { format } from "@formkit/tempo";

const props = defineProps<{ orders: Object }>();
const form = useForm({
    payment_date: "",
    payment_balance: "",
    details: "",
    order_id: "",
});

const handleSubmit = () => {
    form.post(route("payments.store"), {
        onSuccess: () =>
            goodDialogs.createNotification("Pago creado con éxito", {
                type: "success",
            }),
        onError: (errors) =>
            goodDialogs.createNotification("No se pudo crear el pago", {
                type: "error",
            }),
    });
};
</script>

<template>
    <authenticated-layout>
        <Head title="Crear nuevo pago" />
        <Form title="Registrar pago" @handle-submit="handleSubmit">
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
                <Select
                    id="role"
                    label-text="Elegir pedido fecha"
                    v-model="form.order_id"
                    :options="orders"
                    :error="form.errors.order_id"
                    name="created_at"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
