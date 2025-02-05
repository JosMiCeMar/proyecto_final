<template>
    <Base :titulo="titulo">
      <img class="w-full h-auto hidden md:block" src="img/recursos/impulsa.jpg" alt="impulsa tu negocio" />
      <MainBox>
        <SectionDivisor />
        <Title
          value="la explotación compartida"
          subText="Toda la información sobre la explotación compartida de Mímate"
        />
  
        <div v-for="(section, index) in sections" :key="index">
          <section
            :ref="el => (sectionRefs[index] = el)"
            :class="[
            'p-4 text-white my-4 transition-all duration-700 ease-out transform rounded-md shadow-md',
            index % 2 === 0 ? 'bg-gradient-to-b from-skyblue-dark from-80% to-skyblue-logo mr-20 ml-4' : 'bg-gradient-to-b from-lavender-dark from-75% to-lavender-logo ml-20 mr-4',
            {
              'opacity-100 scale-100 blur-0 translate-y-0': visibleSections[index],
              'opacity-0 scale-90 blur-md translate-y-10': !visibleSections[index]
            }
          ]"
          >
            <h2 class="text-xl uppercase font-bold mb-4">{{ section.title }}</h2>
            <div v-html="section.content"></div>
          </section>
        </div>
      </MainBox>
    </Base>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  import Base from "@/Layouts/Base.vue";
  import Title from "@/Components/Title.vue";
  import MainBox from "@/Components/public_components/MainBox.vue";
  import SectionDivisor from "@/Components/public_components/SectionDivisor.vue";
  
  const titulo = "Trabaja con Nosotros";
  
  // Contenido de las secciones
  const sections = [
    {
      title: "¿Qué es la Explotación Compartida?",
      content: `<p class="leading-relaxed text-lg">
                  La explotación compartida es un modelo innovador que permite
                  a múltiples negocios y profesionales acceder a servicios de
                  depilación láser de última generación sin necesidad de
                  adquirir su propio equipo. Nosotros nos encargamos de todo:
                  proporcionamos el equipo, los técnicos de depilación y el
                  mantenimiento, mientras tú te concentras en hacer crecer tu
                  negocio.
                </p>`
    },
    {
      title: "Beneficios de Nuestro Servicio",
      content: `<ul class="list-disc list-inside space-y-2 leading-relaxed text-lg">
                  <li><strong>Ahorro Económico:</strong> Elimina la necesidad de grandes inversiones iniciales y reduce los costos operativos.</li>
                  <li><strong>Acceso a Tecnología Avanzada:</strong> Disfruta de lo último en tecnología de depilación láser, con equipos modernos, eficientes y seguros.</li>
                  <li><strong>Servicio Completo:</strong> Nos encargamos de todo, desde la operación de las máquinas hasta el mantenimiento, para que puedas centrarte en tu negocio.</li>
                  <li><strong>Ingresos Compartidos:</strong> Los centros asociados obtienen un porcentaje de los beneficios generados, asegurando una relación de beneficio mutuo.</li>
                  <li><strong>Soporte Técnico y Capacitación:</strong> Nuestro equipo de expertos está disponible para ofrecer soporte técnico, asegurando que puedas ofrecer el mejor servicio a tus clientes.</li>
                </ul>`
    },
    {
      title: "¿Cómo Funciona?",
      content: `<ol class="list-decimal list-inside space-y-2 leading-relaxed text-lg">
                  <li><strong>Suscripción y Reserva:</strong> Suscríbete a nuestro servicio y accede a un sistema de reservas sencillo y eficiente para gestionar las citas de tus clientes.</li>
                  <li><strong>Servicio en tu Local:</strong> Nosotros proporcionamos el equipo y los operadores de máquina para realizar el servicio en tu clínica o local.</li>
                  <li><strong>Beneficios Compartidos:</strong> Recibe un porcentaje de los ingresos generados por el servicio de depilación láser en tu centro.</li>
                </ol>`
    },
    {
      title: "¿Por Qué Elegirnos?",
      content: `<p class="leading-relaxed text-lg">
                  En Mímate, estamos comprometidos con tu éxito. Sabemos que cada cliente es único, por eso ofrecemos soluciones
                  personalizadas que se adaptan a tus necesidades específicas. Nuestro objetivo es ayudarte a ofrecer un servicio de
                  depilación láser de alta calidad, que satisfaga a tus clientes y te ayude a crecer tu negocio sin comprometer tu
                  presupuesto.
                </p>`
    },
    {
      title: "Contacto",
      content: `<p class="leading-relaxed text-lg">
                  Si estás interesado en saber más sobre nuestro servicio de depilación láser en explotación compartida, no dudes en
                  contactarnos. Nuestro equipo está listo para responder a todas tus preguntas y ayudarte a comenzar.
                </p>`
    }
  ];
  
  // Configuración de refs y visibilidad
  const sectionRefs = ref([]);
  const visibleSections = ref(sections.map(() => false));
  
  function handleIntersect(entries) {
    entries.forEach(entry => {
      const index = sectionRefs.value.indexOf(entry.target);
      if (index !== -1) {
        visibleSections.value[index] = entry.isIntersecting;
      }
    });
  }
  
  onMounted(() => {
    const observer = new IntersectionObserver(handleIntersect, { threshold: 0.1 });
    sectionRefs.value.forEach(section => observer.observe(section));
  
    onUnmounted(() => observer.disconnect());
  });
  </script>
  
  <style>
  .opacity-0 {
    opacity: 0;
  }
  .opacity-100 {
    opacity: 1;
  }
  .translate-y-10 {
    transform: translateY(4rem); /* Sección inicialmente desplazada la derecha */
  }
  .translate-y-0 {
    transform: translateY(0); /* Sección en posición normal */
  }
  </style>
  