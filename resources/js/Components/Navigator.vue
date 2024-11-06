<script setup>
import NavigatorLink from "@/Components/public_components/NavigatorLink.vue";
import Dropdown from "@/Components/breeze_components/Dropdown.vue";
import DropdownLink from "@/Components/breeze_components/DropdownLink.vue";
import IconMdi from "./IconMdi.vue";
import { mdiHamburger, mdiMenu } from "@mdi/js";
</script>
<template>
    <nav class="hidden w-[75%] justify-center gap-5 md:flex mx-6">
        <div class="flex">
            <NavigatorLink
                :href="route('home')"
                :active="route().current('home')"
                >Inicio</NavigatorLink
            >
        </div>
        <div class="flex">
            <NavigatorLink
                :href="route('trabaja')"
                :active="route().current('trabaja')"
                >Trabaja con nosotros
            </NavigatorLink>
        </div>
        <div class="flex">
            <NavigatorLink
                :href="route('centros')"
                :active="route().current('centros')"
                >Centros Asociados</NavigatorLink
            >
        </div>
        <div class="flex">
            <NavigatorLink
                :href="route('somos')"
                :active="route().current('somos')"
                >¿Quiénes somos?</NavigatorLink
            >
        </div>
    </nav>
    <nav class="inline md:hidden justify-center items-center w-fit">
        <div class="relative">
            <Dropdown align="left" >
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="inline-flex m-2 items-center p-2 border border-transparent leading-4 rounded-md bg-skyblue-dark fill-white hover:fill-lavender-dark hover:bg-lavender-logo  focus:outline-none transition ease-in-out duration-150"
                        >
                        <IconMdi :icon="mdiMenu"/>
                        </button>
                    </span>
                </template>

                <template #content>
                    <div>
                     <DropdownLink
                            class="flex text-xl text-center py-4"
                            :href="route('home')"
                            >Inicio</DropdownLink
                        >
                        <DropdownLink
                            class="flex text-xl text-center py-4"
                            :href="route('trabaja')"
                            >Trabaja con nosotros</DropdownLink
                        >
                        <DropdownLink
                            class="flex text-xl text-center py-4"
                            :href="route('centros')"
                            >Centros Asociados</DropdownLink
                        >
                        <DropdownLink
                            class="flex text-xl text-center py-4"
                            :href="route('somos')"
                            >¿Quienes somos?</DropdownLink
                        >
                    </div>
                </template>
            </Dropdown>
        </div>
    </nav>
</template>


