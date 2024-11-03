<template>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="rounded-md bg-gradient-to-b from-skyblue-vlight to-white shadow-md"
            >
                <div class="p-7 rounded-md textura_fondo w-full h-full">
                    <h3 class="text-2xl font-bold text-lavender-dark uppercase">
                        {{ props.title }}
                    </h3>
                    <p class="font-bold text-skyblue-dark">
                        {{ props.description }}
                    </p>
                    <slot />
                    <!--Boton de retorno-->
                    <div v-if="returnLink" class="flex sm:justify-end justify-center w-full">
                        <ReturnLink
                            class="text-skyblue-dark font-bold sm:mx-8 mt-4"
                            iconColor="#315D66"
                            :link="returnLink"
                            value="Volver al menú"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import ReturnLink from '@/Components/dashboard_components/ReturnLink.vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    returnLink: {
        type: String,
        required:false
    },
});
</script>
