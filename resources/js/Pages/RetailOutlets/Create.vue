<script setup>
import Form from "@/Components/cards/CardForm.vue";
import Input from "@/Components/inputs/Input.vue";
import Select from "@/Components/inputs/Select.vue";
import { useGeolocation } from "@/Composables/useGeolocation";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Loader } from "@googlemaps/js-api-loader";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import { toast } from "vue3-toastify";

const props = defineProps(["customers", "retailOutlet"]);
const form = useForm({
    name: props.retailOutlet?.name ?? "",
    nit: props.retailOutlet?.nit ?? "",
    description: props.retailOutlet?.description ?? "",
    address: props.retailOutlet?.address ?? "",
    lat: props.retailOutlet?.lat ?? "",
    lng: props.retailOutlet?.lng ?? "",
    customer_id: props.retailOutlet?.customer_id ?? "",
});

const MAPS_API_KEY = import.meta.env.VITE_MAPS_API_KEY;
const { coords } = useGeolocation();
const currPos = computed(() => ({
    lat: coords.value.latitude,
    lng: coords.value.longitude,
}));
const roPos = computed(() => ({
    lat: parseFloat(props.retailOutlet?.lat),
    lng: parseFloat(props.retailOutlet?.lng),
}));
const loader = new Loader({
    apiKey: MAPS_API_KEY,
    version: "weekly",
});
const mapDiv = ref(null);

const handleSubmit = () => {
    if (props.retailOutlet?.id)
        form.patch(
            route("retail-outlets.update", { id: props.retailOutlet.id }),
            {
                onSuccess: () => toast.success("Punto de venta actualizado"),
                onError: (errors) =>
                    Object.values(errors).forEach((message) => {
                        toast.error(message);
                    }),
            }
        );
    else
        form.post(route("retail-outlets.store"), {
            onSuccess: () => toast.success("Punto de venta registrado"),
            onError: (errors) =>
                Object.values(errors).forEach((message) => {
                    toast.error(message);
                }),
        });
};

onMounted(async () => {
    const { Map, InfoWindow } = await loader.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    const map = new Map(mapDiv.value, {
        center: props.retailOutlet ? roPos.value : currPos.value,
        zoom: 15,
        mapId: "DEMO_MAP_ID",
    });
    const infoWindow = new InfoWindow();
    const draggableMarker = new AdvancedMarkerElement({
        map,
        position: props.retailOutlet ? roPos.value : currPos.value,
        gmpDraggable: true,
    });

    draggableMarker.addListener("dragend", (event) => {
        form.lat = event.latLng.lat();
        form.lng = event.latLng.lng();

        infoWindow.close();
        infoWindow.setContent(`Posición actual: ${form.lat}, ${form.lng}`);
        infoWindow.open(draggableMarker.map, draggableMarker);
    });
});
</script>

<template>
    <Head title="Crear nuevo punto de venta" />
    <authenticated-layout>
        <Form title="Punto de Venta" @handle-submit="handleSubmit">
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Select
                    id="customer_id"
                    label-text="Propietario"
                    v-model="form.customer_id"
                    :options="customers"
                    :error="form.errors.customer_id || ''"
                    name="full_name"
                    :disabled="retailOutlet?.customer_id ? true : false"
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
                    :disabled="retailOutlet?.nit ? true : false"
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
            <div class="grid grid-cols-1 gap-6 mt-4 lg:grid-cols-2">
                <Input
                    id="lat"
                    label-text="Latitud"
                    v-model="form.lat"
                    :error="form.errors.lat"
                    type="text"
                    disabled
                />
                <Input
                    id="lng"
                    label-text="Longitud"
                    v-model="form.lng"
                    :error="form.errors.lng"
                    type="text"
                    disabled
                />
            </div>
            <h2 class="font-semibold mb-4 text-gray-700">
                Busque la ubicación del punto de venta
            </h2>
            <div class="shadow-lg mb-4">
                <div ref="mapDiv" style="width: 100%; height: 400px" />
            </div>
        </Form>
    </authenticated-layout>
</template>
