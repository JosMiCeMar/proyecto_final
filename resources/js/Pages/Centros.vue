<template>
  <Base titulo="Centros Asociados">
    <img class="w-full h-auto hidden md:block" src="img/recursos/comienza.jpg" alt="impulsa tu negocio">
    <SectionDivisor />
    <MainBox>
    <Title value="Nuestros Centros Asociados" subText="Estos son los centros que ya pertenecen a la familia de Mímate" />
      <CenterContainer :centros="centros"/>
    </MainBox> 
 </Base>
</template>
<script setup>
import Base from '@/Layouts/Base.vue';
import CenterContainer from "@/Components/centros_components/CenterContainer.vue";
import Title from "@/Components/Title.vue";
import MainBox from '@/Components/public_components/MainBox.vue';
import SectionDivisor from '@/Components/public_components/SectionDivisor.vue';


defineProps({
    centros: {
        type: Array,
        required: true,
    },
});

</script>