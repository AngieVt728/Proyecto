<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from 'vue';

const formData = ref({
  name: 'Nombre del Cliente',
  address: 'Dirección del Punto de Venta',
  idCard: '123456789',
  email: 'correo@example.com',
  username: 'usuario123',
  password: '********',
  photoUrl: 'src/assets/logo.svg' // URL predeterminada para la foto del cliente
});

// Manejar la subida de archivos (foto)
const handleFileUpload = (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    formData.value.photoUrl = reader.result;
  };
  reader.readAsDataURL(file);
};

// Botón de Edición
const editProfile = () => {
  // Aquí puedes implementar la lógica para editar los datos del perfil
  console.log('Editar perfil');
};

// Enviar el formulario
const submitForm = () => {
  // Aquí puedes enviar los datos del formulario a tu servidor
  console.log(formData.value);
};
</script>

<template>
  <home-layout>
    <Head title="Perfil" />
    <div class="max-w-lg mx-auto bg-indigo-100 p-8 rounded-lg shadow-md">
      <!-- Espacio para mostrar la foto -->
      <div class="flex items-center justify-center mb-4">
        <img :src="formData.photoUrl" alt="Foto" class="w-14 h-14 rounded-full mb-2 border-2 border-indigo-400">
      </div>

      <h2 class="text-2xl font-bold mb-4 text-indigo-600">Datos del Cliente</h2>

      <!-- Formulario -->
      <form @submit.prevent="submitForm">

        <!-- Nombre -->
        <div class="mb-4">
          <label for="name" class="block font-medium text-gray-700">Nombre</label>
          <input type="text" id="name" v-model="formData.name" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Dirección del Punto de Venta -->
        <div class="mb-4">
          <label for="address" class="block font-medium text-gray-700">Dirección del Punto de Venta</label>
          <input type="text" id="address" v-model="formData.address" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Carnet de Identidad -->
        <div class="mb-4">
          <label for="idCard" class="block font-medium text-gray-700">Carnet de Identidad</label>
          <input type="text" id="idCard" v-model="formData.idCard" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-4">
          <label for="email" class="block font-medium text-gray-700">Correo Electrónico</label>
          <input type="email" id="email" v-model="formData.email" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Usuario -->
        <div class="mb-4">
          <label for="username" class="block font-medium text-gray-700">Usuario</label>
          <input type="text" id="username" v-model="formData.username" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
          <label for="password" class="block font-medium text-gray-700">Contraseña</label>
          <input type="password" id="password" v-model="formData.password" class="form-input mt-1 block w-full border-2 border-indigo-400 rounded focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Botón de Edición -->
        <div class="flex justify-end">
          <button type="button" @click="editProfile" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded mr-2">Editar</button>

