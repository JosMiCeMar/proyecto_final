<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </NavLink>
        <NavLink
            :href="route('client.indexCitas')"
            :active="
                route().current('client.indexCitas') ||
                route().current('client.createCitas') ||
                route().current('client.createHoraCitas')||
                route().current('client.storeHoraCitas')||
                route().current('client.tableCitas')||
                route().current('client.modReser')||
                route().current('client.modHoraReser')
            "
        >
            Mis Citas
        </NavLink>
        <NavLink
            :href="route('client.indexTratamientos')"
            :active="route().current('client.indexTratamientos')"
        >
            Mis Tratamientos
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
</script>
