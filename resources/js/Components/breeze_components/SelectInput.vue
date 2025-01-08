<template>
    <select
        v-model="selectedOption"
        @change="emitSelection"
        class="border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
    >
        <!-- Placeholder -->
        <option v-if="placeholder" :disabled="props.disabledPlaceholder" value="">{{ placeholder }}</option>

        <!-- Opciones -->
        <option
            v-for="(item, index) in optionsArray"
            :key="index"
            :value="props.optionValueProp?item[props.optionValueProp]:item"
        >
            {{ props.optionNameProp?item[props.optionNameProp]:item }}
        </option>
    </select>
</template>

<script setup>
import { ref, watch } from "vue";

// Definir props
const props = defineProps({
    optionsArray: {
        type: Object,
        required: true,
    },
    selected: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        required: false,
    },
    optionNameProp: {
        type: String,
        required: false,
    },
    optionValueProp: {
        type: String,
        required: false,
    },
    disabledPlaceholder: {
        type: Boolean,
        required: false,
        default: true,
    },
});

// Emitir el valor seleccionado al componente padre
const emit = defineEmits(["update:selected"]);

// Variable reactiva para el valor seleccionado
const selectedOption = ref(props.selected);

// Emitir cada vez que el valor seleccionado cambie
function emitSelection() {
    emit("update:selected", selectedOption.value);
}

// Sincronizar `selectedOption` con cambios en `props.selected`
watch(
    () => props.selected,
    (newValue) => {
        selectedOption.value = newValue;
    }
);
</script>
