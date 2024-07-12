<template>
    <div class="m-4 relative overflow-x-auto">
        <table class="w-full shadow-md text-sm text-left rtl:text-right">
            <thead class="text-white font-bold uppercase bg-gradient-to-t from-lavender-dark to-skyblue-dark">
                <tr>
                    <th v-for="header in headers" :key="header" scope="col" class="px-6 py-3">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody class="border-b border-skyblue-dark text-lavender-dark bg-white">
                <tr v-for="item in paginatedItems" :key="item.id" class="border-t border-lavender-logo">
                    <slot :item="item"></slot>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-between items-center mt-4">
            <button @click="previousPage" :disabled="currentPage === 1"
                class="px-4 py-2 bg-lavender-dark text-white shadow-md hover:text-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded">
                Anterior
            </button>
            <div class="flex space-x-2">
                <span v-for="page in totalPages" :key="page" @click="currentPage = page"
                    class="w-3 h-3 rounded-full cursor-pointer" :class="currentPage === page
                            ? 'bg-lavender-dark'
                            : 'bg-lavender-light'
                        "></span>
            </div>
            <button @click="nextPage" :disabled="currentPage === totalPages || totalPages === 0"
                class="px-4 py-2 bg-lavender-dark text-white shadow-md hover:text-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded">
                Siguiente
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, computed } from "vue";

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
});

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
