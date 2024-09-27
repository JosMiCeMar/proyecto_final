<template>
    <header
        class="px-10 flex flex-col lg:flex-row gap-2 py-3 bg-gradient-to-r from-lavender-dark to-skyblue-dark shadow-md lg:sticky lg:top-0 lg:z-10"
    >
        <div class="flex justify-center items-center rounded-md">
            <Link :href="route('home')" class="p-2">
                <LogoMarca
                    class="fill-white stroke-white hover:fill-skyblue-vlight hover:stroke-skyblue-vlight w-40 h-auto"
                />
            </Link>
        </div>
        <div class="flex flex-row w-full justify-between items-center">
            <Navigator />
            <div class="lg:flex lg:flex-1 sm:justify-center justify-end">
                <template v-if="authUser">
                    <div class="flex ml-3 items-center">
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-lavender-dark hover:text-skyblue-vlight text-white focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{ authUser.nombre }}
                                            {{ authUser.apellidos }}
                                            <svg
                                                class="ms-2 -me-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
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
                        class="flex flex-wrap w-full justify-center items-center gap-4 ml-3 text-lg sm:text-sm"
                    >
                        <Link
                            :href="route('login')"
                            class="rounded-md flex items-center h-fit px-3 py-2 ring-1 ring-transparent text-white hover:text-lavender-vlight focus-visible:ring-white fill-white hover:fill-lavender-vlight transition-all ease-in-out"
                        >
                            <svg
                                class="w-4 inline mr-1"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"
                                />
                            </svg>
                            <span class="ml-1">Acceso</span>
                        </Link>
                        <Link
                            :href="route('cod_registro.check')"
                            class="rounded-md flex items-center h-fit px-3 py-2 ring-1 ring-transparent text-white hover:text-lavender-vlight focus-visible:ring-white fill-white hover:fill-lavender-vlight transition-all ease-in-out"
                        >
                            <svg
                                class="w-4 inline mr-1"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 576 512"
                            >
                                <path
                                    d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-14.3-64-64-64H64zm80 256h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zm256-32H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16z"
                                />
                            </svg>
                            <span class="ml-1">Registro</span>
                        </Link>
                    </div>
                </template>
            </div>
        </div>
    </header>
</template>

<script setup>
import Dropdown from "@/Components/breeze_components/Dropdown.vue";
import DropdownLink from "@/Components/breeze_components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
import { closeSession } from "@/Utils/alerts";
import LogoMarca from "@/Components/LogoMarca.vue";
import Navigator from "./Navigator.vue";

const props = defineProps({
    authUser: {
        type: Object,
        default: null,
    },
});
</script>
