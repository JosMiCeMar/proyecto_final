<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  centers: {
    type: Array,
    required: true
  },
  selected: {
    type: Number,
    default: null  // Prop opcional con valor por defecto
  }
});

// Definir emit
const emit = defineEmits(['update:modelValue']);

// Si se proporciona 'selected', se inicializa; si no, se deja vacío
const selectedCenter = ref(props.selected !== null ? props.selected : '');

// Watch para actualizar selectedCenter si la prop selected cambia
watch(() => props.selected, (newValue) => {
  if (newValue !== null) {
    selectedCenter.value = newValue;
  }
});

// Emitir el valor actualizado al padre cuando cambie
function updateCenter() {
  emit('update:modelValue', selectedCenter.value);
}
</script>

<template>
  <select v-model="selectedCenter" @change="updateCenter"
    class="border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
  >
    <option v-for="center in centers" :key="center.id" :value="center.id">
      {{ center.nombre }} ({{ center.localidad }})
    </option>
  </select>
</template>
