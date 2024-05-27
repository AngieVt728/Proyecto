<template>
    <div class="flex justify-between items-center flex-wrap p-4">
        <p class="text-sm text-gray-700">
            Página
            <span class="font-semibold text-gray-900">{{ currentPage }}</span>
            de <span class="font-semibold text-gray-900">{{ lastPage }}</span
            >, se muestra
            <span class="font-semibold text-gray-900">{{ perPage }}</span>
            elementos por página.
        </p>
        <p class="text-sm text-gray-700">
            Mostrando del
            <span class="font-semibold text-gray-900">{{ from }}</span> al
            <span class="font-semibold text-gray-900">{{ to }}</span> de un
            total de
            <span class="font-semibold text-gray-900">{{ total }}</span>
            resultados.
        </p>
    </div>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap justify-start px-4 pb-4">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="mb-1 mr-1 px-3 py-2 text-gray-400 text-sm leading-4 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :key="`link-${key}`"
                    class="mb-1 mr-1 px-3 py-2 text-gray-500 focus:text-indigo-500 text-sm leading-4 hover:text-gray-800 hover:bg-white border focus:border-indigo-500 rounded"
                    :class="{ 'bg-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
    },
    perPage: {
        type: Number,
    },
    currentPage: {
        type: Number,
    },
    lastPage: {
        type: Number,
    },
    from: {
        type: Number,
    },
    to: {
        type: Number,
    },
    total: {
        type: Number,
    },
});
</script>
