import { ref } from "vue";

export default class CcaaService {
  // Usar propiedad privada si es necesario
  #ccaa;
  #provinces;

  constructor() {
    // Inicializar la propiedad como una referencia reactiva
    this.#ccaa = ref([]);
    this.#provinces=ref([]);
  }

  // Método para obtener el valor de ccaa
  getCCAA() {
    return this.#ccaa;
  }

  getProvinces(){
    return this.#provinces;
  }

  // Método para obtener todos los datos
  async fetchAll() {
    try {
      const jsonUrl = './data/ccaa.json';

      // Fetch JSON data
      const response = await fetch(jsonUrl);
      const json = await response.json();

      // Asignar el valor a la propiedad reactiva
      this.#ccaa.value = json; 
    } catch (error) {
      console.error("Error al tomar los datos de las CCAA:", error);
    }
  }

   // Método para obtener todas las provincias de todas las comunidades autónomas
   async fetchAllProvinces() {
    try {
      const jsonUrl = '/data/ccaa.json';
      const response = await fetch(jsonUrl);
      const json = await response.json();

      // Recorre todas las comunidades autónomas y acumula sus provincias
      const allProvinces = json.flatMap(ccaa => ccaa.provinces || []);
      
      this.#provinces.value = allProvinces;
    } catch (error) {
      console.error("Error al tomar los datos de las provincias:", error);
    }
  }
}
