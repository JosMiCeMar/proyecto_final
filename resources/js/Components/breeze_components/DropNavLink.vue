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
    ? 'inline-flex items-center p-2 bg-gradient-to-t from-lavender-dark text-sm font-medium leading-5 text-skyblue-vlight focus:outline-lavender-vlight focus:text-lavender-vlight focus:border-lavender-logo transition duration-150 ease-in-out'
        : 'inline-flex items-center p-2 bg-transparent text-sm font-medium leading-5 text-white hover:text-lavender-vlight focus:outline-lavender-vlight focus:text-lavender-vlight  transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
