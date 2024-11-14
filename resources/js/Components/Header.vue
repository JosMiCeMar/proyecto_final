<template>
    <div
        class="px-10 md:flex grid grid-cols-3 grid-rows-2 gap-2 py-3 justify-between bg-gradient-to-r from-lavender-dark to-skyblue-dark shadow-md"
    >
        <div class="flex justify-center items-center rounded-md col-span-3">
            <Link :href="route('home')" class="p-2">
                <LogoMarca
                    class="fill-white stroke-white hover:fill-skyblue-vlight hover:stroke-skyblue-vlight w-40 h-auto"
                />
            </Link>
        </div>
        <div class="flex lg:justify-center items-center rounded-md">
            <Navigator />
        </div>
        <div class="flex justify-center items-center rounded-md col-span-2">
            <div class="lg:flex lg:flex-1 md:justify-center justify-end">
                <template v-if="authUser">
                    <div class="flex ml-3 items-center">
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center pl-3 border border-transparent text-sm leading-4 font-medium rounded-md bg-lavender-dark hover:text-skyblue-vlight text-white fill-white hover:fill-skyblue-vlight focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{ authUser.nombre }}
                                            {{ authUser.apellidos }}
                                            <IconMdi
                                                :icon="mdiMenuDown"
                                                :size="30"
                                            />
                                        </button>
                                    </span>
                                </template>
                                <template #content>
                                    <DropdownLink
                                        :href="route('dashboard')"
                                        class=""
                                        >Panel de Control</DropdownLink
                                    >
                                    <DropdownLink
                                        class="text-lg sm:text-sm"
                                        @click.prevent="closeSession()"
                                        >Desconectar
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div
                        class="flex flex-wrap justify-center items-center gap-4 ml-3 text-lg sm:text-sm"
                    >
                        <Link
                            :href="route('login')"
                            class="rounded-md flex items-center h-fit px-3 py-2 ring-1 ring-transparent text-white hover:text-lavender-vlight focus-visible:ring-white fill-white hover:fill-lavender-vlight transition-all ease-in-out"
                        >
                            <IconMdi :icon="mdiLogin" :size="20" />
                            <span class="ml-1">Acceso</span>
                        </Link>
                        <Link
                            :href="route('cod_registro.check')"
                            class="rounded-md flex items-center h-fit px-3 py-2 ring-1 ring-transparent text-white hover:text-lavender-vlight focus-visible:ring-white fill-white hover:fill-lavender-vlight transition-all ease-in-out"
                        >
                            <IconMdi :icon="mdiAccountPlus" :size="20" />
                            <span class="ml-1">Registro</span>
                        </Link>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
import Dropdown from "@/Components/breeze_components/Dropdown.vue";
import DropdownLink from "@/Components/breeze_components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
import { closeSession } from "@/Utils/alerts";
import LogoMarca from "@/Components/LogoMarca.vue";
import Navigator from "./Navigator.vue";
import IconMdi from "@/Components/IconMdi.vue";
import { mdiAccountPlus, mdiLogin, mdiMenuDown } from "@mdi/js";

const props = defineProps({
    authUser: {
        type: Object,
        default: null,
    },
});
</script>
