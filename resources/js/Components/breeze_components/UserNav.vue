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

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Desplegable de usuario -->
                <div class="ms-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex shadow-md items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-skyblue-dark hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{ $page.props.auth.user.nombre }}
                                    {{ $page.props.auth.user.apellidos }}

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
                            <template v-else-if="$page.props.auth.tipo == 'responsable'">
                                <DropdownLink
                                    :href="route('resp.profileEdit')"
                                >
                                    Editar Perfil
                                </DropdownLink>
                            </template>
                            <template  v-else>
                                <DropdownLink
                                    :href="route('client.profileEdit')"
                                >
                                    Editar Perfil
                                </DropdownLink>
                            </template>
                            <DropdownLink @click.prevent="closeSessionAlert">
                                Desconectar
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Menu hamburguesa -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="
                        showingNavigationDropdown = !showingNavigationDropdown
                    "
                    class="inline-flex items-center justify-center p-2 rounded-md bg-skyblue-dark text-white hover:text-lavender-logo transition duration-150 ease-in-out"
                >
                    <svg
                        class="h-6 w-6 fill-lavender-logo"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{
                                hidden: showingNavigationDropdown,
                                'inline-flex': !showingNavigationDropdown,
                            }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{
                                hidden: !showingNavigationDropdown,
                                'inline-flex': showingNavigationDropdown,
                            }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
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
        class="sm:hidden"
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
import { inject } from "vue";
import LogoMarca from "../LogoMarca.vue";

const swal = inject("$swal");

const emit = defineEmits(["navDropdown"]);

const navDropdown = () => {
    emit("navDropdown");
};

const showingNavigationDropdown = ref(false);

const closeSessionAlert = () => {
    swal.fire({
        title: "¿Estás seguro?",
        text: "¿Deseas cerrar sesión?",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3A2642",
        cancelButtonColor: "#d33",
        background: "linear-gradient(320deg, #e3b8f5, #bdd6ff, #fff)",
        color: "#3A2642",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = route("logout");
        }
    });
};
</script>
