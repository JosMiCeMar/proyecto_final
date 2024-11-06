<template>
    <button class="flex p-2 rounded items-center justify-center bg-skyblue-dark shadow-md active:shadow-none hover:bg-skyblue-logo hover:animate-pulse">
        <IconMdi class="fill-white" :icon="mdiNoteEditOutline"/>
    </button>
</template>
<script setup>
import { mdiNoteEditOutline } from '@mdi/js';
import IconMdi from '@/Components/IconMdi.vue';
</script>
