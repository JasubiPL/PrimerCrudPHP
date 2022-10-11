<?php
   /* echo $_POST["id"] . "<br>";
    echo $_POST["nombre"] . "<br>";
    echo $_POST["apellidop"] . "<br>";
    echo $_POST["apellidom"] . "<br>";
    echo $_POST["correo"] . "<br>";*/

    //Declaramos una variable "$id" y atravez de (isset($_POST["id"]))? comprobamos si el imput con el id "id"
    //Contiene algun valor o esta en blanco, 
    //con $_POST["id"]:"";indicamos que si el input tiene valor, lo asigne a la variable "$id"
    //de lo contrario si esta vacia, le asigne un valor nulo
    $id=(isset($_POST["id"]))?$_POST["id"]:"";
    $nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
    $apellidop=(isset($_POST["apellidop"]))?$_POST["apellidop"]:"";
    $apellidom=(isset($_POST["apellidom"]))?$_POST["apellidom"]:"";
    $correo=(isset($_POST["correo"]))?$_POST["correo"]:"";
    $foto=(isset($_FILES["foto"]["name"]))?$_FILES["foto"]:"";//$_FILES es el metodo para enviar fotos
    $accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    //VAriables para activar y desactivar botones
    $accionAgregar="";
    $accionModificar=$accionEliminar=$accionCancelar="disabled";//El valor "Desabled desabilita boton"
    $mostrarModal=false;

    include("../Conexion/conexion.php");//Traemos la conexin creada a con la bd en el archivo "coenxion.php"

    switch($accion){//pasamos como parametro al swich el valor de la variable $accion dependiendo el boton que toques
        case "Agregar"://Indicamos que funcion se realizara en caso de que el valor sea "Agregar"

            $sentencia=$pdo->prepare("INSERT INTO empleados(Nombre,Apellidop,Apellidom,Correo,Foto)
            VALUES (:Nombre,:Apellidop,:Apellidom,:Correo,:Foto)");//Accedemos al valor de las columnas en la tabla empleados para insertarlo en la bd

            $sentencia->bindParam(":Nombre",$nombre);//Pasamos el valor capturado del input con la variable "$nombre"
            //a la bd atravez de el parametro ":Nombre" ligado a la columna "Nombre"
            $sentencia->bindParam(":Apellidop",$apellidop);
            $sentencia->bindParam(":Apellidom",$apellidom);
            $sentencia->bindParam(":Correo",$correo);

            $fecha=new DateTime();//Capturamos la fecha de carga de la foto
            $nombreArchivo=($foto=!"")?$fecha->getTimestamp()."_".$_FILES["foto"]["name"]:"Perfil.jpg";
            //Creamos una variable para asiganar el nombre a la foto,
            //Usamos "($foto!="")?" para preguntar si hay alguna foto seleccionada
            //Usamos "$fecha->getTimestamp()"para trae la fecha con ms en que se cargo la foto
            //con ."_". Le concatebnamos un guin bajo al a la fecha
            //usamos "$_FILES["foto"]["name"]" para concatenarle el nombre de la foto
            //De esta manera le damos un nombre al archivo unico concatenando la fecha de carga con el nombre de el archivo
            //para que no se duplique la foto en caso de que ya exista y la tome algun otro registro
            //Finalmente usamos ":"Perfil.jpg"" para que en caso de que el usuario no suba foto, se cargue la foto por
            //defaul que asignamos nosotros.

            $tmpFoto=$_FILES["foto"]["tmp_name"];//creamos una vaiable para acceder al nombre temporal que le da php a la foto cargada

            if($tmpFoto!=""){//Comprueva si hay una foto cargada usando el nombre temporal asignado por php
                move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);//Si lo hay, mueve la foto a la direccion especificada
            }
            else{
                $nombreArchivo="Perfil.jpg";
            }


            $sentencia->bindParam(":Foto",$nombreArchivo);//Seleccionamos la foto atravez de el nombre creado
            $sentencia->execute();//Se ejecutan las instrucciones sql creadas

            header("Location: index.php");//Redireccionamos a la pagina "index.php" para que no se reenvie el formulario

            //echo "Presionaste Agregar";
        break;//Se termina la 
        
        case "Borrar":
            //Borramos la foto existente del registro
            $sentencia=$pdo->prepare("SELECT Foto FROM empleados WHERE ID=:ID");//Selecciona la foto del registro seleccionado
            $sentencia->bindParam("ID",$id);
            $sentencia->execute();
            $empleadoFoto=$sentencia->fetch(PDO::FETCH_LAZY);//Me da el valor almacenado en la variable $sentencia
            print_r($empleadoFoto);

            if(isset($empleadoFoto["Foto"])){//Pregunta su hay una foto
                if(file_exists("../Imagenes/".$empleadoFoto["Foto"])){//Pregunta si hay alguna foto con en nombre de la foto actual en el registro
                    if($empleadoFoto["Foto"]!="Perfil.jpg"){//Si la foto no tiene el nombre "Perfil.jpg"
                        unlink("../Imagenes/".$empleadoFoto["Foto"]);//Elimina la foto que coincida con el mombre de la foto actual
                    }

                }
                
            }
            
            //Borramos los registros completos
            $sentencia=$pdo->prepare("DELETE FROM empleados WHERE ID=:ID");//Borrar registro tomando de referencia el ID
            $sentencia->bindParam("ID",$id);
            $sentencia->execute();

            header("Location: index.php");

            //echo "Presionaste Borrar";
        break;

        case "Modificar":
            //UPDATE y SET Sirven para actualizar los datos modificados en los registros
            $sentencia=$pdo->prepare("UPDATE empleados SET 
            Nombre=:Nombre,
            Apellidop=:Apellidop,
            Apellidom=:Apellidom,
            Correo=:Correo WHERE
            ID=:ID");

            $sentencia->bindParam(":Nombre",$nombre);
            $sentencia->bindParam(":Apellidop",$apellidop);
            $sentencia->bindParam(":Apellidom",$apellidom);
            $sentencia->bindParam(":Correo",$correo);
            $sentencia->bindParam(":ID",$id);
            $sentencia->execute();
            
            //Traemos de nuevo estos parametros para podificar la foto agregada con anterioridad
            //cambiando lo siguiente
            $fecha=new DateTime();
            $nombreArchivo=($foto=!"")?$fecha->getTimestamp()."_".$_FILES["foto"]["name"]:"Perfil.jpg";

            $tmpFoto=$_FILES["foto"]["tmp_name"];//creamos una vaiable para acceder al nombre temporal que le da php a la foto cargada

            if($tmpFoto!=""){
                move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);

                //Borramos la foto existente del registro para remplasarla
                $sentencia=$pdo->prepare("SELECT Foto FROM empleados WHERE ID=:ID");//Selecciona la foto del registro seleccionado
                $sentencia->bindParam("ID",$id);
                $sentencia->execute();
                $empleadoFoto=$sentencia->fetch(PDO::FETCH_LAZY);//Me da el valor almacenado en la variable $sentencia
                print_r($empleadoFoto);

                if(isset($empleadoFoto["Foto"])){//Pregunta su hay una foto
                    if(file_exists("../Imagenes/".$empleadoFoto["Foto"])){//Pregunta si hay alguna foto con en nombre de la foto actual en el registro
                        if($empleadoFoto["Foto"]!="Perfil.jpg"){//Si la foto no tiene el nombre "Perfil.jpg"
                            unlink("../Imagenes/".$empleadoFoto["Foto"]);//Elimina la foto que coincida con el mombre de la foto actual
                        }
    
                    }
                    
                }

                //Aremos la misma validacion solo que con la foto aparte para poder
                //acceder al varor de foto y modificarla
                $sentencia=$pdo->prepare("UPDATE empleados SET
                Foto=:Foto WHERE ID=:ID");

                $sentencia->bindParam("Foto",$nombreArchivo);//Colocamos "$nombreArchivo" para capturar y modificar el valor actual
                //de la variable y modificarlo con los datos de la nueva foto
                $sentencia->bindParam("ID",$id);
                $sentencia->execute();
            }
            else{
                $nombreArchivo="Perfil.jpg";
            }
            
            header("Location: index.php");//Redireccionamos a la pagina "index.php" para que no se reenvie el formulario

            //echo "Presionaste Modificar";
        break;

        case "Cancelar";
            header("Location: index.php");
            //echo "Presionaste Cancelar";
        break;
        case "Seleccionar":
            $accionAgregar="disabled";
            $accionModificar=$accionEliminar=$accionCancelar="";
            $mostrarModal=true;

            //Traemos los valores de la bace de datos tomando de referencia el ID
            //y los mostramos en el formulario para modificarlos
            $sentencia=$pdo->prepare("SELECT * FROM empleados WHERE ID=:ID");
            $sentencia->bindParam("ID",$id);
            $sentencia->execute();
            $empleado=$sentencia->fetch(PDO::FETCH_LAZY);

            $nombre=$empleado["Nombre"];
            $apellidop=$empleado["Apellidop"];
            $apellidom=$empleado["Apellidom"];
            $correo=$empleado["Correo"];
            $foto=$empleado["Foto"];
        break;

        
    }

        $sentencia=$pdo->prepare("SELECT * FROM `empleados` WHERE 1");//Accedemos a la informacion contenida en la bd
        $sentencia->execute();
        $listaEmpleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);//almacenamos los datos traidos de la bd
        //con el objeto "$sentencia" a la variable "$listaEmpleados"

       // print_r($listaEmpleados);
    ?>