<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import Header from "@/Components/Header.vue";
import { ref } from "vue";
import Navigator from "@/Components/Navigator.vue";

const { props } = usePage();
const authUser = ref(props.auth.user);

const title = defineProps({
    titulo: {
        type: String,
        required: true,
    },
});


</script>

<template>

    <Head :title="title.titulo" />
    <div class="bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white min-h-screen min-w-screen">
        <Header :authUser="authUser" />
        <Navigator />
        <main class="sm:mx-4 shadow-sm sm:rounded-lg bg-gradient-to-b from-skyblue-vlight to-lightyellow">
            <div class="w-full h-full textura_fondo rounded-lg">
                <div class="p-2 sm:p-8">
                    <slot />
                </div>
            </div>
        </main>
        <footer class="py-8 text-center text-sm text-black dark:text-white/70">
            <Footer />
        </footer>
    </div>
</template>
