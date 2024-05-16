<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Select from "@/Components/inputs/Select.vue";
import { useGeolocation } from "@/Composables/useGeolocation";
import { computed, onMounted, ref } from "vue";
import { Loader } from "@googlemaps/js-api-loader";

const MAPS_API_KEY = import.meta.env.VITE_MAPS_API_KEY;
const props = defineProps(["customers"]);
const { coords } = useGeolocation();
const currPos = computed(() => ({
    lat: coords.value.latitude,
    lng: coords.value.longitude,
}));
const loader = new Loader({
    apiKey: MAPS_API_KEY,
    version: "weekly",
});
const mapDiv = ref(null);
const form = useForm({
    name: "",
    nit: "",
    description: "",
    address: "",
    lat: "",
    lng: "",
    customer_id: "",
});

const handleSubmit = () => {
    form.post(route("retail-outlets.store"), {});
};

onMounted(async () => {
    const { Map } = await loader.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    let map = new Map(mapDiv.value, {
        center: currPos.value,
        zoom: 15,
        mapId: "DEMO_MAP_ID",
    });
    const marker = new AdvancedMarkerElement({
        map: map,
        position: currPos.value,
    });
});
</script>

<template>
    <Head title="Crear nuevo punto de venta" />
    <authenticated-layout>
        <Form title="Punto de Venta" @handle-submit="handleSubmit">
            {{ currPos }}
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                {{ form.customer_id }}
                <Select
                    id="customer_id"
                    label-text="Propietario"
                    v-model="form.customer_id"
                    :options="customers"
                    :error="form.errors.customer_id || ''"
                    name="full_name"
                />
                <Input
                    id="name"
                    label-text="Razón social"
                    v-model="form.name"
                    :error="form.errors.name"
                    type="text"
                /><Input
                    id="nit"
                    label-text="NIT"
                    v-model="form.nit"
                    :error="form.errors.nit"
                    type="text"
                />
                <Input
                    id="description"
                    label-text="Descripción"
                    v-model="form.description"
                    :error="form.errors.description"
                    type="text"
                />
            </div>
            <div class="grid grid-cols-1 gap-6 mt-4">
                <Input
                    id="address"
                    label-text="Dirección"
                    v-model="form.address"
                    :error="form.errors.address"
                    type="text"
                />
            </div>
            <div class="p-4">
                <h2 class="font-semibold mb-4 text-gray-700">
                    Busque la ubicación del punto de venta
                </h2>
                <div class="mx-24">
                    <div ref="mapDiv" style="width: 100%; height: 400px" />
                </div>
            </div>
        </Form>
    </authenticated-layout>
</template>
