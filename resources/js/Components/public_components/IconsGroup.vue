<template>
    <section class="flex flex-wrap">
        <div class="p-4 flex flex-col items-center justify-center md:w-1/4 w-1/2 bg-lavender-dark">
            <IconMdi :icon="mdiSnowflakeThermometer" :size="100" class="fill-skyblue-logo"/>
            <p class="text-skyblue-logo text-center">Temperaturas de trabajo hasta de -10C° </p>
        </div>
        <div class="p-4 flex flex-col items-center justify-center md:w-1/4 w-1/2 bg-skyblue-logo ">
            <IconMdi :icon="mdiLotion" :size="100" class="fill-lavender-dark"/>
            <p class="text-lavender-dark text-center font-bold">Los mejores productos para el cuidado de tu piel</p> 
        </div>
        <div class="p-4 flex flex-col items-center md:w-1/4 w-1/2 bg-lavender-vlight">
            <IconMdi :icon="mdiPaletteSwatchOutline" :size="100" class="fill-skyblue-dark"/>
            <p class="text-skyblue-dark text-center font-bold">Para todo tipo de pieles</p> 
        </div>
        <div class="p-4 flex flex-col items-center md:w-1/4 w-1/2 bg-skyblue-dark">
            <IconMdi :icon="mdiLaserPointer" :size="100" class="fill-lavender-vlight"/>
            <p class="text-lavender-vlight text-center">Tecnología láser de diodo de última generación</p> 
        </div>
    </section>
</template>
<script setup>
import IconMdi from '@/Components/IconMdi.vue';
import { mdiPaletteSwatchOutline, mdiLotion, mdiSnowflakeThermometer, mdiLaserPointer } from '@mdi/js';

</script>
