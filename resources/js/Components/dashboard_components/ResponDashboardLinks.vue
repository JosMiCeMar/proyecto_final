<template>
    <div class="border border-skyblue-dark rounded-md">
        <h3 class="text-center bg-skyblue-dark text-lg text-white p-1">
            Enlaces principales
        </h3>
        <div
            class="flex flex-wrap justify-center md:flex-row md:justify-around gap-5 p-5"
        >
            <LinkBox
                v-for="box in linksList"
                :route="box.route"
                :icon="box.icon"
                :title="box.title"
                :iconSize="50"
                :description="box.description"
            />
        </div>
    </div>
</template>
<script setup>
import LinkBox from "@/Components/dashboard_components/LinkBox.vue";
import { mdiAccountGroup, mdiCalendarText, mdiAccountKey, mdiAccountEdit } from "@mdi/js";

const linksList = [
    {
        route: route("respon.listReservas"),
        icon: mdiAccountGroup,
        title: "Gestión reservas",
    },
    {
        route: route("respon.ultimoMesInforme"),
        icon: mdiCalendarText,
        title: "Inf. último mes",
    },
    {
        route: route("respon.indexCode"),
        icon: mdiAccountKey,
        title: "Códigos de registro",
    },
    {
        route: route("respon.profileEdit"),
        icon: mdiAccountEdit,
        title: "Editar perfil",
    },
];
</script>
