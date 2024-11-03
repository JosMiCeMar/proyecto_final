<template>
    <div class="overflow-y-auto">
        <table class="w-full text-sm text-left rtl:text-right shadow-md">
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
    <div
        class="flex justify-between items-center p-2"
    >
        <button
            @click="previousPage"
            :disabled="currentPage === 1"
            class="px-4 py-2 bg-lavender-dark fill-white shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 320 512"
                class="w-4"
            >
                <path
                    d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"
                />
            </svg>
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
            class="px-4 py-2 bg-lavender-dark fill-white shadow-md enabled:hover:fill-skyblue-light active:shadow-none disabled:bg-neutral-400 rounded"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 320 512"
                class="w-4"
            >
                <path
                    d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"
                />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

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
