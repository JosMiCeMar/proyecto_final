
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
  const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;
  if (!name.trim()) {
    return "El nombre es obligatorio";
  } else if (!nameRegex.test(name)) {
    return "El nombre sólo puede contener letras y espacios";
  }
  return null;
}

//Validación apellidos
export function validateLastname(lastname) {
  const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(?:[-'a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*)$/;
  if (!lastname.trim()) {
    return "Los apellidos son obligatorios";
  } else if (!nameRegex.test(lastname)) {
    return "El apellido sólo puede contener letras y espacios";
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
    const arrayIds = arrayCenters.map(element => element.id);
  
    // Valida si el centroId es obligatorio y está en el array de IDs
    if (isNaN(centerId)||centerId=="") {
      return "El centro es obligatorio";
    } else if (!arrayIds.includes(centerId)) {
      return "El id del centro no se encuentra en la lista";
    }
    return null;
  }
  
//Validación fecha nacimiento
export function validateDateOfBirth(date) {

  const minDate = getMinDate();
  const maxDate =getMaxDate();

  if (isNaN(date.getTime())) {
    return "La fecha de nacimiento es obligatoria";
  } else if (date > minDate) {
    return "Debes tener al menos 13 años";
  } else if (date < maxDate) {
    return "La edad máxima son 120 años";
  }
  return null;
}

//Validación contraseña
export function validatePassword(password) {
  if (!password) {
    return "La contraseña es obligatoria";
  } else if (password.length < 8) {
    return "La contraseña debe tener mínimo 8 caracteres";
  } else if (password.length > 250) {
    return "La contraseña debe tener máximo 250 caracteres";
  } else if (!/[a-z]/.test(password)) {
    return "La contraseña debe contener al menos una letra minúscula";
  } else if (!/[A-Z]/.test(password)) {
    return "La contraseña debe contener al menos una letra mayúscula";
  } else if (!/\d/.test(password)) {
    return "La contraseña debe contener al menos un número";
  } else if (!/[!@#$%^&*()_+={}\[\]:;,.?~-]/.test(password)) {
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
