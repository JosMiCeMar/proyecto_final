export function getHoursRange(){
    return [0,1,2,3,4];
}

export function getMinutesRange(){
    return [0,15,30,45];
}

//Validación nombre
export function validateName(name) {
    //Expresion regular para nombre y apellidos (solo acepta letras y espacios)
    const nameRegex =
        /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;

    if (!name.trim()) {
        return "El nombre es obligatorio";
    }

    if (!nameRegex.test(name)) {
        return "El nombre sólo puede contener letras y espacios";
    }

    if (name.length > 255) {
        return "El nombre no puede superar los 255 carácteres";
    }

    return null;
}

//Validacion precio
export function validatePrice(price) {
    if (isNaN(price)) {
        return "El precio debe ser un número";
    }

    if (price <= 0) {
        return "El precio no puede ser inferior a 0,01€";
    }

    if (price > 1000) {
        return "El precio no puede ser superior a 1000€";
    }

    return null;
}

//Validacion tiempo
export function validateTime(time) {
    
    const timeRegex = /^(0[0-5]):(00|15|30|45)$/;

    if (!time.trim()) {
        return "El tiempo estimado es obligatorio";
    }

    const minutes = parseInt(time.split(":")[1]);
    const hours = parseInt(time.split(":")[0]);
    const hoursRange=getHoursRange();
    const minutesRange=getMinutesRange();

    if (!hoursRange.includes(hours)) {
        return `Las horas deben estar entre ${hoursRange[0]} y ${hoursRange[hoursRange.length-1]}`;
    }

    if (!minutesRange.includes(minutes)) {
        return `Los minutos únicamente pueden ser ${minutesRange.toString()}`;
    }

    if (hours <= 0 && minutes <= 0) {
        return "El tiempo estimado mínimo son 15 minutos";
    }

    if(!timeRegex.test(time)){
        return "El formato de tiempo no es correcto"
    }

    return null;

}
