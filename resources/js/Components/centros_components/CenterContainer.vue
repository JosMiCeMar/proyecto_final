<template>
    <section class="mt-5">
    <section
        v-for="(group, province) in groupedCentros"
        :key="province"
    >
        <h2
            class="text-center text-2xl uppercase font-bold mt-3 texto-degradado"
        >
            {{ province }}
        </h2>
        <SectionDivisor/>
        <div class="flex flex-wrap gap-10 m-7 justify-around">
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
    </section>
</section>
</template>

<script setup>
import CenterCard from "@/Components/centros_components/CenterCard.vue";
import { computed } from "vue";
import SectionDivisor from "../public_components/SectionDivisor.vue";

const props = defineProps({
    centros: {
        type: Array,
        required: true,
    },
});

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
