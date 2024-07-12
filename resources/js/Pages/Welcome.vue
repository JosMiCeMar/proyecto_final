<script setup>
import Base from '@/Layouts/Base.vue';
import Carrusel from '@/Components/public_components/Carrusel.vue';
import Title from '@/Components/Title.vue';

const titulo='Bienvenid@';
</script>

<template>

  <Base :titulo="titulo">
    <Title value="Bienvenid@s a Mímate" />
    <Carrusel />
  </Base>
</template>
