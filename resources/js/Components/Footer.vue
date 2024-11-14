<script setup lang="ts">
import { mdiEmail, mdiFacebook, mdiInstagram, mdiMap, mdiMapMarker, mdiMapMarkerStar, mdiWhatsapp } from '@mdi/js';
import IconMdi from './IconMdi.vue';
</script>

<template>
    <div class="w-full flex flex-col sm:flex-row justify-around text-lavender-dark text-sm text-center">
        <div class="my-auto">Mímate&copy; 2024 <br>Jose Miguel Cejas Martín </div>
        <div class="my-auto font-bold text-xl hidden sm:block">|</div>
        <div class="my-auto text-2xl block sm:hidden sin-espacios">--------------</div>
        <div class="flex flex-col gap-2 my-auto">
            <span>
                <a href="#"
                    class="flex gap-1 justify-center items-center hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark"
                    target="_blank">
                    <IconMdi :icon="mdiInstagram"/>
                    Instagram</a>
            </span>
            <span>
                <a href="https://www.facebook.com/DepilaserMC/"
                    class="flex gap-1 justify-center items-center hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark"
                    target="_blank">
                    <IconMdi :icon="mdiFacebook"/>
                    Facebook
                </a>
            </span>
        </div>
        <div class="my-auto font-bold text-xl hidden sm:block">|</div>
        <div class="my-auto text-2xl block sm:hidden sin-espacios">--------------</div>
        <div class="flex flex-col gap-2 my-auto">
            <span class="flex gap-1 justify-center items-center fill-lavender-dark"> 
                <IconMdi :icon="mdiWhatsapp"/>
                609970116
            </span>
            <span class="flex gap-1 justify-center items-center fill-lavender-dark"> 
                <IconMdi :icon="mdiEmail"/>
                mimate@gmail.com
            </span>
            <span>
                <a target="_blank"
                    class="flex gap-1 justify-center items-center hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark"
                    href="https://www.google.com/maps/place/C.+Cardenal+Cisneros,+22,+13412+Chill%C3%B3n,+Ciudad+Real/@38.7950582,-4.8688669,15z/data=!4m6!3m5!1s0xd6b45dc17f1c9f7:0x2470b8b1079ed62a!8m2!3d38.7970702!4d-4.8688669!16s%2Fg%2F11csl4qrhj?entry=ttu">
                    <IconMdi :icon="mdiMapMarker"/>
                    C/ Cardenal Císneros 22 - Chillón(Ciudad Real)
                </a>
            </span>
        </div>
    </div>
</template>

<style scoped>
.sin-espacios{
    letter-spacing: -3px;
}
</style>