<template>
    <div class="rounded-lg bg-white shadow-md h-fit">
        <div class="flex justify-center items-center">
            <div v-if="mapLink" class="relative w-fit h-fit">
                <div v-if="isLoading" class="absolute inset-0 flex justify-center items-center">
                    <!-- Loader spinner -->
                    <svg class="animate-spin h-8 w-8 text-lavender-dark" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
                <iframe class="rounded-lg w-full max-w-[300px] h-auto max-h-[200px] aspect-[16/9]" :src="mapLink"
                    style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    @load="isLoading = false"></iframe>
            </div>
            <div v-else
                class="flex flex-col text-lavender-light font-bold fill-lavender-light justify-center w-fit h-fit items-center text-center px-4 py-10 gap-3">
                <IconMdi :size="50" :icon="mdiEmoticonSadOutline" />
                <span class="">Ubicación no disponible</span>
            </div>
        </div>
        <div class="p-1 bg-gradient-to-r from-lavender-logo via-lavender-dark to-skyblue-logo"></div>
        <div class="p-3">
            <h2 class="text-xl text-lavender-dark font-bold text-center">
                {{ nombre }}
            </h2>
            <p class="font-bold text-lavender-dark">Datos del centro:</p>
            <div class="mt-1 mx-4 flex flex-col gap-1">
                <p class="flex gap-1 text-lavender-dark fill-lavender-dark items-center">
                    <IconMdi :icon="mdiCity" />
                    <span>{{ localidad }} ({{ provincia }})</span>
                </p>
                <p class="flex gap-1 text-lavender-dark fill-lavender-dark items-center">
                    <IconMdi :icon="mdiStore" />
                    <span>{{ direccion }}</span>
                </p>

                <p class="flex gap-1 text-lavender-dark fill-lavender-dark items-center">
                    <IconMdi :icon="mdiPhone" />
                    <span><a class="text-lavender-dark hover:text-skyblue-dark hover:underline"
                            :href="'tel:' + telefono">{{ telefono }}</a></span>
                </p>
                <p v-if="web" class="flex gap-1 text-lavender-dark fill-lavender-dark items-center">
                    <IconMdi :icon="mdiWeb" />

                    <span><a class="text-lavender-dark hover:text-skyblue-dark hover:underline" :href="web"
                            target="_blank">Sitio web</a></span>
                </p>
                <p v-if="email" class="flex gap-1 text-lavender-dark fill-lavender-dark items-center">
                    <IconMdi :icon="mdiEmail" />
                    <span><a class="text-lavender-dark hover:text-skyblue-dark hover:underline" :href="'mailto:'+email"
                        target="_blank">{{ email }}</a></span>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import IconMdi from "../IconMdi.vue";
import {
    mdiCity,
    mdiEmail,
    mdiEmoticonSadOutline,
    mdiPhone,
    mdiStore,
    mdiWeb,
} from "@mdi/js";

const props = defineProps({
    nombre: {
        type: String,
        required: true,
    },
    localidad: {
        type: String,
        required: true,
    },
    provincia: {
        type: String,
        required: true,
    },
    direccion: {
        type: String,
        required: true,
    },
    telefono: {
        type: Number,
        required: true,
    },
    web: {
        type: String,
    },
    email: {
        type: String,
    },
    mapLink: {
        type: String,
    },
});

const isLoading = ref(true);

//Watch para mostrar el spinner de carga mientras se carga el iframe
watch(
    () => props.mapLink,
    (newVal) => {
        if (newVal) {
            isLoading.value = true;
        }
    },
    { immediate: true }
);
</script>
