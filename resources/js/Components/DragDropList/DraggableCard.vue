<template>
    <template v-if="typeof cita === 'object'">
        <div>
            <p class="font-bold text-center">
                {{ cita.nombre }} {{ cita.apellidos.split(" ")[0] }}
            </p>
            <p>
                Zona:<span class="font-bold">{{ cita.zona }}</span>
            </p>
            <p>
                Cita:<span class="font-bold">{{ cita.hora }}</span>
            </p>
            <slot />
        </div>
    </template>
    <template v-else-if="cita">
        <div>
            <p class="font-bold text-center">
                Disponible
            </p>
            <slot/>
        </div>
    </template>
    <template v-else>
        <div>
            <div>
            <p class="font-bold text-center">
                NO Disponible
            </p>
            <slot/>
        </div>
       </div>
    </template>
</template>
<script setup>
defineProps({
    cita: {
        required: true
    },
});
</script>
