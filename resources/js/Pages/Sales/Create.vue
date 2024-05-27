<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    description: "",
    quantity: "",
    product_id: "",
    price: "",
    retail_outlet_id: "",
});

const handleSubmit = () => {
    form.post(route("ventas.store"), {
        onFinish: () =>
            form.reset(
                "description",
                "quantity",
                "product_id",
                "price",
                "retail_outlet_id"
            ),
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
                    type="text"
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
                <Input
                    id="price"
                    label-text="Precio total"
                    v-model="form.price"
                    type="number"
                />
                <Input
                    id="retail_outlet_id"
                    label-text="Punto de Venta"
                    v-model="form.retail_outlet_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
