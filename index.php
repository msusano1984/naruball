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

//$_POST = array("admin"=>1, "nombre"=>"Caro", "	"=>"3");
//print_r($_POST);

$arr = array("listar");


$vista = new VistaJson();

	$vista->imprimir(usuarios::post($arr));



?>
