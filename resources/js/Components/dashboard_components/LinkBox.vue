<template>
    <Link :href="props.route" class="w-fit">
    <div class="flex flex-col justify-center rounded-md text-lavender-dark bg-white p-4 w-fit shadow-md transition-all ease-in-out duration-500 hover:bg-lavender-vlight ">
        <div class="flex flex-wrap gap-1 items-center h-auto">
            <IconMdi class="fill-lavender-dark" :icon="props.icon" :size='props.iconSize' />
            <span class="font-bold ">{{ props.title }}</span>
        </div>
        <p class="text-sm mt-2" v-if="props.description">
            {{ props.description }}
        </p>
    </div>
    </Link>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import IconMdi from '@/Components/IconMdi.vue';

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
    iconSize:{
        type: Number,
        default: 30,
    },
    description: {
        type: String,
        required: false,
    },
});
</script>
