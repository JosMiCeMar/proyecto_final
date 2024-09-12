<template>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-md bg-gradient-to-b from-skyblue-vlight to-white shadow-md">
                <div class="p-7 rounded-md textura_fondo w-full h-full">
                    <h3 class="text-2xl font-bold text-lavender-dark uppercase">
                        {{ props.title }}
                    </h3>
                    <p class="font-bold text-skyblue-dark">
                        {{ props.description }}
                    </p>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    }
});
</script>
