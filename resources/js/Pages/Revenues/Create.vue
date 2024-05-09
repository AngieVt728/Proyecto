<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    description: "",
    revenue_date: "",
    quantity: "",
    product_id: "",
});

const handleSubmit = () => {
    form.post(route("ingresos.store"), {
        onFinish: () =>
            form.reset(
                "description",
                "revenue_date",
                "quantity",
                "product_id"
            ),
    });
};
</script>

<template>
    <Head title="Crear nuevo ingreso" />
    <authenticated-layout>
        <Form title="Ingreso" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    type="text"
                />
                <Input
                    id="revenue_date"
                    label-text="Fecha de Ingreso"
                    v-model="form.revenue_date"
                    type="date"
                />
                <Input
                    id="quantity"
                    label-text="Cantidad"
                    v-model="form.quantity"
                    type="number"
                />
                <Input
                    id="product_id"
                    label-text="ID del Producto"
                    v-model="form.product_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
