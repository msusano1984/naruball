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



$_POST["data"] =json_encode(array(new feed ( "2017-04-06T05:08", 1, "017-05-19", "178516459324845_184281512081673", "Holaaaaaa", "rifa", "http://google.com", 1 )));

 //$_POST = array("admin"=>1, "nombre"=>"Caro", "	"=>"3");
 //$_POST = array("created_time"=>1, "created_usuario_id"=>"2", "fecha_evento"=>"19_05_17", "id_post"=> "3333333666333", "mensaje"=>"Holaaa","tipo_posteo"=>"rifa");
 //print_r($_POST);


$arr = array("guardaFeed");
$vista = new VistaJson();
print_r($vista->imprimir(feed::post($arr)));





?>
