<template>
    <button class="flex p-2 rounded items-center justify-center bg-lavender-dark shadow-md active:shadow-none hover:bg-lavender-logo hover:animate-pulse">
        <IconMdi class="fill-white" :icon="mdiTableHeadersEye"/>
    </button>
</template>
<script setup>
import { mdiTableHeadersEye } from '@mdi/js';
import IconMdi from '@/Components/IconMdi.vue';
</script>
