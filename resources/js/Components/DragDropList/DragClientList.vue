<template>
    <div class="grid grid-cols-4 md:grid-cols-8 gap-2 text-xs">
        <template
            v-for="([hour, item], index) in Object.entries(list)"
            :key="hour"
        >
            <DraggableCard
                :cita="item"
                :draggable="typeof item === 'object'"
                @dragstart="handleDragStart(index)"
                @dragover="handleDragOver"
                @drop="handleDrop(index)"
                @dragend="handleDragEnd"
                :class="
                    item===true
                        ? availableClass
                        : !item
                        ? nonAvailableClass
                        : index === draggedItem
                        ? selectedDragClass
                        : baseDragClass
                "
            >
                <p>Hora: {{ hour }}</p>
            </DraggableCard>
        </template>
    </div>
</template>

<script setup>
import DraggableCard from "@/Components/DragDropList/DraggableCard.vue";
import { ref } from "vue";

// Clases para el estilo de las tarjetas
const baseDragClass = `rounded-md bg-skyblue-vlight flex flex-col shadow-md p-2 cursor-grab`;
const selectedDragClass = `rounded-md bg-lavender-vlight flex-col flex p-2 cursor-grab`;
const availableClass = `rounded-md bg-white flex flex-col shadow-md p-2 cursor-no-drop`;
const nonAvailableClass = `rounded-md bg-gray-200 flex flex-col shadow-md p-2 cursor-no-drop`;

const props = defineProps({
    list: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["mod_list"]);

// Variable referencia que indica la cita arrastrada
const draggedItem = ref(null);

// Manejadores de eventos de arrastre
const handleDragStart = (index) => {
    draggedItem.value = index;
};

const handleDragOver = (event) => {
    event.preventDefault();
};

const handleDrop = (index) => {
    if (draggedItem.value !== null) {
        const entries = Object.entries(props.list);

        // Verificar si el destino está marcado como false
        if (entries[index][1] === false) {
            return; // No permitir el drop en un espacio no disponible
        }

        // Obtener la cita que se va a mover
        const [droppedKey, droppedItem] = entries[draggedItem.value];

        // Si hay un objeto en el destino, moverlo al lugar del arrastrado
        if (typeof entries[index][1] === "object") {
            // Guardar el objeto existente en el destino
            const existingItem = entries[index][1];
            // Colocar el objeto arrastrado en el destino
            entries[index][1] = { ...droppedItem };
            // Mover el objeto existente a la posición del objeto arrastrado
            entries[draggedItem.value][1] = existingItem;
        } else {
            // Si el destino es true, solo reemplazar por el objeto arrastrado
            entries[index][1] = { ...droppedItem };
            // Asegurarse de que la posición del objeto arrastrado se marque como true
            entries[draggedItem.value][1] = true;
        }

        // Convertir de nuevo a objeto, manteniendo las claves
        const updatedList = Object.fromEntries(entries);

        // Emitir el objeto actualizado
        emit("mod_list", updatedList);
        draggedItem.value = null;
    }
};

const handleDragEnd = () => {
    draggedItem.value = null;
};
</script>
