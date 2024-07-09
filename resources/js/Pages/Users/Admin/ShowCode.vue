<template>
    <Head title="Generar Código" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="rounded-md bg-gradient-to-b from-skyblue-vlight to-white shadow-md">
                    <div class="p-7 rounded-md textura_fondo w-full h-full">
                        <h3 class="text-2xl text-center font-bold text-lavender-dark uppercase">
                            Generar Código de Registro
                        </h3>
                        <p class="text-center text-skyblue-dark font-bold">
                            Este es el código generado para el registro del nuevo usuario.
                        </p>
                        <div>
                            <p class="text-center my-7">
                                <span
                                    class="justify-center items-center text-3xl bold text-lavender-dark p-4 bg-gradient-to-t from-lavender-vlight to-white shadow-xl">{{
                                    codigo }}</span>
                            </p>
                            <div v-if="tipo==='1'" class="text-lavender-dark text-center">Recuerda, este código es para un nuevo  
                                <span class="uppercase font-bold">cliente</span>
                            </div>
                            <div v-else class="text-lavender-dark text-center">Recuerda, este código es para un nuevo 
                                <span class="uppercase font-bold">responsable</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/breeze_layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";

let props = defineProps({
    codigo: {
        type: String,
        required: true
    },
    tipo: {
        type: Boolean,
        required: true
    }
})
</script>