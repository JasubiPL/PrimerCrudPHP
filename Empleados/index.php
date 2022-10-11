<?php
    require "main.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>    
    <div class="container py-2">
        <h1 class="text-center">Primera BD con PHP y MySQL</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <!--enctype="multipart/form-data" sirve para leer las imagenes enviadas a la bd
            asi como (value="<?php //echo $id?>") nos muestra la informacion que seleccionamos 
            al precionar el boton "Seleccionar" para poderla modificar-->

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Empleado</h5>
                            <button id="modale-close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                            <input type="hidden" require="" value="<?php echo $id?>" name="id" id="id">

                            <div class="form-group col-md-4">
                            <label for="">Nombre(s):</label>
                            <input type="text" class="form-control" require value="<?php echo $nombre?>" name="nombre" id="nombre">
                            </div>    
                            
                            <div class="form-group col-md-4">
                            <label for="">Apellido Paterno:</label>
                            <input type="text" class="form-control" require value="<?php echo $apellidop?>" name="apellidop" id="apellidop">
                            </div>

                            <div class="form-group col-md-4">
                            <label for="">Apellido Materno:</label>
                            <input type="text" class="form-control" require value="<?php echo $apellidom?>" name="apellidom" id="apellidom">
                            </div>

                            <div class="form-group col-md-12">
                            <label for="">Correo:</label>
                            <input type="email" class="form-control" require value="<?php echo $correo?>" name="correo" id="correo">
                            </div> 

                            <div class="form-group col-md-12">
                            <label for="">Subir Foto:</label>
                            <?php if($foto){?>
                                <br>
                                <img class="img-thumbnail rounded mx-auto d-block" width="200px" src="../Imagenes/<?php echo $foto;?>">
                                <br>
                            <?php }?>
                            <input type="file" class="form-control" accept="image/*" value="<?php echo $foto;?>" name="foto" id="foto">
                            </div> 

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button class="btn btn-success" <?php echo $accionAgregar;?> value="Agregar" type="submit" name="accion">Agregar</button>
                            <button class="btn btn-danger" <?php echo $accionEliminar;?> value="Borrar" type="submit" name="accion">Borrar</button>
                            <button class="btn btn-warning" <?php echo $accionModificar;?> value="Modificar" type="submit" name="accion">Modificar</button>
                            <button class="btn btn-dark" <?php echo $accionCancelar;?> value="Cancelar" type="submit" name="accion">Cancelar</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Agregar registro
            </button>

            
        </form>

        <div class="row">
            <table class="table table-striped table-hover text-center align-item-center">
                <thead class="table-dark">
                    <tr>
                        <th class="">Foto</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Acciones</th>   
                    </tr>
                </thead>
            <?php foreach($listaEmpleados as $empleado){ ?><!--traemos el array con la info de la bd y la almacenamos en "$empleados"-->
            
                <tr>
                    <!--accedemos al valor almacenado en las columnas-->
                    <!--En el caso de la foto se agrega la etiqueta "Img" para agregar la foto a la columna
                    y en la direccion de la imagen por deafuel que aparecera en caso de que el 
                    usuario no suba una foto de perfil-->
                    <td><img  class="img-thumbnail" width="100px" src="../Imagenes/<?php echo $empleado["Foto"];?>"/></td>
                    <td><?php echo $empleado["Nombre"];?> <?php echo $empleado["Apellidop"];?> <?php echo $empleado["Apellidom"];?></td>
                    <td><?php echo $empleado["Correo"];?></td>
                    <td>
                        <!--Estamos enviando la informacion de un formulario a otro para poder 
                        modificar los datos de la BD-->
                        <form action="" method="POST">

                            <input type="hidden" name="id" value="<?php echo $empleado["ID"];?>">
                            
                            <input class="btn btn-info" type="submit" value="Seleccionar" name="accion">
                            <button class="btn btn-danger" value="Borrar" type="submit" name="accion">Borrar</button>
                        
                        </form>
                    </td>
                </tr>

            <?php }?>
            </table>
        </div>
    </div>


<?php if($mostrarModal){//Preguntamos si el modal se muestra, por defecto esta en false?>
    <script>
        let modal = document.getElementById("staticBackdrop");//Con JS accedemos al modal atravez de su id y lo mostramos
        let modaleClose = document.getElementById("modale-close");

        modaleClose.style.display="none";
        modal.style.display="block";
        modal.style.opacity=1;
        modal.className +=" show";//Añadimos la clase show de Bootstrap para mostrar el modal
        modal.style.backgroundColor= "rgba(0,0,0, 0.3)";

    </script>
<?php }?>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>


