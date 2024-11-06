<template>
    <Base :titulo="titulo">
        <Carousel class="w-full h-auto hidden md:block" :autoplay="20000" :wrap-around="true">
            <Slide v-for="slide in carouselImages" :key="slide">
                <div class="carousel__item">
                    <img :src="slide" alt="carousel_image" />
                </div>
            </Slide>
            <template #addons>
                <Navigation />
            </template>
        </Carousel>
        <MainBox> <Title value="Bienvenid@s a Mímate" /> </MainBox>
    </Base>
</template>
<script setup>
import Base from "@/Layouts/Base.vue";
import Title from "@/Components/Title.vue";
import MainBox from "@/Components/public_components/MainBox.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Navigation, Slide } from "vue3-carousel";

const titulo = "Bienvenid@";

const carouselImages = [
    "img/carrusel/carrusel_amigo.jpg",
    "img/carrusel/carrusel_prueba.jpg",
];
</script>
