<template>
    <section class="mt-8 space-y-8 text-lavender-dark p-6 rounded-xl shadow-lg">
      <div v-for="(section, index) in sections" :key="index" class="pb-4">
        <article
          :ref="el => (sectionRefs[index] = el)"
          :class="[
            'p-6 text-lavender-dark transition-all duration-700 ease-out transform rounded-xl shadow-md',
            index % 2 === 0 ? 'bg-sky-100 md:mr-20 md:ml-4' : 'bg-purple-100 md:ml-20 md:mr-4',
            {
              'opacity-100 scale-100 blur-0 translate-y-0': visibleSections[index],
              'opacity-0 scale-90 blur-md translate-y-10': !visibleSections[index]
            }
          ]"
        >
          <h2 v-if="section.title" :class="[`text-2xl text-skyblue-dark font-bold border-l-4 pl-4 mb-4`, index % 2 === 0 ? 'border-lavender-logo' : 'border-skyblue-logo']">
            {{ section.title }}
          </h2>
          <div class="text-lg leading-relaxed" v-html="section.content"></div>
        </article>
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted, defineProps } from 'vue';
  
  const props = defineProps({
    sections: Array
  });
  
  const sectionRefs = ref([]);
  const visibleSections = ref(props.sections.map(() => false));
  
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
  