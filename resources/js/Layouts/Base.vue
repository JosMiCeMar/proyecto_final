<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import Header from "@/Components/Header.vue";
import { ref } from "vue";

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
    <body
        class="grid grid-rows-[auto_1fr_auto] bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white min-h-screen min-w-screen"
    >
        <header class="row-1 md:sticky sm:top-0 sm:z-50">
            <Header :authUser="authUser" />
        </header>
        <main class="row-2">
            <slot />
        </main>
        <footer class="row-3 py-4">
            <Footer />
        </footer>
    </body>
</template>

