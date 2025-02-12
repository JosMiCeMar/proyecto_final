<template>
    <Base :titulo="titulo">
        <Carousel
            class="w-full h-auto hidden md:block"
            :autoplay="20000"
            :wrap-around="true"
        >
            <Slide v-for="slide in carouselImages" :key="slide">
                <div class="carousel__item">
                    <img :src="slide" alt="carousel_image" />
                </div>
            </Slide>
            <template #addons>
                <Navigation />
            </template>
        </Carousel>
        <MainBox>
            <SectionDivisor />
            <TextAndImageBox
                :is-text-left="false"
                :title="'Piensa en tí, mímate'"
                :image-alt="'imagen laser'"
                :route="'img/recursos/ini1.jpg'"
            >
                <ul class="my-4 flex flex-col gap-2">
                    <li>
                        <ListItemLogo
                            :text="'Resultados visibles desde la primera sesión, equipos de vanguardia y profesionales altamente capacitados. Olvídate del vello no deseado y disfruta de una piel perfecta todo el año.'"
                        />
                    </li>
                    <li>
                        <ListItemLogo
                            :text="'Utilizamos la tecnología más innovadora en depilación láser para garantizar tratamientos rápidos, efectivos y adaptados a cada tipo de piel.'"
                        />
                    </li>
                    <li>
                        <ListItemLogo
                            :text="'En nuestros centros asociados, te sentirás cómod@ y relajad@ mientras disfrutas de un tratamiento diseñado para potenciar tu confianza y bienestar.'"
                        />
                    </li>
                </ul>
                <div class="flex justify-center">
                    <button
                        class="bg-lavender-dark text-white hover:bg-skyblue-dark inline-flex items-center border border-transparent rounded-md text-xs uppercase focus:outline-none focus:ring-2 focus:ring-lavender-light focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <a
                            href="/centros_asociados"
                            class="w-full h-full px-4 py-2"
                            >ver centros asociados</a
                        >
                    </button>
                </div>
            </TextAndImageBox>
            <SectionDivisor />
            <TextAndImageBox
                :title="'Olvídate del dolor'"
                :image-alt="'imagen laser'"
                :route="'img/recursos/ini2.jpg'"
            >
                <ul class="my-4">
                    <li class="flex items-start gap-2 mb-2">
                        <ListItemLogo :text="'Con Mímate, la depilación se convierte en un proceso cómodo y agradable. Disfruta de un tratamiento que se adapta a ti, con resultados duraderos y sin interrupciones incómodas'" />
                    </li>
                    <li class="flex items-start gap-2 mb-2">
                        <ListItemLogo :text="'Nuestra tecnología de depilación láser garantiza que el tratamiento sea efectivo y sin ningún tipo de molestia. Disfruta de una piel suave y libre de vello sin tener que preocuparte por la incomodidad de otros métodos.'" />
                    </li>
                </ul>
            </TextAndImageBox>
            <IconsGroup />
        </MainBox>
    </Base>
</template>
<script setup>
import Base from "@/Layouts/Base.vue";
import TextAndImageBox from "@/Components/public_components/TextAndImageBox.vue";
import MainBox from "@/Components/public_components/MainBox.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Navigation, Slide } from "vue3-carousel";
import SectionDivisor from "@/Components/public_components/SectionDivisor.vue";
import ListItemLogo from "@/Components/public_components/ListItemLogo.vue";
import IconsGroup from "@/Components/public_components/IconsGroup.vue";

const titulo = "Bienvenid@";

const carouselImages = [
    "img/carrusel/carrusel_amigo.jpg",
    "img/carrusel/carrusel_prueba.jpg",
];
</script>
