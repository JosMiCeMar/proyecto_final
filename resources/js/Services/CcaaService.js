import { ref } from "vue";

export default class CcaaService {
  // Usar propiedad privada si es necesario
  #ccaa;

  constructor() {
    // Inicializar la propiedad como una referencia reactiva
    this.#ccaa = ref([]);
  }

  // Método para obtener el valor de ccaa
  getCCAA() {
    return this.#ccaa;
  }

  // Método para obtener todos los datos
  async fetchAll() {
    try {
      const jsonUrl = './data/ccaa.json'; // Verifica si esta ruta es correcta

      // Fetch JSON data
      const response = await fetch(jsonUrl);
      const json = await response.json();

      // Asignar el valor a la propiedad reactiva
      this.#ccaa.value = json; // Asegúrate de que json es un array
    } catch (error) {
      console.error("Error fetching CCAA data:", error);
    }
  }
}
