<script setup lang="ts">
import { mdiEmail, mdiFacebook, mdiInstagram, mdiPhone, mdiWhatsapp } from "@mdi/js";
import IconMdi from "./IconMdi.vue";
import { getToday } from "@/Utils/Validators/dias_validator";
import { CONTACT_EMAIL, CONTACT_PHONE } from "@/Utils/utilsFunctions";
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
                <a href="https://www.instagram.com/depilasermc/"
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
                <a :href="`tel:${CONTACT_PHONE}`" class="flex gap-1 justify-center items-center">
                    <IconMdi :icon="mdiWhatsapp" /><IconMdi :icon="mdiPhone" />
                    {{ CONTACT_PHONE }}
                </a>
            </span>
            <span class="hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark hidden sm:block">
                <a :href="`mailto:${CONTACT_EMAIL}`" class="flex gap-1 justify-center items-center">
                    <IconMdi :icon="mdiEmail" />
                    {{ CONTACT_EMAIL }}
                </a>
            </span>
            <span class="hover:text-skyblue-dark hover:underline fill-lavender-dark hover:fill-skyblue-dark block sm:hidden">
                <a :href="`mailto:${CONTACT_EMAIL}`" class="flex gap-1 justify-center items-center">
                    <IconMdi :icon="mdiEmail" />
                    Email contacto
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
