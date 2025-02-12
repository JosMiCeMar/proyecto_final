<template>
    <button class="flex p-2 rounded items-center justify-center bg-skyblue-dark shadow-md active:shadow-none hover:bg-skyblue-logo hover:animate-pulse">
        <IconMdi class="fill-white" :icon="mdiTextBoxEdit"/>
    </button>
</template>
<script setup>
import { mdiCircleEditOutline, mdiNoteEditOutline, mdiPencilBox, mdiTextBoxEdit } from '@mdi/js';
import IconMdi from '@/Components/IconMdi.vue';
</script>
