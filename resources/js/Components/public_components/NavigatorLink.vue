<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

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
        ? " text-lavender-vlight underline"
        : " text-white hover:underline hover:text-skyblue-vlight"
);
</script>

<template>
    <Link :href="href" :class="'inline-flex items-center rounded-md transition-all duration-150 ease-in-out' + classes">
        <div class="w-full h-full px-2 py-2 rounded-md flex items-center text-center">
            <slot />
        </div>
    </Link>
</template>
