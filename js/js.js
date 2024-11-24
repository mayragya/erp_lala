
//time
function updateDateTime() {
    const now = new Date();

    // Obtener día de la semana
    const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    const dayName = days[now.getDay()];

    // Obtener fecha y hora
    const day = String(now.getDate()).padStart(2, '0');
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    const monthName = monthNames[now.getMonth()];
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    // Formatear la fecha y hora
    const formattedDateTime = `${dayName} ${day} de ${monthName} del ${year} ${hours}:${minutes}`;
    document.getElementById('datetime').innerText = formattedDateTime;
}

// Actualizar la fecha y hora cada minuto
setInterval(updateDateTime, 60000);

// Inicializar la fecha y hora
updateDateTime();

//funcion para imprimir pagina
function imprimirPagina() {
    window.print(); // Abre el cuadro de diálogo de impresión.
  }