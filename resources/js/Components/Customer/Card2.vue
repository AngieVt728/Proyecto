<template>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
      <!-- Muestra solo la descripción -->
      <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">{{ title }}</div>
        <p class="text-gray-700 text-base">
          {{ description }}
        </p>
      </div>
    </div>
  </template>

  <script setup>
  const props = defineProps({
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: true,
    },
  });
  </script>
