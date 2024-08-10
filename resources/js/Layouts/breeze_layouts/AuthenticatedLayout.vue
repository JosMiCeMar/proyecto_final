<template>
    <div>
        <div
            class="min-h-screen bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white"
        >
            <!-- Navegador -->
            <nav
                class="bg-gradient-to-b from-lavender-dark to-skyblue-dark shadow-md transition-all ease-in-out duration-200"
            >
                <UserNav @navDropdown="openAdmin = !openAdmin" />
            </nav>
            <!--Menu desplegable de gestion de datos del administrador-->
            <transition
                enter-active-class="transition-all ease-in-out duration-500"
                leave-active-class="transition-all ease-in-out duration-500"
                enter-from-class="opacity-0 max-h-0 overflow-hidden"
                enter-to-class="opacity-100 max-h-screen overflow-hidden"
                leave-from-class="opacity-100 max-h-screen overflow-hidden"
                leave-to-class="opacity-0 max-h-0 overflow-hidden"
            >
                <div v-if="openAdmin">
                    <NavigationAdminDBMan />
                </div>
            </transition>
            <!-- Cabecera -->
            <header class="bg-skyblue-dark shadow-md" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Contenido -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import UserNav from "@/Components/breeze_components/UserNav.vue";
import NavigationAdminDBMan from "@/Components/dashboard_components/NavigationAdminDBMan.vue";

let openAdmin = ref(false);
</script>

