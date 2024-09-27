<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import Header from "@/Components/Header.vue";
import MainBox from "@/Components/public_components/MainBox.vue";
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
    <div
        class="bg-gradient-to-tl from-lavender-vlight via-skyblue-vlight to-white min-h-screen min-w-screen"
    >
        <Header :authUser="authUser" />
            <slot/>
        <footer class="py-8 text-center text-sm text-black dark:text-white/70">
            <Footer />
        </footer>
    </div>
</template>
