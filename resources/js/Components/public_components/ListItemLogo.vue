<template>
    <div class="flex items-center gap-2">
        <div class="bg-lavender-dark rounded-full p-1">
        <IconMarca class="w-[10px] flex-shrink-0 fill-white" />
        </div>
        <span class="flex-1">
            {{ props.text }}
        </span>
    </div>
</template>
<script setup>
import IconMarca from "@/Components/IconMarca.vue";

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
});
</script>
