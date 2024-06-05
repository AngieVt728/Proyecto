<script setup>
import AddButton from "@/Components/Buttons/AddButton.vue";
import Search from "@/Components/Inputs/Search.vue";
import Action from "@/Components/Tables/Action.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import { format } from "@formkit/tempo";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

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
                typeof value.name === "string" &&
                typeof value.route === "string"
            );
        },
    },
});

const search = ref(props.filters.search ?? "");

watch(search, (value) => {
    if (value != "") {
        router.get(
            `/${props.add?.route}`,
            { search: value },
            { preserveState: true, replace: true }
        );
    } else {
        router.get(`/${props.add?.route}`);
    }
});

const action = (data) => {
    emit("action", data);
};

const reset = () => {
    search.value = "";
    router.get(`/${props.add?.route}`);
};
</script>

<template>
    <div>
        <div
            class="w-full flex items-center justify-between flex-wrap gap-2 mb-4"
        >
            <Search v-model="search" @reset="reset" />
            <add-button v-if="add" :href="route(`${add?.route}.create`)">
                Agregar {{ props.add?.name.toLowerCase() }}
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
                                :class="{
                                    'rounded-tl': index === 0,
                                    'rounded-tr':
                                        index === columns.length - 1 &&
                                        options.length === 0,
                                }"
                                scope="col"
                            >
                                {{ column.label }}
                            </th>
                            <th
                                class="px-6 py-3 text-nowrap truncate max-w-28 rounded-tr"
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
