<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            Tu Perfil
        </NavLink>
        <NavLink :href="route('indexCode')" :active="route().current('indexCode')">
            Códigos de Registro
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from '@/Components/breeze_components/NavLink.vue';

const isActive=()=>{

}
</script>
