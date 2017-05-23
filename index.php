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



$_POST["data"] = new feed_imagenes ("12", "178516459324845_184281512081673", "https://scontent.xx.fbcdn.net/v/t1.0-9/17626241_10212632101263439_7325447554296829101_n.jpg?oh=3235d62ca45e22712aba8f94bec0fca8&oe=59B0CB1B");

 //$_POST = array("admin"=>1, "nombre"=>"Caro", "	"=>"3");
 //$_POST = array("fecha_evento"=>"2017-05-20", "id_post"=> "3333333333","tipo_posteo"=>"video", "estatus"=>0);
 //print_r($_POST);


$arr = array("insertar");
$vista = new VistaJson();
print_r($vista->imprimir(feed_imagenes::post($arr)));





?>
