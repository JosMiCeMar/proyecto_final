<template>
    <div class="relative flex items-center justify-center w-100">
        <button
            @click="antImagen"
            class="absolute left-2 z-10 px-2 py-5 text-l hover:text-2xl text-white border-skyblue-light border bg-lavender-dark bg-opacity-25 rounded-full hover:bg-opacity-75 focus:outline-none transition-all"
        >
            ‹
        </button>
        <div class="w-100 overflow-hidden">
            <img
                v-for="(imagen, i) in listaImagenes"
                :key="i"
                :src="imagen"
                :class="{
                    block: i === posImagenActual,
                    hidden: i !== posImagenActual,
                }"
                class="w-full rounded-xl h-auto object-cover transition-opacity duration-500"
            />
        </div>
        <button
            @click="sigImagen"
            class="absolute right-2 z-10 px-2 py-5 text-l hover:text-2xl text-white border-skyblue-light border bg-lavender-dark bg-opacity-25 rounded-full hover:bg-opacity-75 focus:outline-none transition-all"
        >
            ›
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const posImagenActual = ref(0);
const listaImagenes = ref([
    "img/carrusel/carrusel_amigo.jpg",
    "img/carrusel/carrusel_prueba.jpg",
]);

let intervalo = null;

const sigImagen = () => {
    posImagenActual.value =
        (posImagenActual.value + 1) % listaImagenes.value.length;
    resetIntervalo();
};

const antImagen = () => {
    posImagenActual.value =
        (posImagenActual.value - 1 + listaImagenes.value.length) %
        listaImagenes.value.length;
    resetIntervalo();
};

const empezarIntervalo = () => {
    intervalo = setInterval(() => {
        sigImagen();
    }, 10000);
};

const resetIntervalo = () => {
    if (intervalo) {
        clearInterval(intervalo);
    }
    empezarIntervalo();
};

const pararIntervalo = () => {
    if (intervalo) {
        clearInterval(intervalo);
    }
};

onMounted(() => {
    empezarIntervalo();
});

onUnmounted(() => {
    pararIntervalo();
});
</script>
