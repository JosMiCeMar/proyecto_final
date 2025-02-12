<script setup lang="ts">
import SectionDivisor from './SectionDivisor.vue';

</script>

<template>
    <div
        class="shadow-sm bg-gradient-to-t from-skyblue-vlight to-lightyellow"
    >
        <div class="w-full h-full textura_fondo">
            <div>
                <slot />
            </div>
        </div>
    </div>
    <SectionDivisor/>
</template>
