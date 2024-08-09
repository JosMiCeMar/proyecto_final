<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
    ? 'inline-flex items-center p-2 bg-gradient-to-b from-skyblue-dark text-sm font-medium leading-5 text-lavender-vlight focus:outline-none focus:border-skyblue-logo transition duration-150 ease-in-out'
        : 'inline-flex items-center p-2 bg-transparent text-sm font-medium leading-5 text-gray-300 hover:text-skyblue-vlight hover:border-gray-700 focus:outline-none focus:text-gray-300 focus:border-gray-700 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
