<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    exit_date: "",
    quantity: "",
    raw_material_id: "",
});

const handleSubmit = () => {
    form.post(route("salidas.store"), {
        onFinish: () =>
            form.reset(
                "exit_date",
                "quantity",
                "raw_material_id"
            ),
    });
};
</script>

<template>
    <Head title="Registrar nueva salida" />
    <authenticated-layout>
        <Form title="Salida" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="exit_date"
                    label-text="Fecha de Salida"
                    v-model="form.exit_date"
                    type="date"
                />
                <Input
                    id="quantity"
                    label-text="Cantidad"
                    v-model="form.quantity"
                    type="number"
                />
                <Input
                    id="raw_material_id"
                    label-text="ID de la Materia Prima"
                    v-model="form.raw_material_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
