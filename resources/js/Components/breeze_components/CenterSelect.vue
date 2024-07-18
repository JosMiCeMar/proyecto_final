<script setup>
import { defineProps,ref } from 'vue';

const props = defineProps({
  centers: {
    type: Array,
    required: true
  }
});

const selectedCenter = ref(''); 

function updateCenter(value) {
  selectedCenter.value = value;
  emit('update:modelValue', value);
}
</script>

<template>
  <select  v-model="selectedCenter" @change="$emit('update:modelValue', selectedCenter)"
    class="border-lavender-dark bg-skyblue-vlight text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
  >
    <option v-for="center in props.centers" :value="center.id">{{ center.nombre }} ({{ center.localidad }})</option>
  </select>
</template>