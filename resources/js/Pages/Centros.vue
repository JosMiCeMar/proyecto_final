<script setup>
import Base from '@/Layouts/Base.vue';
import CenterContainer from "@/Components/centros_components/CenterContainer.vue";
import Title from "@/Components/Title.vue";
const titulo='Centros Asociados';

defineProps({
    centros: {
        type: Array,
        required: true,
    },
});

</script>

<template>
  <Base :titulo="titulo">
    <Title value="Nuestros Centros Asociados" subText="Estos son los centros que ya pertenecen a la familia de Mímate" />
      <CenterContainer :centros="centros"/>
 </Base>
</template>