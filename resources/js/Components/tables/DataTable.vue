<script setup>
import AddButton from "@/Components/Buttons/AddButton.vue";
import Action from "@/Components/Tables/Action.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import { format } from "@formkit/tempo";

const emit = defineEmits(["action"]);
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    content: {
        type: Object,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
    add: {
        type: Object,
        required: false,
        validator(value) {
            return (
                typeof value.create === "string" &&
                typeof value.route === "string"
            );
        },
    },
});

const action = (data) => {
    emit("action", data);
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-4">
            <add-button v-if="add" :href="add?.route">
                Agregar {{ props.add?.create }}
            </add-button>
        </div>

        <div class="bg-white rounded shadow-md">
            <div class="relative overflow-x-auto">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500"
                >
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-nowrap truncate max-w-28"
                                v-for="(column, index) in columns"
                                :key="column.key"
                                :class="
                                    index === 0
                                        ? 'rounded-tl-lg'
                                        : index === columns.length - 1 &&
                                          options.length === 0
                                        ? 'rounded-tr-lg'
                                        : ''
                                "
                                scope="col"
                            >
                                {{ column.label }}
                            </th>
                            <th
                                class="px-6 py-3 text-nowrap truncate max-w-28 rounded-tr-lg"
                                v-if="options.length > 0"
                            >
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-white border-b hover:bg-gray-50"
                            v-for="item in content.data"
                            :key="item.id"
                        >
                            <td
                                v-for="column in columns"
                                :key="column.key"
                                :class="{
                                    'px-6 py-4 text-nowrap max-w-28': true,
                                    truncate: column.truncate ?? false,
                                }"
                            >
                                <span v-if="column.verify">
                                    <v-icon
                                        :class="
                                            item[column.verify]
                                                ? 'text-green-500'
                                                : 'text-red-500'
                                        "
                                        :name="
                                            item[column.verify]
                                                ? 'hi-check'
                                                : 'hi-x'
                                        "
                                    />
                                    {{ item[column.key] }}
                                </span>
                                <span v-else-if="column.date">
                                    {{
                                        format({
                                            date: item[column.key],
                                            format: "DD/MM/YYYY",
                                            tz: "America/La_Paz",
                                        })
                                    }}
                                </span>
                                <span v-else>
                                    {{ item[column.key] }}
                                </span>
                            </td>
                            <td
                                class="flex justify-between items-center px-4 py-3 text-nowrap truncate max-w-28"
                                v-if="options.length > 0"
                            >
                                <Action
                                    :options="options"
                                    :item="item"
                                    @action="action"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination
                :links="content.links"
                :current-page="content.current_page"
                :per-page="content.per_page"
                :last-page="content.last_page"
                :from="content.from"
                :to="content.to"
                :total="content.total"
            />
        </div>
    </div>
</template>

<style scoped>
::-webkit-scrollbar {
    height: 10px;
}

::-webkit-scrollbar-track {
    background: #2d3748;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e0;
}

::-webkit-scrollbar-thumb:hover {
    background: #718096;
}
</style>
