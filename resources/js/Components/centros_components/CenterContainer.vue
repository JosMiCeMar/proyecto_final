<template>
    <div class="flex flex-wrap gap-10 m-7 justify-around">
        <CenterCard v-for="centro in centros"
            :nombre="centro.nombre"
            :localidad="centro.localidad"
            :provincia="centro.provincia"
            :direccion="centro.direccion"
            :telefono="centro.telefono"
            :mapLink="centro.ubicacion"
            :email="centro.email"
            :web="centro.web"
        />
    </div>
</template>
<script setup>
import CenterCard from "@/Components/centros_components/CenterCard.vue";
defineProps({
    centros: {
        type: Array,
        required: true,
    },
});
</script>
