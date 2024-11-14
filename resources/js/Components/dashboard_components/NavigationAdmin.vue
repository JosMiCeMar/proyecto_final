<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </NavLink>
        <div @click="emitOpen" :class="classes">Gestión de datos <IconMdi v-if="!active" :icon="mdiMenuDown"/><IconMdi v-if="active" :icon="mdiMenuUp"/> </div>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
import { computed, ref } from "vue";
import IconMdi from "../IconMdi.vue";
import { mdiMenuDown, mdiMenuUp } from "@mdi/js";

let active = ref(false);

const emit = defineEmits(["openOptions"]);

function emitOpen() {
    active.value = !active.value;
    emit("openOptions");
}

const classes = computed(() =>
    active.value
        ? "inline-flex items-center p-2 cursor-pointer fill-lavender-vlight bg-gradient-to-b from-skyblue-dark text-sm font-medium leading-5 text-lavender-vlight focus:outline-lavender-vlight focus:text-skyblue-vlight transition duration-150 ease-in-out"
        : "inline-flex items-center p-2 cursor-pointer fill-white hover:fill-skyblue-vlight bg-transparent text-sm font-medium leading-5 text-white hover:text-skyblue-vlight hover:border-gray-700 focus:outline-lavender-vlight focus:text-skyblue-vlight focus:border-gray-700 transition duration-150 ease-in-out"
);
</script>
