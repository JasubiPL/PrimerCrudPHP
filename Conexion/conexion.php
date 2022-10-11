<?php

$servidor="mysql:dbname=empresa;host=127.0.0.1";//Se indica de donde la base de datos con la que se conectara
$usuario="root";//Se indica el usuario con el que iniciara secion
$password="";//se indica la contraseña con la que se iniciara secion, como no hay contraseña se deja en blanco sin espacios

try{//Permite conectar a la bd si no hay ingun error

    $pdo= new PDO($servidor,$usuario,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));// newPDO accede a la bd con la informacion de las variables
    //echo "Conectado...";
}
catch(PDOException $e){//Nos impedira entrar a la bd si hay algun error
    //PDOException es un metodo que nos insica la causa de la falla de conexion y lo almacenamos en la variable $e

    echo "Sin conexion. " . $e->getMessage();
    //con $e->getMessage() indicamos que nos muestre atravez de un mensaje el valor de $e
}

?>