<script setup>
import ButtonAdd from "@/Components/buttons/ButtonAdd.vue";
import CardData from "@/Components/cards/CardData.vue";
import CardStat from "@/Components/cards/CardStat.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    Title,
    Tooltip,
} from "chart.js";
import { Bar, Doughnut, Line, Pie } from "vue-chartjs";
import { Loader } from "@googlemaps/js-api-loader";
import { onMounted, computed, ref } from "vue";
import { useGeolocation } from "@/Composables/useGeolocation";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    PointElement,
    LineElement
);

const props = defineProps([
    "rawMaterials",
    "products",
    "totalProducts",
    "totalOrders",
    "totalSales",
]);

console.log(props.totalProducts, props.totalSales, props.totalOrders);

const MAPS_API_KEY = import.meta.env.VITE_MAPS_API_KEY;
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

const options = {
    responsive: true,
};
const rawMaterialData = {
    labels: props.rawMaterials.map((rawMaterial) => rawMaterial.name),
    datasets: [
        {
            label: "MATERIA PRIMA",
            backgroundColor: props.rawMaterials.map(
                (rawMaterial) => rawMaterial.color
            ),
            data: props.rawMaterials.map((rawMaterial) => rawMaterial.stock),
        },
    ],
};
const productsData = {
    labels: props.products.map((product) => product.name),
    datasets: [
        {
            backgroundColor: props.products.map((product) => product.color),
            data: props.products.map((product) => product.stock),
        },
    ],
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
    <Head title="Panel de control" />

    <authenticated-layout>
        <card-data title="Panel de control">
            <div class="flex flex-wrap -mx-6">
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Productos en stock"
                        :quantity="totalProducts"
                        :icon-bg="'bg-indigo-600'"
                        :icon-name="'hi-inbox'"
                        :route="route('products.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Pedidos registrados hoy"
                        :quantity="totalOrders"
                        :icon-bg="'bg-blue-600'"
                        :icon-name="'hi-solid-hand'"
                        :route="route('orders.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Ventas registradas hoy"
                        :quantity="totalSales"
                        :icon-bg="'bg-pink-600'"
                        :icon-name="'hi-solid-clipboard-check'"
                        :route="route('sales.index')"
                    />
                </div>
            </div>

            <div class="flex justify-center flex-wrap mt-8 gap-6 px-28">
                <div class="w-full rounded-lg shadow-lg p-4">
                    <h2
                        class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                    >
                        Materia Prima Disponible
                    </h2>
                    <Bar
                        id="my-chart-id"
                        :options="options"
                        :data="rawMaterialData"
                    />
                </div>
                <div
                    class="w-full rounded-lg shadow-lg mt-4 h-[500px] flex p-4"
                >
                    <h2
                        class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                    >
                        Productos Disponibles
                    </h2>
                    <Pie :data="productsData" :options="options" />
                </div>
            </div>
            <div class="my-10 mx-20 p-8 rounded-lg shadow-lg">
                <h2
                    class="font-semibold uppercase text-sm text-gray-600 py-4 ml-4"
                >
                    Puntos de venta registrados
                </h2>
                <div ref="mapDiv" style="width: 100%; height: 400px" />
            </div>
        </card-data>
    </authenticated-layout>
</template>
