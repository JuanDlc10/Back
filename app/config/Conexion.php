<!-- //app es el cerebro del sistema -->
<!-- La carpeta config se guarda toda la configuracion del proyecto -->
<!-- Que es pdo -->
<!-- TAREA Hacer actualizacion eliminar, e insertar -->
<?php

use FTP\Connection;

require_once realpath('../../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();
define('SERVER', $_ENV['HOST']);
define('USER', $_ENV['USER']);
define('PASSWORD', $_ENV['PASSWORD']);
define('DB', $_ENV['DB']);
define('PORT', $_ENV['PORT']);
class Conexion
{
    private static $conexion;
    public static function abrir_conexion()
    {
        if (!isset(self::$conexion)) {
            try {
                self::$conexion = new PDO('mysql:host=' . SERVER . ';dbname=' . DB, USER, PASSWORD);
                self::$conexion->exec('SET CHARACTER SET utf8');
                return self::$conexion;
            } catch (PDOException $e) {
                echo 'Error en la conexion de base de datos: ' . $e;
                die();
            }
        } else {
            return self::$conexion;
        }
    }
    public static function obtener_conexion()
    {
        $conexion = self::abrir_conexion();
        return $conexion;
    }
    public static function cerrar_conexion()
    {
        self::$conexion = null;
    }
}


class Crud
{
    public static function mostrar_datos()
    {
        $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM t_prueba");
        if (!$consulta->execute()) {
            echo 'No se pudo realizar la consulta';
        } else {
            $dato = $consulta->fetchAll(PDO::FETCH_ASSOC);
            echo print_r($dato);
            echo 'Se completo la peticion';
        }
    }
    public static function insertar_datos()
    {
        $peticion = Conexion::obtener_conexion()->prepare("INSERT INTO t_prueba (nombre) VALUES ('Alejandro')");
        if (!$peticion->execute()) {
            echo 'No se pudo realizar la inserción';
        } else {
            echo 'Se completó la inserción de datos';
        }
    }
    public static function editar_datos()
    {
        $id = 5;
        $nuevo_nombre = 'Pamfilo';

        $peticion = Conexion::obtener_conexion()->prepare("UPDATE t_prueba SET nombre = :nuevo_nombre WHERE id = :id");
        $peticion->bindParam(':nuevo_nombre', $nuevo_nombre, PDO::PARAM_STR);
        $peticion->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$peticion->execute()) {
            echo 'No se pudo realizar la actualización';
        } else {
            echo 'Se completó la actualización de datos';
        }
    }
    public static function eliminar_datos()
    {
        $id = 5;
        $peticion = Conexion::obtener_conexion()->prepare("DELETE FROM t_prueba WHERE id = :id");
        $peticion->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$peticion->execute()) {
            echo 'No se pudo realizar la eliminación';
        } else {
            echo 'Se completó la eliminación de datos';
        }
    }
}
/* Crud::insertar_datos(); */
/* Crud::editar_datos(); */
/* Crud::eliminar_datos(); */
Crud::mostrar_datos();
?>