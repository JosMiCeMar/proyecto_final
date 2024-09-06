
//Validación requerido
export function required(value,name){
    if (!value.trim()) {
      return `El campo ${name} es obligatorio`;
    }
    return null;
  }