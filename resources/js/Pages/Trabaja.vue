<template>
    <Base titulo="Trabaja con Nosotros">
        <img
            class="w-full h-auto hidden md:block"
            src="img/recursos/impulsa.jpg"
            alt="impulsa tu negocio"
        />
        <MainBox>
            <SectionDivisor />
            <Title
                value="La explotación compartida"
                subText="Toda la información sobre la explotación compartida de Mímate"
            />
            <AnimSections :sections="sections" />
        </MainBox>
    </Base>
</template>

<script setup>
import Base from "@/Layouts/Base.vue";
import Title from "@/Components/Title.vue";
import MainBox from "@/Components/public_components/MainBox.vue";
import SectionDivisor from "@/Components/public_components/SectionDivisor.vue";
import AnimSections from "@/Components/public_components/AnimSections.vue";
import { CONTACT_EMAIL, CONTACT_PHONE } from "@/Utils/utilsFunctions";

const sections = [
    {
        title: "¿Qué es la Explotación Compartida?",
        content: `<p class="leading-relaxed text-lg">
                    La explotación compartida es un modelo innovador que permite a múltiples negocios y profesionales acceder a servicios de depilación láser de última generación sin necesidad de adquirir su propio equipo. Nosotros nos encargamos de todo: proporcionamos el equipo, los técnicos de depilación y el mantenimiento, mientras tú te concentras en hacer crecer tu negocio.
                </p>`,
    },
    {
        title: "Beneficios de Nuestro Servicio",
        content: `<ul class="list-disc list-inside space-y-3 p-4">
                    <li><span class="font-bold">Ahorro Económico</span> – Elimina la necesidad de grandes inversiones iniciales y reduce los costos operativos.</li>
                    <li><span class="font-bold">Acceso a Tecnología Avanzada</span> – Disfruta de lo último en tecnología de depilación láser, con equipos modernos, eficientes y seguros.</li>
                    <li><span class="font-bold">Servicio Completo</span> – Nos encargamos de todo, desde la operación de las máquinas hasta el mantenimiento, para que puedas centrarte en tu negocio.</li>
                    <li><span class="font-bold">Ingresos Compartidos</span> – Los centros asociados obtienen un porcentaje de los beneficios generados, asegurando una relación de beneficio mutuo.</li>
                    <li><span class="font-bold">Soporte Técnico y Capacitación</span> – Nuestro equipo de expertos está disponible para ofrecer soporte técnico, asegurando que puedas ofrecer el mejor servicio a tus clientes.</li>
                </ul>`,
    },
    {
        title: "¿Cómo Funciona?",
        content: `<ol class="list-decimal list-inside space-y-2 leading-relaxed text-lg">
                    <li><span class="font-bold">Suscripción y Reserva</span> – Suscríbete a nuestro servicio y accede a un sistema de reservas sencillo y eficiente para gestionar las citas de tus clientes.</li>
                    <li><span class="font-bold">Servicio en tu Local</span> – Nosotros proporcionamos el equipo y los operadores de máquina para realizar el servicio en tu clínica o local.</li>
                    <li><span class="font-bold">Beneficios Compartidos</span> – Recibe un porcentaje de los ingresos generados por el servicio de depilación láser en tu centro.</li>
                </ol>`,
    },
    {
        title: "¿Por Qué Elegirnos?",
        content: `<p class="leading-relaxed text-lg">
                    En Mímate, estamos comprometidos con tu éxito. Sabemos que cada cliente es único, por eso ofrecemos soluciones personalizadas que se adaptan a tus necesidades específicas. Nuestro objetivo es ayudarte a ofrecer un servicio de depilación láser de alta calidad, que satisfaga a tus clientes y te ayude a hacer crecer tu negocio sin comprometer tu presupuesto.
                </p>`,
    },
    {
        title: "Contacto",
        content: `<p class="leading-relaxed text-lg">
                    Si estás interesado en saber más sobre nuestro servicio de depilación láser en explotación compartida, no dudes en contactarnos. Nuestro equipo está listo para responder a todas tus preguntas y ayudarte a comenzar.
                </p>
                <ul class="mt-4 text-lg">
                    <li><span class="font-bold">Teléfono:</span> <a href="tel:${CONTACT_PHONE}" class="hover:text-skyblue-dark hover:underline">${CONTACT_PHONE}</a></li>
                    <li><span class="font-bold">Email:</span> <a href="mailto:${CONTACT_EMAIL}" class="hover:text-skyblue-dark hover:underline">${CONTACT_EMAIL}</a></li>
                    <li><span class="font-bold">Dirección:</span> Calle Aguadulce, 7, Écija (Sevilla)</li>
                    <li><span class="font-bold">Horario:</span> Lunes a Viernes, 9:00 - 19:00</li>
              </ul>`,
    },
];
</script>
