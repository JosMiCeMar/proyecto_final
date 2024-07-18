<template>
    <Link :href="props.route">
    <div class="hover:bg-lavender-vlight rounded-md bg-white p-4 w-fit shadow-md transition-all ease-in-out">
        <div class="flex flex-wrap gap-2 mb-2 items-center">
            <img class="fill-lavender-dark inline w-6" :src="props.icon" alt="icon" />
            <p class="font-bold inline">{{ props.title }}</p>
        </div>
        <p class="text-sm">
            {{ props.description }}
        </p>
    </div>
    </Link>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    route: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
});
</script>
