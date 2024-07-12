<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            Tu Perfil
        </NavLink>
        <NavLink :href="route('admin.indexCode')" :active="route().current('admin.indexCode')||route().current('admin.genCode')||route().current('admin.delCode')">
            Códigos de Registro
        </NavLink>
        <NavLink :href="route('admin.indexCode')" :active="false">
            Gestionar Centros
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from '@/Components/breeze_components/NavLink.vue';

</script>
