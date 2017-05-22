<?php

class usuarios
{

	public function __construct($admin = "", $nombre = "", $id_usuario = 0, $estatus = 0)

	{
		$this->admin = $admin;
        $this->nombre = $nombre;
        $this->id_usuario = $id_usuario;
        $this->estatus = $estatus;
	}

	// Datos de la tabla "usuarios"
    const NOMBRE_TABLA = "usuarios";

    const ADMIN = "admin";
    const NOMBRE = "nombre";
    const ID_USUARIO = "id_usuario";
    const ESTATUS = "estatus";
    const ESTADO_URL_INCORRECTA = "url_incorrecta";
    const ESTADO_CREACION_EXITOSA = "OK";
    const ESTADO_CREACION_FALLIDA = "ERROR";

	public static function post($peticion)
    {

        if ($peticion[0] == 'registro') {
            return self::crear();
        }
        else if ($peticion[0] == "crearusuarios")
        {
            return self::crearUsuarios($_POST);

        }   
        else if ($peticion[0] == "listar")
        {
            return self::listar($_POST);

        } else {
            throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, "Url mal formada", 400);
        }
    }   

    private function crearUsuarios($usuarios){


        $usuarios = json_decode($usuarios["data"]);


        try{
            foreach($usuarios as $row){
              

                self::crear($row);  
            }
            return true;

        }catch (PDOException $e) {

            return false;
        }
        
    }
    
    private function crear($usuario)
    {



        try {

            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia INSERT
            $comando = "INSERT INTO " . self::NOMBRE_TABLA . " ( " .
                self::ADMIN . "," .
                self::NOMBRE . "," .
                self::ID_USUARIO . "," .
                self::ESTATUS . ")" .
                " VALUES(?,?,?,?)";

            $estatus = 1;
       
            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, intval($usuario->administrator));

            $sentencia->bindParam(2, $usuario->name);

            $sentencia->bindParam(3, $usuario->id);

            $sentencia->bindParam(4, $estatus);
             
                        
            $resultado = $sentencia->execute();


            if ($resultado) {
                return true;
                
              
            } else {
              
                return false;
            }
        } catch (Exception $e) {

            //throw new ExcepcionApi(self::ESTADO_URL_INCORRECTA, $e->getMessage(), 400);
echo $e->getMessage();
            return false;
        }

    }
   
   
    private function listar($usuarios){

      //  $idpost = $feed[self::POST_ID];

        if($_GET['id_usuario']==    '0'){
            $comando = "SELECT ".self::ADMIN . ",".self::NOMBRE .",".self::ID_USUARIO .",".self::ESTATUS ." from ".self::NOMBRE_TABLA;
        }else {
           $comando = "SELECT ".self::ADMIN . ",".self::NOMBRE .",".self::ID_USUARIO ." from ".self::NOMBRE_TABLA ." where ".self::ID_USUARIO . " = ? "; 
        }
        
        print_r($comando);
        $sentencia = ConexionBD::obtenerInstancia()->obtenerBD()->prepare($comando);
        
        $sentencia->bindParam(1, $_GET['id_usuario']);
        
        if ($sentencia->execute())
        {
            return  $sentencia->fetchall(PDO::FETCH_ASSOC);

            

        }else{
            return "error";
        }
    }
}