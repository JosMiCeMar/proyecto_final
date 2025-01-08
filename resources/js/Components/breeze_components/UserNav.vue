<template>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <Link :href="route('home')">
                        <LogoMarca
                            class="inline h-9 w-auto fill-white stroke-white hover:fill-skyblue-vlight hover:stroke-skyblue-vlight transition-colors ease-in-out duration-200"
                        />
                    </Link>
                </div>
                <!-- Links de navegadores -->
                <template v-if="$page.props.auth.tipo == 'admin'">
                    <NavigationAdmin @openOptions="navDropdown" />
                </template>
                <template v-else-if="$page.props.auth.tipo == 'responsable'">
                    <NavigationResp />
                </template>
                <template v-else>
                    <NavigationClient />
                </template>
            </div>

            <div class="hidden md:flex md:items-center md:ms-6">
                <!-- Desplegable de usuario -->
                <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex shadow-md items-center pl-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-skyblue-dark hover:text-lavender-vlight fill-white hover:fill-lavender-vlight transition ease-in-out duration-150 focus:outline focus:outline-white"
                                    tabindex="0"
                                >
                                    {{ $page.props.auth.user.nombre }}
                                    {{ $page.props.auth.user.apellidos }}

                                    <IconMdi :icon="mdiMenuDown" />
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('home')">
                                Volver al Inicio
                            </DropdownLink>
                            <template v-if="$page.props.auth.tipo == 'admin'">
                                <DropdownLink
                                    :href="route('admin.profileEdit')"
                                >
                                    Editar Perfil
                                </DropdownLink>
                            </template>
                            <template
                                v-else-if="
                                    $page.props.auth.tipo == 'responsable'
                                "
                            >
                                <DropdownLink :href="route('resp.profileEdit')">
                                    Editar Perfil
                                </DropdownLink>
                            </template>
                            <template v-else>
                                <DropdownLink
                                    :href="route('client.profileEdit')"
                                >
                                    Editar Perfil
                                </DropdownLink>
                            </template>
                            <DropdownLink
                                @click.prevent="closeSession()"
                                tabindex="0"
                            >
                                Desconectar
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Menu hamburguesa -->
            <div class="-me-2 flex items-center md:hidden">
                <button
                    @click="
                        showingNavigationDropdown = !showingNavigationDropdown
                    "
                    class="inline-flex fill-white items-center justify-center p-2 rounded-md bg-skyblue-dark text-white hover:text-lavender-logo transition duration-150 ease-in-out"
                >
                    <IconMdi
                        :icon="mdiMenu"
                        :class="{
                            hidden: showingNavigationDropdown,
                            'inline-flex': !showingNavigationDropdown,
                        }"
                    />

                    <IconMdi
                        :icon="mdiClose"
                        :class="{
                            hidden: !showingNavigationDropdown,
                            'inline-flex': showingNavigationDropdown,
                        }"
                    />
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
        :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
        }"
        class="md:hidden"
    >
        <template v-if="$page.props.auth.tipo == 'admin'">
            <NavigationAdminResponsive />
        </template>
        <template v-else-if="$page.props.auth.tipo == 'responsable'">
            <NavigationRespResponsive />
        </template>
        <template v-else>
            <NavigationClientResponsive />
        </template>
    </div>
</template>
<script setup>
import { ref } from "vue";
import Dropdown from "@/Components/breeze_components/Dropdown.vue";
import DropdownLink from "@/Components/breeze_components/DropdownLink.vue";
import NavigationAdmin from "@/Components/dashboard_components/NavigationAdmin.vue";
import NavigationResp from "@/Components/dashboard_components/NavigationResp.vue";
import NavigationClient from "@/Components/dashboard_components/NavigationClient.vue";
import NavigationAdminResponsive from "@/Components/dashboard_components/NavigationAdminResponsive.vue";
import NavigationRespResponsive from "@/Components/dashboard_components/NavigationRespResponsive.vue";
import NavigationClientResponsive from "@/Components/dashboard_components/NavigationClientResponsive.vue";
import { Link } from "@inertiajs/vue3";
import LogoMarca from "../LogoMarca.vue";
import { closeSession } from "@/Utils/alerts";
import IconMdi from "../IconMdi.vue";
import { mdiClose, mdiMenu, mdiMenuDown } from "@mdi/js";

const emit = defineEmits(["navDropdown"]);

const navDropdown = () => {
    emit("navDropdown");
};

const showingNavigationDropdown = ref(false);
</script>
