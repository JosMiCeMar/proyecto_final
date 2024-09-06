<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        default: "#"
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-skyblue-logo text-start text-base font-medium text-lavender-dark hover:text-skyblue-dark bg-skyblue-vlight focus:outline-none focus:bg-skyblue-light focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-400 hover:text-lavender-dark hover:bg-lavender-vlight hover:border-lavender-logo focus:outline-none focus:bg-skyblue-light focus:border-indigo-700 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes + ' cursor-pointer'">
        <slot />
    </Link>
</template>
