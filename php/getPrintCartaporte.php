<?php
//jalar la cookie de sesión 
session_start(); 

//encabezado para manejar respuestas en formato json 
header('Content-Type: application/json');

//importar archivos
include_once 'config.php'; 

//verificar si el usuario ha iniciado sesión 
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        "error" => "Usuario no autenticado"
    ]);
    exit();
}

    //verificar conexión con la base de datos 
    $conn = db_user(); 
    if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error); 
    }else{
    try{

    // Recuperar el registro de la tabla "cartaporte"
    $cartaporte_id = $_GET['id']; // ID del cartaporte para imprimir 

        //consulta sql para leer datos 
        $sql = "SELECT * FROM cartaporte WHERE id = ?";
        $stmt =  $conn->prepare($sql); 
        $stmt->bind_param("i", $cartaporte_id); 
        $stmt->execute(); 
        $cartaporte = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
        $stmt->close(); 

        //enviar la respuesta en formato json 
        echo json_encode ([
            "cartaporte"=>$cartaporte
        ]); 

    }catch(Exception $e){
    // Capturar cualquier otro error inesperado
    echo json_encode([
    "error" => "Ocurrió un error: " . $e->getMessage()
    ]);   
    }
}

