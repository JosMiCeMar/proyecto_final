<template>
    <div class="flex flex-col gap-2">
        <ClientCard
            v-for="(item, index) in lista"
            :key="index"
            :nombre="item.nombre"
            :apellidos="item.apellidos"
            :zona="item.zona"
            :hora="item.hora"
            :draggable="true"
            @dragstart="handleDragStart(index)"
            @dragover="handleDragOver"
            @drop="handleDrop(index)"
            @dragend="handleDragEnd"
            :class="
                index === draggedItem
                    ? selectedClass(item.tiempo)
                    : baseClass(item.tiempo)
            "
        >
        <p>Hora actualizada: {{ index }}</p>
        </ClientCard>
    </div>
</template>

<script setup>
import ClientCard from "@/Components/ClientCitaCard.vue";
import { ref } from "vue";

const baseClass = (time) => {
    return `bg-white rounded w-80 shadow-md px-2 py-${time}`;
};

const selectedClass = (time) => {
    return `bg-lavender-vlight w-80 px-2 py-${time}`;
};

const props = defineProps({
    lista: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["mod_list"]);

const draggedItem = ref(null);

const handleDragStart = (index) => {
    draggedItem.value = index;
};

const handleDragOver = (event) => {
    event.preventDefault();
};

const handleDrop = (index) => {
    if (draggedItem.value !== null) {
        const updatedList = [...props.lista];
        const [droppedItem] = updatedList.splice(draggedItem.value, 1);
        updatedList.splice(index, 0, droppedItem);
        emit("mod_list", updatedList);
        draggedItem.value = null;
    }
};

const handleDragEnd = () => {
    draggedItem.value = null;
};
</script>
