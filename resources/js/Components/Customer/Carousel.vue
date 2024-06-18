<template>
    <div class="carousel">
      <div class="carousel-images">
        <img :src="currentImage.src" :alt="currentImage.alt" />
      </div>
      <div class="carousel-controls">
        <button @click="prevImage">Prev</button>
        <button @click="nextImage">Next</button>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, watchEffect, onMounted, onUnmounted } from 'vue';

  interface Picture {
    src: string;
    alt: string;
  }

  const props = defineProps<{ pictures: Picture[] }>();

  const currentIndex = ref(0);
  const currentImage = ref(props.pictures[currentIndex.value]);

  const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % props.pictures.length;
  };

  const prevImage = () => {
    currentIndex.value = (currentIndex.value - 1 + props.pictures.length) % props.pictures.length;
  };

  watchEffect(() => {
    currentImage.value = props.pictures[currentIndex.value];
  });

  let interval: number;

  onMounted(() => {
    interval = setInterval(nextImage, 3000);
  });

  onUnmounted(() => {
    clearInterval(interval);
  });
  </script>

  <style scoped>
  .carousel {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .carousel-images img {
    max-width: 100%;
    height: auto;
  }

  .carousel-controls {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }
  </style>
