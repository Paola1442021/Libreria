<?php
class conexion{
    private $servidor="localhost";
    private $usuario="root";
    private $contrasenia="";
    private $conexion;

    public function __construct(){
        try{
            $this->conexion = new PDO("mysql:host=$this->servidor;dbname=libreria",$this->usuario,$this->contrasenia);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            return "falla de conexion".$e;
        }
    }
    public function ejecutar($sql){
        try {
            $this->conexion->exec($sql);
            return $this->conexion->lastInsertID();
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
    }
    
    public function consultar($sql){
        try {
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll();
        } catch (PDOException $e) {
            echo "Error al consultar la base de datos: " . $e->getMessage();
        }
    }

    public function consultarConParametro($sql, $params = array()) {
        try {
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute($params);
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al consultar la base de datos: " . $e->getMessage());
        }
    }
    public function prepare($sql) {
        return $this->conexion->prepare($sql);
    }
    
}