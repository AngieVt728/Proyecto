<script setup>
import Form from "@/Components/Cards/FormCard.vue";
import Input from "@/Components/Inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const form = useForm({
    exit_date: "",
    quantity: "",
    raw_material_id: "",
});

const handleSubmit = () => {
    form.post(route("outflows.store"), {
        onSuccess: () => toast.success("Salida creado"),
        onError: (errors) =>
            Object.values(errors).forEach((message) => {
                toast.error(message);
            }),
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
                    :error="form.errors.exit_date"
                    type="date"
                />
                <Input
                    id="quantity"
                    label-text="Cantidad"
                    v-model="form.quantity"
                    :error="form.errors.quantity"
                    type="number"
                />
                <Input
                    id="raw_material_id"
                    label-text="ID de la Materia Prima"
                    v-model="form.raw_material_id"
                    :error="form.errors.raw_material_id"
                    type="number"
                />
            </div>
        </Form>
    </authenticated-layout>
</template>
