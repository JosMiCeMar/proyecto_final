//Expresion regular para nombre y apellidos (solo acepta letras y espacios)
const nameRegex =
/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;

// Funciones fechas minima y maxima de nacimiento
export function getMinDate() {
    const minDate = new Date();
    minDate.setHours(0, 0, 0, 0);
    minDate.setFullYear(minDate.getFullYear() - 13);
    return minDate;
}

export function getMaxDate() {
    const maxDate = new Date();
    maxDate.setHours(0, 0, 0, 0);
    maxDate.setFullYear(maxDate.getFullYear() - 120);
    return maxDate;
}

//Validación nombre
export function validateName(name) {

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

//Validación apellidos
export function validateLastname(lastname) {
    if (!lastname.trim()) {
        return "Los apellidos son obligatorios";
    }

    if (!nameRegex.test(lastname)) {
        return "El apellido sólo puede contener letras y espacios";
    }

    if (lastname.length > 255) {
        return "Los apellidos no pueden superar los 255 carácteres";
    }

    return null;
}

//Validación número teléfono
export function validatePhone(phone) {
    const phoneRegex = /^[0-9]{9}$/;
    if (!phoneRegex.test(phone)) {
        return "El teléfono debe tener 9 dígitos";
    }
    return null;
}

//Validación email
export function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return "El correo electrónico no es válido";
    }
    return null;
}

//Validación centro asociado
export function validateCenter(centerId, arrayCenters) {
    // Extrae los IDs de los centros del array
    const arrayIds = arrayCenters.map((element) => element.id);

    // Valida si el centroId es obligatorio y está en el array de IDs
    if (isNaN(centerId) || centerId == "") {
        return "El centro es obligatorio";
    }

    if (!arrayIds.includes(centerId)) {
        return "El id del centro no se encuentra en la lista";
    }

    return null;
}

//Validación fecha nacimiento
export function validateDateOfBirth(date) {
    const minDate = getMinDate();
    const maxDate = getMaxDate();

    if (isNaN(date.getTime())) {
        return "La fecha de nacimiento es obligatoria";
    }
    if (date > minDate) {
        return "Debes tener al menos 13 años";
    }
    if (date < maxDate) {
        return "La edad máxima son 120 años";
    }
    return null;
}

//Validación contraseña
export function validatePassword(password) {
    if (!password) {
        return "La contraseña es obligatoria";
    }

    if (password.length < 8) {
        return "La contraseña debe tener mínimo 8 caracteres";
    }

    if (password.length > 250) {
        return "La contraseña debe tener máximo 250 caracteres";
    }

    if (!/[a-z]/.test(password)) {
        return "La contraseña debe contener al menos una letra minúscula";
    }

    if (!/[A-Z]/.test(password)) {
        return "La contraseña debe contener al menos una letra mayúscula";
    }
    if (!/\d/.test(password)) {
        return "La contraseña debe contener al menos un número";
    }
    if (!/[!@#$%^&*()_+={}\[\]:;,.?~-]/.test(password)) {
        return "La contraseña debe contener al menos un carácter especial";
    }
    return null;
}

//Validación confirmación de contraseña
export function validatePasswordConfirmation(password, passwordConfirmation) {
    if (password !== passwordConfirmation) {
        return "Las contraseñas no coinciden";
    }
    return null;
}
