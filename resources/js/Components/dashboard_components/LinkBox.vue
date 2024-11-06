<template>
    <Link :href="props.route" class="w-fit">
    <div class="hover:bg-lavender-vlight rounded-md text-lavender-dark bg-white p-4 w-fit shadow-md transition-all ease-in-out duration-500">
        <div class="flex flex-wrap gap-1 mb-2 items-center">
            <IconMdi class="fill-lavender-dark" :icon="props.icon" :size='30' />
            <span class="font-bold ">{{ props.title }}</span>
        </div>
        <p class="text-sm ">
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
    description: {
        type: String,
        required: true,
    },
});
</script>
