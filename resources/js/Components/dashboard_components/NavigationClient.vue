<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </NavLink>
        <NavLink :href="route('dashboard')" :active="route().current('home')">
            Cliente
        </NavLink>
    </div>
</template>
<script setup>
import NavLink from '@/Components/breeze_components/NavLink.vue';
</script>

