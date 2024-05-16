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

const employees = 500;
const entries = 700;
const exits = 258;
const lineData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "VENTAS",
            backgroundColor: "#f87979",
            data: [40, 39, 10, 40, 39, 80, 40],
        },
    ],
};

const barData = {
    labels: [
        "Materia Prima 1",
        "Materia Prima 2",
        "Materia Prima 3",
        "Materia Prima 4",
        "Materia Prima 5",
    ],
    datasets: [
        {
            label: "MATERIA PRIMA",
            backgroundColor: "#f87979",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
        },
    ],
};

const doughnutData = {
    labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
        },
    ],
};

const pieData = {
    labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
        },
    ],
};

const options = {
    responsive: true,
};

import { GoogleMap, Marker } from "vue3-google-map";

const center = { lat: 40.689247, lng: -74.044502 };
</script>

<template>
    <Head title="Panel de control" />

    <authenticated-layout>
        <card-data title="Panel de control">
            <div class="flex flex-wrap -mx-6">
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Empleados registrados"
                        :quantity="employees"
                        :icon-bg="'bg-indigo-600'"
                        :icon-name="'hi-solid-user-group'"
                        :route="route('users.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Entradas registradas hoy"
                        :quantity="entries"
                        :icon-bg="'bg-blue-600'"
                        :icon-name="'hi-solid-login'"
                        :route="route('entries.index')"
                    />
                </div>
                <div class="w-full px-6 lg:w-1/3">
                    <card-stat
                        title="Salidas registradas hoy"
                        :quantity="exits"
                        :icon-bg="'bg-pink-600'"
                        :icon-name="'hi-solid-logout'"
                        :route="route('outflows.index')"
                    />
                </div>
            </div>
            <h2>Gestionar Puntos de Venta</h2>
            <div class="flex flex-col justify-between md:flex-row gap-2 w-full">
                <button-add :href="route('retail-outlets.create')"
                    >Crear Ruta</button-add
                >
            </div>
            <GoogleMap
                :api-key="AIzaSyC6zamak9gpkkMDnqoJKYoC7qhH4e4Sx6c"
                style="width: 100%; height: 400px"
                :center="center"
                :zoom="15"
            >
                <Marker :options="{ position: center }" />
            </GoogleMap>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="w-full">
                    <h2>Ventas Mensuales</h2>
                    <Line :data="lineData" :options="options" />
                </div>
                <div class="w-full">
                    <h2>Materia Prima Disponible</h2>
                    <Bar id="my-chart-id" :options="options" :data="barData" />
                </div>
                <div class="w-full">
                    <h2>Productos Disponibles</h2>
                    <Pie :data="pieData" :options="options" />
                </div>
            </div>
        </card-data>
    </authenticated-layout>
</template>
