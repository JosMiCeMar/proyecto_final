<template>
  <svg :width="size" :height="size" viewBox="0 0 24 24">
    <path :d="icon" />
  </svg>
</template>
<script setup>
defineProps({
    icon:{
        type:String,
        required:true
    },
    size:{
        type:Number,
        default:24
    }
})
</script>