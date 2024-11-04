<template>
    <transition name="fade">
        <div v-if="isVisible" :class="`flex w-full mx-4 my-1 justify-${position}`">
            <span
                class="bg-lime-700 p-2 rounded-xl text-center text-white text-sm"
            >
                {{ message }}
            </span>
        </div>
    </transition>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    message: {
        type: String,
        required: true
    },
    position: {
        type: String,
        default: 'start'  // valor por defecto
    },
    duration: {
        type: Number,
        default: 3000  // Tiempo en milisegundos (3 segundos por defecto)
    }
});

const isVisible = ref(true);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = false;
    }, props.duration);
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active en Vue 2 */ {
    opacity: 0;
}
</style>
