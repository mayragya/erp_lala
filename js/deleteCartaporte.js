function DeleteCartaporte() {
    var idPrestamoElement = document.getElementById("id");

    // Verifica si el input hidden existe
    if (!idElement) {
        console.error("El elemento con id 'id' no existe.");
        return;
    }

    var idCartaporte = idElement.value;

    if (confirm("¿Estás seguro de que deseas eliminar este cartaporte?")) {
        window.location.href = "../php/deleteCartaporte.php?id=" + id;
    }
}
