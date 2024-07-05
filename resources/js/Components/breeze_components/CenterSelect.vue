<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  centers: {
    type: Array,
    required: true
  }
});
</script>

<template>
  <select  v-model="selectedCenter" @change="$emit('update:modelValue', selectedCenter)"
    class="border-lavender-dark bg-skyblue-vlight text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
  >
    <option v-for="center in props.centers" :value="center.id">{{ center.nombre }} ({{ center.localidad }})</option>
  </select>
</template>