<script setup>
import Dropdown from "@/Components/dropdowns/Dropdown.vue";
import DropdownTable from "@/Components/dropdowns/DropdownTable.vue";
import { format } from "@formkit/tempo";
import { computed, ref } from "vue";

const emit = defineEmits(["action"]);
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
});

const currentPage = ref(1);
const itemsPerPage = ref(10);
const totalPages = computed(() => {
    return Math.ceil(props.items.length / itemsPerPage.value);
});
const itemsDisplay = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return props.items.slice(start, end);
});

function action(data) {
    emit("action", data);
}
</script>

<template>
    <div class="py-4 overflow-x-auto">
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            v-for="column in columns"
                            :key="column.key"
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200"
                        >
                            {{ column.label }}
                        </th>
                        <th
                            v-if="options.length > 0"
                            class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200"
                        >
                            <span>Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in itemsDisplay" :key="item.id">
                        <td
                            class="px-5 py-3 text-xs bg-white border-b border-gray-200"
                            v-for="column in columns"
                            :key="column.key"
                        >
                            <span
                                v-if="column.check"
                                class="flex justify-center"
                            >
                                <span
                                    class="rounded-full py-1 px-1"
                                    :class="[
                                        item[column.key]
                                            ? 'text-green-600'
                                            : 'text-red-600',
                                    ]"
                                >
                                    <v-icon
                                        :name="
                                            item[column.key]
                                                ? 'hi-solid-check-circle'
                                                : 'hi-solid-x-circle'
                                        "
                                        scale="1.5"
                                /></span>
                            </span>
                            <span v-else-if="column.color">
                                <span
                                    class="rounded-full py-1 px-3"
                                    :style="{
                                        backgroundColor: item[column.key],
                                    }"
                                ></span>
                            </span>
                            <span v-else-if="column.date">
                                {{
                                    format({
                                        date: item[column.key],
                                        format: "YYYY-MM-DD HH:mm:ss",
                                        tz: "America/La_Paz",
                                    })
                                }}
                            </span>
                            <span
                                v-else-if="column.status"
                                class="flex justify-center"
                            >
                                <span
                                    class="rounded-full py-1 px-1"
                                    :class="[
                                        item[column.key] == 1
                                            ? 'text-green-600'
                                            : 'text-red-600',
                                    ]"
                                >
                                    <v-icon
                                        :name="
                                            item[column.key] == 1
                                                ? 'hi-solid-check-circle'
                                                : 'hi-solid-x-circle'
                                        "
                                        scale="1.5"
                                /></span>
                            </span>
                            <span v-else>{{ item[column.key] }}</span>
                        </td>
                        <td
                            v-if="options.length > 0"
                            class="px-5 py-3 text-xs bg-white border-b border-gray-200"
                        >
                            <DropdownTable
                                :options="options"
                                @emit="emit"
                                :id="item.id"
                            />
                            <Dropdown>
                                <template v-slot:icon>
                                    <div>
                                        <button
                                            type="button"
                                            class="flex text-sm rounded-full"
                                        >
                                            <v-icon
                                                name="hi-solid-dots-vertical"
                                                class="w-6 h-6 rounded-full text-gray-700 p-1"
                                            />
                                        </button>
                                    </div>
                                </template>
                                <div
                                    class="z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-md shadow-xl"
                                >
                                    <ul class="py-1 text-left" role="none">
                                        <li
                                            v-for="(option, index) in options"
                                            :key="index"
                                        >
                                            <span
                                                class="block px-4 py-2 cursor-pointer text-xs text-gray-700 hover:bg-indigo-600 hover:text-white"
                                                @click="
                                                    action({
                                                        action: option.id,
                                                        id: item.id,
                                                    })
                                                "
                                                ><v-icon
                                                    :name="option.icon"
                                                />{{ option.name }}</span
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </Dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div
        v-if="itemsDisplay.length === 0"
        class="w-full bg-gray-100 rounded-lg p-3"
    >
        <p class="text-gray-500 text-center">No hay datos para mostrar.</p>
    </div>
    <nav
        v-else
        class="flex flex-wrap items-center lg:flex-row justify-center lg:justify-between gap-2 p-5"
    >
        <div>
            <span class="text-sm text-gray-900"
                >Página
                <span class="font-semibold">{{ currentPage }}</span>
                de
                <span class="font-semibold">{{ totalPages }}</span></span
            >
        </div>
        <div>
            <button
                class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-300 rounded-l hover:bg-gray-400"
                @click="currentPage--"
                :disabled="currentPage === 1"
                type="button"
            >
                Anterior
            </button>
            <button
                class="px-4 py-2 text-sm font-semibold text-gray-800 bg-gray-300 rounded-r hover:bg-gray-400"
                @click="currentPage++"
                :disabled="currentPage === totalPages"
                type="button"
            >
                Siguiente
            </button>
        </div>
        <div>
            <label
                for="itemsPerPage"
                class="text-sm text-semibold text-gray-900 mr-2"
                >Filas por pagina</label
            >
            <select
                name="itemsPerPage"
                v-model.number="itemsPerPage"
                class="border-gray-200 rounded-md text-sm focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            >
                <option selected value="10">10</option>
                <option value="20">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </nav>
</template>
