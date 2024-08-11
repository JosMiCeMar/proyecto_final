<template>
    <h1 class="font-monserrat text-center texto-degradado uppercase font-bold text-3xl sm:mt-2 mt-4">
       {{ value }}
    </h1>
    <p v-if="subText" class="font-monserrat text-lg font-bold text-skyblue-dark text-center">
      {{ subText }}
    </p>
</template>
<script setup>
defineProps({
    value: {
        type: String,
        required: true,
    },
    subText: {
        type: String,
    },
});
</script>
<style scoped>
.texto-degradado {
    background: linear-gradient(0deg, #3A2642, #315D66);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
