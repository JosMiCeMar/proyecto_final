<template>
    <div
        class="flex justify-center items-center w-screen h-screen bg-gradient-to-br from-white via-skyblue-vlight to-lavender-vlight">
        <div class="flex flex-row gap-4 justify-center items-center bg-white p-5 rounded-md">
            <div class="flex justify-center items-center bg-red-600 rounded-full">
                <img class="w-40" src="img/icons/access_denied.svg" alt="icon" />
            </div>
            <div>
                <h1 class="text-2xl text-lavender-dark">
                    Lo sentimos, no tienes acceso a la ruta indicada
                </h1>
                <p class="text-lavender-dark text-xl text-end">
                    <Link :href="route('home')" class="hover:text-skyblue-dark hover:underline">Volver a la página de
                    inicio</Link>
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
</script>
