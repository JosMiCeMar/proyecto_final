<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-white bg-red-600 py-1 px-2 rounded-md w-fit">
            {{ message }}
        </p>
    </div>
</template>
