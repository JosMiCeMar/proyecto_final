<script setup lang="ts">
import { mdiCellphone, mdiEmail, mdiFacebook, mdiInstagram, mdiPhone, mdiWhatsapp } from "@mdi/js";
import IconMdi from "./IconMdi.vue";
import { getToday } from "@/Utils/Validators/dias_validator";
</script>

<template>
    <div class="w-full flex flex-col sm:flex-row justify-around text-lavender-dark text-sm text-center">
        <div class="my-auto">
            Mímate&copy; {{ getToday().getFullYear() }}<br />Jose Miguel Cejas
            Martín
        </div>
        <div class="my-auto font-bold text-xl hidden sm:block">|</div>
        <div class="my-auto text-2xl block sm:hidden sin-espacios">
            --------------
        </div>
        <div class="flex flex-col gap-2 my-auto">
            <span>
                <a href="#"
                    class="flex gap-1 justify-center items-center hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark"
                    target="_blank">
                    <IconMdi :icon="mdiInstagram" />
                    Instagram
                </a>
            </span>
            <span>
                <a href="https://www.facebook.com/DepilaserMC/"
                    class="flex gap-1 justify-center items-center hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark"
                    target="_blank">
                    <IconMdi :icon="mdiFacebook" />
                    Facebook
                </a>
            </span>
        </div>
        <div class="my-auto font-bold text-xl hidden sm:block">|</div>
        <div class="my-auto text-2xl block sm:hidden sin-espacios">
            --------------
        </div>
        <div class="flex flex-col gap-2 my-auto">
            <span class="hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark">
                <a href="tel:+34609970116" class="flex gap-1 justify-center items-center">
                    <IconMdi :icon="mdiWhatsapp" /><IconMdi :icon="mdiPhone" />
                    609970116
                </a>
            </span>
            <span class="hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark">
                <a href="mailto:info@mimate.com" class="flex gap-1 justify-center items-center">
                    <IconMdi :icon="mdiEmail" />
                    mimate@gmail.com
                </a>
            </span>
        </div>
    </div>
</template>

<style scoped>
.sin-espacios {
    letter-spacing: -3px;
}
</style>
