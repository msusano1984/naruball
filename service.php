<?php

require_once("utils/ExcepcionApi.php");
require_once("utils/Utilerias.php");
require_once("vistas/VistaApi.php");
require_once("vistas/VistaJson.php");
require_once("vistas/VistaXML.php");
require_once("data/ConexionBD.php");
require_once("data/login_mysql.php");
require_once("controladores/feed_imagenes.php");
require_once("controladores/feed.php");
require_once("controladores/participantes.php");
require_once("controladores/usuarios.php");






$vista = new VistaJson();

set_exception_handler(function ($exception) use ($vista) {
        $cuerpo = array(
            "estados" => $exception->estados,
            "mensaje" => $exception->getMessage()
        );
        if ($exception->getCode()) {
            $vista->estados = $exception->getCode();
        } else {
            $vista->estados = 500;
        }

        $vista->imprimir($cuerpo);
    }
);


// Obtener recurso
//print $peticion;
//$recurso = array_shift($peticion);
//recursos_existentes = array('contactos', 'usuarios');

// Comprobar si existe el recurso




$metodo = strtolower($_SERVER['REQUEST_METHOD']);


$arreglo = explode('/', $_GET['PATH_INFO']);
$controlador = $arreglo[0];

$arreglo = array_pop($arreglo);
$arreglo = explode(' ',$arreglo);

switch ($metodo) {
    case 'get':
        break;

    case 'post':
        
        ejecutaModeloPost($vista, $controlador, $arreglo);
        
        break;

    case 'put':
        break;

    case 'delete':
        break;

    default:
        // Método no aceptado

}




function ejecutaModeloPost($vista, $controlador, $arr)
{

    switch (strtolower($controlador)) {
        case 'usuarios':

            $vista->imprimir(usuarios::post($arr));
            break;
       
        default:
            # code...
            break;
    }
}
