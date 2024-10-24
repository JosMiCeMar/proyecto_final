<script setup>
import Base from "@/Layouts/Base.vue";
import Title from "@/Components/Title.vue";
import MainBox from "@/Components/public_components/MainBox.vue";
import SectionDivisor from "@/Components/public_components/SectionDivisor.vue";
const titulo = "Trabaja con Nosotros";
</script>

<template>
    <Base :titulo="titulo">
        <img class="w-full h-auto hidden md:block" src="img/recursos/impulsa.jpg" alt="impulsa tu negocio">
        <MainBox>
            <Title
            value="la explotación compartida"
            subText="Toda la información sobre la explotación compartida de Mímate"
        />
            <section class="my-8 ml-8 text-lavender-dark">
                <h2 class="text-xl uppercase font-bold mb-4">
                    ¿Qué es la Explotación Compartida?
                </h2>
                <p class="leading-relaxed text-lg">
                    La explotación compartida es un modelo innovador que permite
                    a múltiples negocios y profesionales acceder a servicios de
                    depilación láser de última generación sin necesidad de
                    adquirir su propio equipo. Nosotros nos encargamos de todo:
                    proporcionamos el equipo, los técnicos de depilación y el
                    mantenimiento, mientras tú te concentras en hacer crecer tu
                    negocio.
                </p>
            </section>
            <SectionDivisor/>
            <section class="my-8 ml-8 text-lavender-dark">
                <h2 class="text-xl uppercase font-bold mb-4">
                    Beneficios de Nuestro Servicio
                </h2>
                <ul class="list-disc list-inside space-y-2 leading-relaxed text-lg">
                    <li>
                        <strong>Ahorro Económico:</strong> Elimina la necesidad
                        de grandes inversiones iniciales y reduce los costos
                        operativos.
                    </li>
                    <li>
                        <strong>Acceso a Tecnología Avanzada:</strong> Disfruta
                        de lo último en tecnología de depilación láser, con
                        equipos modernos, eficientes y seguros.
                    </li>
                    <li>
                        <strong>Servicio Completo:</strong> Nos encargamos de
                        todo, desde la operación de las máquinas hasta el
                        mantenimiento, para que puedas centrarte en tu negocio.
                    </li>
                    <li>
                        <strong>Ingresos Compartidos:</strong> Los centros
                        asociados obtienen un porcentaje de los beneficios
                        generados, asegurando una relación de beneficio mutuo.
                    </li>
                    <li>
                        <strong>Soporte Técnico y Capacitación:</strong> Nuestro
                        equipo de expertos está disponible para ofrecer soporte
                        técnico, asegurando que puedas ofrecer el mejor servicio
                        a tus clientes.
                    </li>
                </ul>
            </section>
            <SectionDivisor/>
            <section class="my-8 ml-8 text-lavender-dark">
                <h2 class="text-xl uppercase font-bold mb-4">¿Cómo Funciona?</h2>
                <ol class="list-decimal list-inside space-y-2 leading-relaxed">
                    <li>
                        <strong>Suscripción y Reserva:</strong> Suscríbete a
                        nuestro servicio y accede a un sistema de reservas
                        sencillo y eficiente para gestionar las citas de tus
                        clientes.
                    </li>
                    <li>
                        <strong>Servicio en tu Local:</strong> Nosotros
                        proporcionamos el equipo y los operadores de máquina
                        para realizar el servicio en tu clínica o local.
                    </li>
                    <li>
                        <strong>Beneficios Compartidos:</strong> Recibe un
                        porcentaje de los ingresos generados por el servicio de
                        depilación láser en tu centro.
                    </li>
                </ol>
            </section>
            <SectionDivisor/>
            <section class="my-8 ml-8 text-lavender-dark">
                <h2 class="text-xl uppercase font-bold mb-4">¿Por Qué Elegirnos?</h2>
                <p class="leading-relaxed text-lg">
                    En Mímate, estamos comprometidos con tu éxito. Sabemos que
                    cada cliente es único, por eso ofrecemos soluciones
                    personalizadas que se adaptan a tus necesidades específicas.
                    Nuestro objetivo es ayudarte a ofrecer un servicio de
                    depilación láser de alta calidad, que satisfaga a tus
                    clientes y te ayude a crecer tu negocio sin comprometer tu
                    presupuesto.
                </p>
            </section>
            <SectionDivisor/>
            <section class="my-8 ml-8 text-lavender-dark">
                <h2 class="text-xl uppercase font-bold mb-4">Contacto</h2>
                <p class="leading-relaxed text-lg">
                    Si estás interesado en saber más sobre nuestro servicio de
                    depilación láser en explotación compartida, no dudes en
                    contactarnos. Nuestro equipo está listo para responder a
                    todas tus preguntas y ayudarte a comenzar.
                </p>
                <p class="mt-4 leading-relaxed font-bold">
                    Datos de contacto: Teléfono, Email, Dirección, Redes
                    Sociales
                </p>
            </section>
        </MainBox>
    </Base>
</template>
