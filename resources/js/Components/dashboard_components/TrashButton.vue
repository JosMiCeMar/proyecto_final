<template>
    <button class="flex p-2 rounded bg-red-600 shadow-md active:shadow-none hover:bg-red-800 hover:animate-pulse">
        <IconMdi class="fill-white" :icon="mdiDeleteOutline"/>
    </button>
</template>
<script setup>
import { mdiDeleteOutline } from '@mdi/js';
import IconMdi from '@/Components/IconMdi.vue';
</script>