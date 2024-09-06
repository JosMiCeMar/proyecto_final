<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div>
        <p class="bg-lime-700 text-sm text-white rounded-md py-1 px-2">
            {{ message }}
        </p>
    </div>
</template>
