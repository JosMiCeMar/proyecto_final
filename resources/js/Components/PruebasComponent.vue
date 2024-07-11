<template>
    <div class="flex flex-col flex-wrap justify-around gap-4 mt-5">
        <div class="flex gap-2 item-center align-items-center">
            <label for="producto">Producto:</label>
            <input id="producto" class="mr-4" type="text" v-model="nombre" />
        </div>
        <div class="flex gap-2 item-center align-items-center">
            <label for="precio">Precio:</label>
            <input id="precio" type="number" v-model="precio" />
        </div>
        <div class="flex gap-2 item-center align-items-center">
            <button
                @click="agregarProducto"
                class="bg-blue-600 p-2 text-white font-bold rounded"
            >
                Guardar Producto
            </button>
        </div>
    </div>
    <div class="mt-8">
        <table>
            <tr>
                <th class="text-center p-4 border border-sky-700">Producto</th>
                <th class="text-center p-4 border border-sky-700">Precio</th>
            </tr>
            <tr v-for="(objeto, index) in productList" :key="index">
                <td class="text-center p-4 border border-sky-700">
                    {{ objeto.nombre }}
                </td>
                <td class="text-center p-4 border border-sky-700">
                    {{ objeto.precio }}€
                </td>
            </tr>
            <tr>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    Total
                </td>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    {{ total }}€
                </td>
            </tr>
            <tr>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    Total IVA
                </td>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    {{ iva }}€
                </td>
            </tr>
            <tr>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    Suma IVA
                </td>
                <td class="text-center p-4 border border-sky-700 font-bold">
                    {{ sumaFinal }}€
                </td>
            </tr>
        </table>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const nombre = ref("");
const precio = ref(0);

const productList = ref([]);

const agregarProducto = () => {
    const objeto = {
        nombre: nombre.value,
        precio: parseFloat(precio.value)
    };
    productList.value.push(objeto);
    nombre.value = ""; 
    precio.value = 0; 
    console.log(productList.value);
};

const total = computed(() => {
    return productList.value.reduce(
        (sum, producto) => sum + producto.precio,
        0
    );
});

const iva = computed(()=>{
    return total.value/100*21
})

const sumaFinal =computed(()=>{
    return total.value+iva.value
})

console.log(iva);
</script>


