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

export function formatHour(hour){
  const arrayHour = hour.split(":");
  return `${arrayHour[0]}:${arrayHour[1]}`;
}

function capitalizeFirstChart(string) {
  if (string.length === 0) return string; // Si la cadena está vacía, devolvemos la cadena tal cual
  return string.charAt(0).toUpperCase() + string.slice(1);
}

export function getTotalByColumnName(data, columnName, columnNumber) {
  const pricesByTreatment = {};

  data.forEach(treatment => {
    const treatmentName = capitalizeFirstChart(treatment[columnName]);  
    const price = parseFloat(treatment[columnNumber]);

    if (pricesByTreatment[treatmentName]) {
      pricesByTreatment[treatmentName] += price;
    } else {
      pricesByTreatment[treatmentName] = price;
    }
  });

  const labels = Object.keys(pricesByTreatment);
  const values = labels.map(label => pricesByTreatment[label]);

  return [labels, values];
}

export function getTotalByYears(data, columnDateName, columnNumber) {
  const pricesByTreatment = {};

  data.forEach(treatment => {
    const treatmentName = new Date(treatment[columnDateName]).getFullYear();  
    const price = parseFloat(treatment[columnNumber]);

    if (pricesByTreatment[treatmentName]) {
      pricesByTreatment[treatmentName] += price;
    } else {
      pricesByTreatment[treatmentName] = price;
    }
  });

  const labels = Object.keys(pricesByTreatment);
  const values = labels.map(label => pricesByTreatment[label]);

  return [labels, values];
}

export function getCountByColumnName(data, column_name) {
  const pricesByTreatment = {};

  data.forEach(treatment => {
    const treatmentName = capitalizeFirstChart(treatment[column_name]);  

    if (pricesByTreatment[treatmentName]) {
      pricesByTreatment[treatmentName]++;
    } else {
      pricesByTreatment[treatmentName] = 1;
    }
  });

  const labels = Object.keys(pricesByTreatment);
  const values = labels.map(label => pricesByTreatment[label]);

  return [labels, values];
}
