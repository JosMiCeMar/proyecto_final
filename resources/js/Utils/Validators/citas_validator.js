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

export function validateTimeInList(time, timeList){
    const regexFormat = /^([01]\d|2[0-3]):[0-5]\d$/;

    if(!time.trim()){
        return "Selecciona una hora";
    }

    if(!regexFormat.test(time)){
        return "El formato introducido no es correcto";
    }

    if(!timeList.includes(time)){
        return "La hora escogida no se encuentra disponible";
    }

    return null;
}