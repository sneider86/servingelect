<?php
$archivo = $_FILES["archivo"];
$resultado = move_uploaded_file($archivo["tmp_name"], $archivo["name"]);
if ($resultado) {
    echo "Subido con éxito  ".$archivo["name"];
} else {
    echo "Error al subir archivo";
}