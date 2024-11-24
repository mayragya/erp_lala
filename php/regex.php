<?php
#limpiar carácteres extraños del correo
function cleanEmail($inputString){
    $mail_regex = "/[^a-zA-Z0-9_]+@[a-zA-Z0-9.@]+\.[a-zA-Z]{2,}$/";
    $cleaned_mail = preg_replace($mail_regex,"", $inputString);
    return $cleaned_mail;
}

#limpiar carácteres extraños de las contraseñas
function cleanPass($inputString){
    $pass_regex ="/[^a-zA-Z0-9@.$%]/";
    $cleaned_Pass = preg_replace($pass_regex, "", $inputString);
    return $cleaned_Pass; 
}

#regex general 
function regex($inputString){
$regex = "/[^a-zA-Z0-9.:,-_ ]/"; 
$cleaned_string = preg_replace($regex, "", $inputString); 
return $cleaned_string;

}
?>  