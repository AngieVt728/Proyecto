<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    supplier_id: "",
});

const handleSubmit = () => {
    form.post(route("materia_prima.store"), {
        onFinish: () =>
            form.reset(
                "name",
                "description",
                "supplier_id"
            ),
    });
};
</script>

<template>
    <Head title="Crear nueva materia prima" />
    <authenticated-layout>
        <Form title="Materia Prima" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="name"
                    label-text="Nombre"
                    v-model="form.name"
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    type="text"
                />
                <Input
                    id="supplier_id"
                    label-text="ID del Proveedor"
                    v-model="form.supplier_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
