//Validacion del centro (id), comprueba que sea un numero entero y que se encuentre en la lista de centros recibida
export function validateIdinList(id, array, nameOfData) {
    if (isNaN(parseInt(id))) {
        return `El campo ${nameOfData} es obligatorio`;
    }

    const exists = array.some((item) => item.id === id);

    if (!exists) {
        return `El identificador del campo ${nameOfData} no se encuentra en la lista`;
    }

    return null;
}
