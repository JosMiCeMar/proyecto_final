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
    ? 'inline-flex items-center p-2 bg-gradient-to-b from-skyblue-dark text-sm font-medium leading-5 text-lavender-vlight focus:outline-lavender-vlight focus:text-skyblue-vlight transition duration-150 ease-in-out'
    : 'inline-flex items-center p-2 bg-transparent text-sm font-medium leading-5 text-white hover:text-skyblue-vlight hover:border-gray-700 focus:outline-lavender-vlight focus:text-skyblue-vlight focus:border-gray-700 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
