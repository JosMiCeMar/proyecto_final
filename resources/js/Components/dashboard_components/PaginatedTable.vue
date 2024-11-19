<template>
    <div class="overflow-y-auto custom-scrollbar">
        <table class="w-full lg:text-sm text-xs text-left shadow-md">
            <thead
                class="text-white font-bold uppercase bg-gradient-to-t from-lavender-dark to-skyblue-dark"
            >
                <tr>
                    <th
                        v-for="header in headers"
                        :key="header"
                        scope="col"
                        class="px-6 py-3"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody
                class="border-b border-skyblue-dark text-lavender-dark bg-white"
            >
                <tr
                    v-for="item in paginatedItems"
                    :key="item.id"
                    class="border-t border-lavender-logo hover:bg-blue-100 transition-all ease-in-out duration-500"
                >
                    <slot :item="item"></slot>
                </tr>
            </tbody>
        </table>
    </div>
    <div :class="`flex justify-between items-center p-2 ${setVisible()}`">
        <button
            @click="previousPage"
            :disabled="currentPage === 1"
            class="p-1 bg-lavender-dark fill-white shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
        >
            <IconMdi :icon="mdiMenuLeftOutline" :size="30" class="fill-white" />
        </button>
        <div class="flex space-x-2">
            <span
                v-for="page in totalPages"
                :key="page"
                @click="currentPage = page"
                class="w-3 h-3 rounded-full cursor-pointer"
                :class="
                    currentPage === page
                        ? 'bg-lavender-dark'
                        : 'bg-lavender-light'
                "
            ></span>
        </div>
        <button
            @click="nextPage"
            :disabled="currentPage === totalPages || totalPages === 0"
            class="p-1 bg-lavender-dark fill-white shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
        >
            <IconMdi
                :icon="mdiMenuRightOutline"
                :size="30"
                class="fill-white"
            />
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import IconMdi from "@/Components/IconMdi.vue";
import {
    mdiGestureSwipeHorizontal,
    mdiMenuLeftOutline,
    mdiMenuRightOutline,
} from "@mdi/js";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    headers: {
        type: Array,
        required: true,
    },
    itemsPerPage: {
        type: Number,
        default: 5,
    },
    controlsVisible: {
        type: Boolean,
        default: true,
    },
});

const setVisible = () => {
    return props.controlsVisible ? "visible" : "hidden";
};

// Estado para paginación
const currentPage = ref(1);

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * props.itemsPerPage;
    const end = start + props.itemsPerPage;
    return props.items.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(props.items.length / props.itemsPerPage);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
</script>
<style scoped>
/* Estilos para personalizar la barra de scroll de la tabla */
.custom-scrollbar::-webkit-scrollbar {
    width: 3px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #3a2642;
    border-radius: 100px;
    border: 4px solid #f0f0f0; /* Espacio entre la barra y el div */
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #315d66;
}
</style>
