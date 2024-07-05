<template>
    <div class="flex flex-wrap justify-around gap-4">
        <PruevasComponentHijo @alerta="mensaje" v-for="post in info" :key="post.titulo" :titulo="post.titulo" :contenido="post.contenido" />
    </div>
</template>

<script setup>
import PruevasComponentHijo from "@/Components/PruebasComponentHijo.vue";

let info = [
    { titulo: "Post 1", contenido: "información 1" },
    { titulo: "Post 2", contenido: "información 2" },
    { titulo: "Post 3", contenido: "información 3" },
    { titulo: "Post 4", contenido: "información 4" }
];

const mensaje=(msg)=>{
    alert(msg)
}
</script>

<style scoped></style>
