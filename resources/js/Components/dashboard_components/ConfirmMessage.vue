<template>
    <div :class="`flex w-full mx-4 my-1 justify-${position}`">
        <span
            class="bg-lime-700 p-2 rounded-xl text-center text-white text-sm"
            >{{ message }}</span
        >
    </div>
</template>

<script setup>

defineProps({
    message: {
        type: String,
        required: true
    },
    position: {
        type: String,
        default: 'start'  // valor por defecto
    }
});

</script>