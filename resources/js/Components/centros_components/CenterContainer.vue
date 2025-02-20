<template>
    <section class="mt-5 flex flex-col justify-center w-full items-center gap-10 pt-4 pb-10 px-5">
    <article
        v-for="(group, province) in groupedCentros"
        :key="province"
        class="flex flex-col w-full bg-gradient-to-tr from-lavender-dark to-skyblue-dark p-5 rounded-md shadow-md"
    >
        <h2
            class="text-center text-3xl uppercase mb-3 text-white border-b-2 border-white"
        >
            {{ province }}
        </h2>
        <div class="flex flex-wrap gap-10 justify-around">
            <CenterCard
                v-for="centro in group"
                :key="centro.nombre"
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
    </article>
</section>
</template>

<script setup>
import CenterCard from "@/Components/centros_components/CenterCard.vue";
import { computed } from "vue";


const props = defineProps({
    centros: {
        type: Array,
        required: true,
    },
});

// Agrupar los centros por provincia
const groupedCentros = computed(() => {
    const grouped = {};
    props.centros.forEach((centro) => {
        if (!grouped[centro.provincia]) {
            grouped[centro.provincia] = [];
        }
        grouped[centro.provincia].push(centro);
    });
    return grouped;
});
</script>
