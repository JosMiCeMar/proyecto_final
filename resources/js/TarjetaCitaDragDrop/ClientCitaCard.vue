<template>
    <div class="text-lavender-dark">
        <p class="font-bold text-center">{{ nombre }} {{ apellidos }}</p>
        <p>Zona tratamiento:<span class="font-bold">{{ zona }}</span></p>
        <p>Hora solicitada:<span class="font-bold">{{ hora }}</span></p>
        <slot/>    
    </div>
</template>
<script setup>

    defineProps({
        nombre:{
            type:String,
            required:true
        },
        apellidos:{
            type:String,
            required:true
        }
        , 
        zona:{
            type:String,
            required:true
        },
        hora:{
            type:String,
            required:true
        }
    })
</script>
