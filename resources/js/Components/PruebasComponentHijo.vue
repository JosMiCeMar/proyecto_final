<template>
    <div
        class="border border-black p-4 rounded-md w-[300px] justify-center items-center"
    >
        <h3 class="text-center">{{ props.titulo }}</h3>
        <p>
            {{ props.contenido }}
        </p>
        <input type="text" v-model="mensaje">
        <button @click="handleClick">Lanza el mensaje</button>
    </div>
</template>
<script setup>
import { defineProps, defineEmits,ref } from 'vue';

let mensaje=ref("");

const props =defineProps({
    titulo:{
        type:String,
        required:true
    },
    contenido:{
        type:String,
        required:true
    }
})

const emits = defineEmits(["alerta"])

const handleClick = ()=>{
   emits('alerta',mensaje.value);
}
</script>
