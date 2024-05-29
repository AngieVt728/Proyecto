<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/inputs/Input.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    entry_date: "",
    quantity: "",
    raw_material_id: "",
});

const handleSubmit = () => {
    form.post(route("entradas.store"), {
        onFinish: () => form.reset("entry_date", "quantity", "raw_material_id"),
    });
};
</script>

<template>
    <Head title="Registrar nueva entrada" />
    <authenticated-layout>
        <Form title="Entrada" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="entry_date"
                    label-text="Fecha de Entrada"
                    v-model="form.entry_date"
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
