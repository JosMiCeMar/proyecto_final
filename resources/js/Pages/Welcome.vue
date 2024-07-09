<script setup>
import Base from '@/Layouts/Base.vue';
import Carrusel from '@/Components/public_components/Carrusel.vue';

const titulo='Bienvenid@';
</script>

<template>

  <Base :titulo="titulo">
    <Carrusel />
  </Base>
</template>
