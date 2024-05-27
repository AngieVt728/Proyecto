<script setup>
const emit = defineEmits(["action"]);
const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    item: {
        type: Object,
        required: true,
    },
});

const action = (option) => {
    emit("action", {
        action: option.id,
        id: props.item.id,
    });
};
</script>

<template>
    <div>
        <span v-for="(option, index) in options" :key="index">
            <v-icon
                class="cursor-pointer"
                scale="1.25"
                :class="[option.color]"
                :name="option.icon"
                @click="action(option)"
            />
        </span>
    </div>
</template>
