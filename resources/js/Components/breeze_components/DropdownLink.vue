<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <template v-if="href">
        <Link
            :href="href"
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-white hover:bg-skyblue-dark focus:outline-none focus:bg-skyblue-dark transition duration-150 ease-in-out"
        >
            <slot />
        </Link>
    </template>
    <template v-else>
        <span
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-white hover:bg-skyblue-dark focus:outline-none focus:bg-skyblue-dark transition duration-150 ease-in-out"
        >
            <slot />
        </span>
    </template>
</template>
