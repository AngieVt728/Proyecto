<script setup>
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const form = useForm({
    quantity: "",
    total_price: "",
    description: "",
    product_id: "",
});

const handleSubmit = () => {
    form.post(route("sales.store"), {
        onSuccess: () => toast.success("Venta creado"),
        onError: (errors) =>
            Object.values(errors).forEach((message) => {
                toast.error(message);
            }),
    });
};
</script>

<template>
    <Head title="Crear nueva venta" />
    <authenticated-layout>
        <Form title="Venta" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    :error="form.errors.description"
                    type="text"
                />
                <Input
                    id="quantity"
                    label-text="Cantidad"
                    v-model="form.quantity"
                    :error="form.errors.quantity"
                    type="number"
                />
                <Input
                    id="product_id"
                    label-text="ID del Producto"
                    v-model="form.product_id"
                    :error="form.errors.product_id"
                    type="number"
                />
                <Input
                    id="price"
                    label-text="Precio total"
                    v-model="form.total_price"
                    :error="form.errors.total_price"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
