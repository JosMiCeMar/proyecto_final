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
import { router } from '@inertiajs/vue3';

const props = defineProps({
    message: {
        type: String,
        required: true
    },
    position: {
        type: String,
        default: 'start'  
    },
    duration: {
        type: Number,
        default: 3000  
    }
});

const isVisible = ref(true);

const showMessage = () => {
    isVisible.value = true;
    setTimeout(() => {
        isVisible.value = false;
    }, props.duration);
};

// Mostrar mensaje al montar
onMounted(() => {
    showMessage();

    // Escuchar navegación con Inertia
    router.on('finish', () => {
        showMessage();
    });
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
