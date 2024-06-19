<script setup lang="ts">
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps<{
    id: String;
    labelText: String;
    checked: boolean;
    value?: any;
}>();

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>

<template>
    <input
        :id="id"
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="text-indigo-600 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
    />
    <label :for="id" class="w-full py-3 ml-2 text-sm text-gray-700">
        {{ labelText }}
    </label>
</template>
