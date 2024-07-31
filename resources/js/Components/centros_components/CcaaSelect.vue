<template>
    <div class="flex flex-col gap-4">
      <!-- Selector de CCAA -->
      <div v-if="ccaa.length" class="flex flex-col gap-2">
        <InputLabel value="Comunidad Autónoma" />
        <select
          v-model="selectedCcaaLabel"
          @change="onCcaaChange"
          class="border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"

        >
          <option value="">Selecciona la CCAA</option>
          <option
          class="checked:bg-lavender-logo checked:text-white"
            v-for="region in ccaa"
            :key="region.code"
            :value="region.label"
          >
            {{ region.label }}
          </option>
        </select>
      </div>
  
      <!-- Selector de Provincias -->
      <div v-if="provinces.length" class="flex flex-col gap-2">
        <InputLabel value="Provincia" />
        <select
          v-model="selectedProvinceLabel"
          @change="onProvinceChange"
          class="border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"

        >
          <option value="">Selecciona la provincia</option>
          <option
            v-for="province in provinces"
            :key="province.code"
            :value="province.label"
          >
            {{ province.label }}
          </option>
        </select>
      </div>
  
      <!-- Selector de Localidades -->
      <div v-if="towns.length" class="flex flex-col gap-2">
        <InputLabel value="Localidad" />
        <select
          v-model="selectedTownLabel"
          @change="onTownChange"
          class="border-lavender-dark bg-blue-100 text-lavender-dark focus:border-lavender-light focus:ring-lavender-light rounded-md shadow-sm"
        >
          <option value="">Selecciona la localidad</option>
          <option
            v-for="(town, index) in towns"
            :key="index"
            :value="town.label"
          >
            {{ town.label }}
          </option>
        </select>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue';
  import CcaaService from '@/Services/CcaaService';
  import InputLabel from '@/Components/breeze_components/InputLabel.vue';
  
  const ccaaService = new CcaaService();
  const ccaa = ccaaService.getCCAA();
  const selectedCcaaLabel = ref('');
  const provinces = ref([]);
  const selectedProvinceLabel = ref('');
  const towns = ref([]);
  const selectedTownLabel = ref('');
  
  const emit = defineEmits(['updateProvince', 'updateTown']);
  
  const fetchAllCCAA = async () => {
    await ccaaService.fetchAll();
  };
  
  onMounted(fetchAllCCAA);
  
  // Actualiza provincias y resetea localidades cuando cambia la CCAA
  watch(selectedCcaaLabel, (newLabel) => {
    const selectedRegion = ccaa.value.find(region => region.label === newLabel);
    provinces.value = selectedRegion ? selectedRegion.provinces : [];
    selectedProvinceLabel.value = ''; // Resetea la provincia seleccionada
    towns.value = []; // Resetea las localidades
    selectedTownLabel.value = ''; // Resetea la localidad seleccionada
    emit('updateProvince', ''); // Notifica al padre sobre el reseteo de la provincia
    emit('updateTown', ''); // Notifica al padre sobre el reseteo de la localidad
  });
  
  // Actualiza localidades cuando cambia la provincia
  watch(selectedProvinceLabel, (newLabel) => {
    const selectedProvince = provinces.value.find(province => province.label === newLabel);
    towns.value = selectedProvince ? selectedProvince.towns : [];
    selectedTownLabel.value = ''; // Resetea la localidad seleccionada
    emit('updateTown', ''); // Notifica al padre sobre el reseteo de la localidad
  });
  
  const onCcaaChange = () => {
    selectedProvinceLabel.value = ''; // Resetea la provincia seleccionada
  };
  
  const onProvinceChange = () => {
   emit('updateProvince', selectedProvinceLabel.value);
  };
  
  const onTownChange = () => {
    emit('updateTown', selectedTownLabel.value);
  };
  </script>
  