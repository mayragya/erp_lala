console.log('loadCartaporte.js');
var cartaportes = []; 

async function loadCartaporte() {
    try {
        const response = await fetch('../php/getCartaporte.php'); 
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        let data = await response.json(); 
        cartaportes = data; // Asignar los datos recibidos a la variable global
        drawTable(); // Llamar a drawTable después de asignar los datos
    } catch (error) {
        console.error('Error fetching cartaportes:', error); 
        return { error: 'error' };
    }
}

function drawTable() {
    try {
        const tbody = document.getElementById("printCartaporte");
        tbody.innerHTML = ''; // Limpiar el contenido anterior de la tabla
        

        cartaportes.forEach(cartaporte => {
            let tr = document.createElement("tr"); 
            tr.innerHTML = `
                <td>${cartaporte.id}</td>
                <td>${cartaporte.operador}</td>
                <td>${cartaporte.placa}</td>
                <td>${cartaporte.modelo}</td>
                <td>${cartaporte.ciudad_origen}</td>
                <td>${cartaporte.fecha_salida}</td>
                <td>${cartaporte.hora_salida}</td>
                <td>${cartaporte.destino}</td>
                <td>${cartaporte.num_contacto}</td>
                 <td style="text-align: center;"><a href="/php/editCartaporte.php?id=${cartaporte.id}">
                       <img src="/images/W3.png" height="20" width="30"></a></td>
                        <td style="text-align: center;"><a href="/php/printCartaporte.php?id=${cartaporte.id}">
                       <img src="/images/imprimir.png" height="20" width="30"></a></td>
                        <td style="text-align: center;"><a href="/php/deleteCartaporte.php?id=${cartaporte.id}">
                       <img src="/images/W4.png" height="20" width="30"></a></td>`;
            tbody.appendChild(tr); 
        }); 
    } catch (error) {
        console.error('Error drawing table:', error);
    }
}

// Cargar al refrescar página
loadCartaporte();
