<template>
    <Base titulo="¿Quiénes Somos?">
      <MainBox>
        <img class="w-full h-auto hidden md:block" src="img/recursos/somos.jpg" alt="quienes somos">
        <SectionDivisor />
        <Title
          value="¿Quiénes somos?"
          subText="Toda la información y preguntas sobre nuestro trabajo y valores"
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
  
  const sections = [
    {
      content: `<p class="text-lg leading-relaxed mb-3">
                    En <span class="font-bold text-primary">Mímate</span>, nos apasiona el bienestar, la estética y la confianza personal. 
                    Sabemos que sentirse bien con uno mismo va más allá de la apariencia, y por eso trabajamos cada día para ofrecer soluciones 
                    eficaces y accesibles en <span class="font-bold text-primary">depilación láser de última generación</span>.
                </p>
                <p class="text-lg leading-relaxed">
                    Nacimos con una visión clara: <span class="font-bold text-primary">democratizar el acceso a la belleza y el emprendimiento</span>. 
                    A través de nuestro modelo de <span class="font-bold text-primary">explotación compartida</span>, brindamos la oportunidad a profesionales 
                    del sector de la estética de utilizar equipos de alta tecnología sin asumir los altos costos de inversión inicial.
                </p>`
    },
    {
      title: "Nuestro propósito",
      content: `<p class="text-lg leading-relaxed">
                    En <span class="font-bold text-primary">Mímate</span>, creemos en una belleza sin barreras. Queremos que todas las personas tengan acceso 
                    a tratamientos seguros, eficaces y cómodos, sin importar su tipo de piel, género o estilo de vida.
                </p>`
    },
    {
      title: "Nuestros valores",
      content: `<ul class="list-disc list-inside space-y-3">
                    <li><span class="font-bold text-primary">Innovación</span> – Trabajamos con tecnología de punta en depilación láser para garantizar resultados efectivos y seguros.</li>
                    <li><span class="font-bold text-primary">Accesibilidad</span> – Creemos que el bienestar no debe ser un lujo, sino un derecho.</li>
                    <li><span class="font-bold text-primary">Profesionalismo</span> – Contamos con especialistas altamente capacitados.</li>
                    <li><span class="font-bold text-primary">Cercanía y confianza</span> – Brindamos un trato cálido y adaptado a cada necesidad.</li>
                    <li><span class="font-bold text-primary">Sostenibilidad y crecimiento</span> – Apoyamos a profesionales a desarrollar su negocio con un modelo rentable.</li>
                </ul>`
    },
    {
      title: "Únete a nuestra comunidad",
      content: `<p class="text-lg leading-relaxed">
                    <span class="font-bold text-primary">Mímate</span> no es solo un centro de depilación láser; somos una comunidad de profesionales y clientes 
                    que buscan lo mejor en estética y bienestar. Nuestra misión es transformar el sector con un enfoque 
                    <span class="font-bold text-primary">más justo, accesible y colaborativo</span>.
                </p>
                <p class="text-xl text-center mt-6 font-bold">Te invitamos a conocernos y a ser parte de esta revolución en la depilación láser.</p>`
    }
  ];
  </script>
  