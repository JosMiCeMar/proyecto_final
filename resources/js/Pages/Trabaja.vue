<script setup>
import Base from '@/Layouts/Base.vue';
import IconMarca from '@/Components/IconMarca.vue';


const titulo = 'Trabaja con Nosotros';
</script>

<template>

  <Base :titulo="titulo">
  <section class="flex flex-col items-center text-lavender-dark justify-center gap-2 mt-4 mb-8  mx-4">
    <h1 class="texto-degradado uppercase font-bold text-3xl">Impulsa tu negocio al siguiente nivel</h1>
    <p class="text-lg font-bold">Con la explotación compartida de Mímate, ampliarás los servicios de tu negocio sin realizar ninguna inversión.</p>
  </section>
  <div class="separador rounded-full bg-gradient-to-tr from-lavender-logo to-skyblue-logo"></div>
  <section class="my-8 ml-8 text-lavender-dark">
    <h2 class="text-lg font-bold mb-4">¿Qué es la Explotación Compartida?</h2>
    <p class="leading-relaxed">
      La explotación compartida es un modelo innovador que permite a múltiples negocios y profesionales acceder a
      servicios de depilación láser de última generación sin necesidad de adquirir su propio equipo. Nosotros nos
      encargamos de todo: proporcionamos el equipo, los técnicos de depilación y el mantenimiento, mientras tú te
      concentras en hacer crecer tu negocio.
    </p>
  </section>
  <div class="separador rounded-full bg-gradient-to-tr from-lavender-logo to-skyblue-logo"></div>
  <section class="my-8 ml-8 text-lavender-dark">
    <h2 class="text-lg font-bold mb-4">Beneficios de Nuestro Servicio</h2>
    <ul class="list-disc list-inside space-y-2 leading-relaxed">
      <li><strong>Ahorro Económico:</strong> Elimina la necesidad de grandes inversiones iniciales y reduce los costos
        operativos.</li>
      <li><strong>Acceso a Tecnología Avanzada:</strong> Disfruta de lo último en tecnología de depilación láser, con
        equipos modernos, eficientes y seguros.</li>
      <li><strong>Servicio Completo:</strong> Nos encargamos de todo, desde la operación de las máquinas hasta el
        mantenimiento, para que puedas centrarte en tu negocio.</li>
      <li><strong>Ingresos Compartidos:</strong> Los centros asociados se llevan un porcentaje de los beneficios
        generados, asegurando una relación de beneficio mutuo.</li>
      <li><strong>Soporte Técnico y Capacitación:</strong> Nuestro equipo de expertos está disponible para ofrecer
        soporte técnico, asegurando que puedas ofrecer el mejor servicio a tus clientes.</li>
    </ul>
  </section>
  <div class="separador rounded-full bg-gradient-to-tr from-lavender-logo to-skyblue-logo"></div>
  <section class="my-8 ml-8 text-lavender-dark">
    <h2 class="text-lg font-bold mb-4">¿Cómo Funciona?</h2>
    <ol class="list-decimal list-inside space-y-2 leading-relaxed">
      <li><strong>Suscripción y Reserva:</strong> Suscríbete a nuestro servicio y accede a un sistema de reservas
        sencillo y eficiente para gestionar las citas de tus clientes.</li>
      <li><strong>Servicio en tu Local:</strong> Nosotros proporcionamos el equipo y los operadores de máquina para
        realizar el servicio en tu clínica o local.</li>
      <li><strong>Beneficios Compartidos:</strong> Recibe un porcentaje de los ingresos generados por el servicio de
        depilación láser en tu centro.</li>
    </ol>
  </section>
  <div class="separador rounded-full bg-gradient-to-tr from-lavender-logo to-skyblue-logo"></div>
  <section class="my-8 ml-8 text-lavender-dark">
    <h2 class="text-lg font-bold mb-4">¿Por Qué Elegirnos?</h2>
    <p class="leading-relaxed">
      En Mímate, estamos comprometidos con tu éxito. Sabemos que cada cliente es único, por eso ofrecemos soluciones
      personalizadas que se adaptan a tus necesidades específicas. Nuestro objetivo es ayudarte a ofrecer un servicio de
      depilación láser de alta calidad, que satisfaga a tus clientes y te ayude a crecer tu negocio sin comprometer tu
      presupuesto.
    </p>
  </section>
  <div class="separador rounded-full bg-gradient-to-tr from-lavender-logo to-skyblue-logo"></div>
  <section class="my-8 ml-8 text-lavender-dark">
    <h2 class="text-lg font-bold mb-4">Contacto</h2>
    <p class="leading-relaxed">
      Si estás interesado en saber más sobre nuestro servicio de depilación láser en explotación compartida, no dudes en
      contactarnos. Nuestro equipo está listo para responder a todas tus preguntas y ayudarte a comenzar.
    </p>
    <p class="mt-4 leading-relaxed font-bold">Datos de contacto: Teléfono, Email, Dirección, Redes Sociales</p>
  </section>
  </Base>
</template>
<style>
.separador {
 width: 100%;
 height: 3px;
}

.texto-degradado {
    background: linear-gradient(0deg, #3A2642, #315D66);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>