<script setup>
import NavigatorLink from "@/Components/public_components/NavigatorLink.vue";
import Dropdown from "@/Components/breeze_components/Dropdown.vue";
import DropdownLink from "@/Components/breeze_components/DropdownLink.vue";
</script>
<template>
    <nav class="hidden justify-center sm:flex mx-6">
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
    <div class="block sm:hidden w-fit">
        <div class="ms-3 relative">
            <Dropdown align="left" >
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="inline-flex svgChange m-4 items-center p-3 border border-transparent leading-4 rounded-md bg-lavender-dark focus:outline-none transition ease-in-out duration-150"
                        >
                            <svg
                                class="w-4 fill-white"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"
                            >
                                <path
                                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
                                />
                            </svg>
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
    </div>
</template>
<style>

.svgChange:hover > svg{
    fill: #87b3fa;
}

</style>

