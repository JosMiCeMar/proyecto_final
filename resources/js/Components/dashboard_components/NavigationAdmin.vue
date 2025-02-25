<template>
    <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de usuario
        </NavLink>
        <NavLink
            :href="route('admin.indexInforme')"
            :active="
                route().current('admin.indexInforme') ||
                route().current('admin.ultimoMesInforme') ||
                route().current('admin.informeGeneral') ||
                route().current('admin.personalizarInforme') ||
                ruta === '/informe_personalizado'
            "
        >
            Informes
        </NavLink>
        <NavLink
            :href="route('admin.indexReservas')"
            :active="
                route().current('admin.indexReservas') ||
                route().current('admin.listReservas') ||
                route().current('admin.formReservas') ||
                route().current('admin.showReservas') ||
                route().current('admin.modReservas')
            "
        >
            Reservas
        </NavLink>
        <div @click="emitOpen" @keydown.enter="emitOpen" :class="classes" tabindex="0">
            Gestión de datos
            <IconMdi v-if="!active" :icon="mdiMenuDown" /><IconMdi
                v-if="active"
                :icon="mdiMenuUp"
            />
        </div>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
import { computed, ref } from "vue";
import IconMdi from "../IconMdi.vue";
import { mdiMenuDown, mdiMenuUp } from "@mdi/js";
import { usePage } from "@inertiajs/vue3";

let active = ref(false);

const emit = defineEmits(["openOptions"]);

function emitOpen() {
    active.value = !active.value;
    emit("openOptions");
}

const classes = computed(() =>
    active.value
        ? "inline-flex items-center p-2 cursor-pointer fill-lavender-vlight bg-gradient-to-b from-skyblue-dark text-sm font-medium leading-5 text-lavender-vlight focus:fill-skyblue-vlight focus:outline-lavender-vlight focus:text-skyblue-vlight transition duration-150 ease-in-out"
        : "inline-flex items-center p-2 cursor-pointer fill-white hover:fill-skyblue-vlight bg-transparent text-sm font-medium leading-5 text-white hover:text-skyblue-vlight focus:fill-skyblue-vlight hover:border-gray-700 focus:outline-lavender-vlight focus:text-skyblue-vlight focus:border-gray-700 transition duration-150 ease-in-out"
);

//Constantes para obtener el nombre de la ruta POST y usarlo para mostrar activo su enlace
const page = usePage();
const ruta = page.url;
</script>
