<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Tu Perfil
        </NavLink>
        <NavLink
            :href="route('admin.indexCode')"
            :active="
                route().current('admin.indexCode') ||
                route().current('admin.genCode') ||
                route().current('admin.delCode')
            "
        >
            Códigos de Registro
        </NavLink>
        <NavLink
            :href="route('admin.indexCenter')"
            :active="
                route().current('admin.indexCenter') ||
                route().current('admin.createCenter') ||
                route().current('admin.listCenter') ||
                route().current('admin.modCenter') ||
                route().current('admin.delCenter')
            "
        >
            Centros Asociados
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from "@/Components/breeze_components/NavLink.vue";
</script>
