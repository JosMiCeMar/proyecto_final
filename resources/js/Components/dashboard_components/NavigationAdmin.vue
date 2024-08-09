<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Tu Perfil
        </NavLink>
        <button @click="emitOpen" :class="classes">
            Gestión de datos
        </button>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
import { computed, ref } from "vue";

let active = ref(false);

const emit = defineEmits(["openOptions"]);

function emitOpen() {
    active.value = !active.value;
    emit("openOptions");
}

const classes = computed(() =>
    active.value
        ? "inline-flex items-center p-2 bg-gradient-to-b from-skyblue-dark text-sm font-medium leading-5 text-lavender-vlight focus:outline-none focus:border-skyblue-logo transition duration-150 ease-in-out"
        : "inline-flex items-center p-2 bg-transparent text-sm font-medium leading-5 text-gray-300 hover:text-skyblue-vlight hover:border-gray-700 focus:outline-none focus:text-gray-300 focus:border-gray-700 transition duration-150 ease-in-out"
);
</script>
