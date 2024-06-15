<template>
    <div class="relative">
      <div class="overflow-hidden">
        <div class="flex transition-transform" :style="{ transform: `translateX(-${activeIndex * 100}%)` }">
          <div v-for="(picture, index) in pictures" :key="index" class="min-w-full">
            <img :src="picture.src" :alt="picture.alt" class="w-full" />
          </div>
        </div>
      </div>
      <div class="absolute bottom-0 left-0 right-0 flex justify-center p-2">
        <button
          v-for="(picture, index) in pictures"
          :key="index"
          @click="activeIndex = index"
          :class="['indicator', { active: index === activeIndex }]"
          aria-label="Slide indicator"
          class="w-3 h-3 mx-1 rounded-full bg-gray-400"
        ></button>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const props = defineProps({
    pictures: {
      type: Array,
      required: true,
    },
  });

  const activeIndex = ref(0);
  </script>

  <style scoped>
  .indicator.active {
    background-color: gray;
  }
  </style>
