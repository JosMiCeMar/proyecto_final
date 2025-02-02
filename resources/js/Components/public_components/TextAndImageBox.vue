<template>
    <section class="flex flex-col md:flex-row text-lavender-dark">
        <div v-if="isTextLeft" class="flex flex-1 flex-col items-center justify-center p-4 bg-gradient-to-r from-lavender-vlight to-transparent">
            <h2 class="text-2xl font-bold texto-degradado">{{ title }}</h2>
            <p>{{ description }}</p>
        </div>
        <div class="flex-1">
            <img :src="route" :alt="imageAlt" class="object-cover w-full h-full" />
        </div>
        <div v-if="!isTextLeft" class="flex flex-1 flex-col items-center justify-center p-4 bg-gradient-to-r from-transparent to-lavender-vlight">
            <h2 class="text-2xl font-bold texto-degradado">{{ title }}</h2>
            <p>{{ description }}</p>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    title: String,
    description: String,
    imageAlt: String,
    route: String,
    isTextLeft: {
        type: Boolean,
        default: true
    }
});
</script>