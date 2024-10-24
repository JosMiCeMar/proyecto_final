export function addHours(hour1, hour2) {
  // Separar horas y minutos de ambas horas
  const [h1, m1] = hour1.split(':').map(Number);
  const [h2, m2] = hour2.split(':').map(Number);
  
  // Convertir ambas horas a minutos totales
  const totalMin1 = h1 * 60 + m1;
  const totalMin2 = h2 * 60 + m2;

  // Sumar los minutos totales
  const minutosSumados = totalMin1 + totalMin2;

  // Convertir los minutos sumados de nuevo a horas y minutos
  const horasResultado = Math.floor(minutosSumados / 60);
  const minutosResultado = minutosSumados % 60;

  // Formatear el resultado a HH:MM
  const horasFormateadas = horasResultado.toString().padStart(2, '0');
  const minutosFormateados = minutosResultado.toString().padStart(2, '0');

  return `${horasFormateadas}:${minutosFormateados}`;
}
