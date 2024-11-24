<?php

session_start(); 
include_once 'config.php';
$conn = db_user();
if($conn -> connect_error){
    die("Error en la conexion: " . $conn -> connect_error);
}

try{
    if(isset($_GET['id'])) {
        $id_cartaporte = intval($_GET['id']);

        $sql = "DELETE FROM cartaporte WHERE id = ?";
        if($stmt = $conn -> prepare($sql)){
            $stmt -> bind_param("i",$id_cartaporte);
            if($stmt->execute()) {
                echo "<script>
                alert('Cartaporte eliminado exitosamente!');  
                window.location = 'principal.php';
                </script>";
            
            }else{
                echo "Error al eliminar el registro" . $stmt -> error;
            }
            $stmt -> close();
        }else{
            echo "Error en la preparacion de la consulta: " . $conn->error;

        }
    }
}catch(Exeption $e){
    echo "Error" . $e->getMessage();
}
$conn -> close();
?>
