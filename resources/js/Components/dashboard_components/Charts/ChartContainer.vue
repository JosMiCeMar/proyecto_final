<template>
    <section
        class="bg-gradient-to-tr from-white via-pink-100 to-white lg:p-4 p-2 shadow-md rounded-md flex flex-col gap-4 items-center justify-center"
    >
        <!-- Título -->
        <h3 class="text-lavender-dark lg:text-xl text-lg font-bold text-center">
            {{ props.title }}
        </h3>
        <slot />
        <!-- Botón para mostrar/ocultar la lista -->
        <button
            @click="showList = !showList"
            class="bg-gradient-to-b text-sm items-center from-gray-100 to-gray-200 text-lavender-dark fill-lavender-dark hover:outline hover:outline-lavender-dark outline-1 w-full flex py-1 justify-center gap-2 rounded-md shadow-md transition-all duration-200"
        >
            {{ showList ? "Ocultar Lista" : "Mostrar Lista" }}
            <IconMdi
                :size="20"
                :icon="showList ? mdiChevronUp : mdiChevronDown"
            />
        </button>

        <!-- Contenedor de la lista con transición -->
        <transition name="fade-slide" mode="out-in">
            <div v-show="showList" key="list" class="w-full overflow-hidden">
                <ul class="list-inside space-y-1 text-lavender-dark">
                    <li
                        v-for="(item, index) in props.labels"
                        :key="index"
                        class="flex justify-between items-center px-2 py-1 rounded-md hover:bg-gray-200 transition"
                    >
                        <span class="font-bold">{{ item }}</span>
                        <span class="text-sm text-skyblue-dark font-bold">
                            {{ props.values[index] }}
                            <span v-if="props.subfix">{{ props.subfix }}</span>
                        </span>
                    </li>
                </ul>
            </div>
        </transition>
    </section>
</template>

<script setup>
import IconMdi from "@/Components/IconMdi.vue";
import { mdiChevronDown, mdiChevronUp } from "@mdi/js";
import { ref } from "vue";

// Controlador para mostrar/ocultar lista
const showList = ref(false);

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    labels: {
        type: Array,
        required: false,
    },
    values: {
        type: Array,
        required: false,
    },
    subfix: {
        type: String,
        required: false,
    },
});
</script>

<style scoped>
/* Clases personalizadas para transición */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

.fade-slide-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>
