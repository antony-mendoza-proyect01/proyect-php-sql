<?php
include("../../bd.php");

if ($_POST) {
    print_r($_POST);
    //recolectamos los datos del metodo POST
    $nombredelpuesto = (isset($_POST["nombre_puesto"]) ? $_POST["nombre_puesto"] : "");
    //preparar la inserccion de los datos
    $sentencia = $conexion->prepare("INSERT INTO tbl_puestoss(id, nombre_puesto)
    VALUES(null, :nombre_puesto)");
    //asignando los valores que vienen del metodo POST (formularios)
    $sentencia->bindParam(":nombre_puesto", $nombredelpuesto);
    $sentencia->execute();
    $mensaje = "Registro Agregado";
    header("location:index.php?mensaje=".$mensaje);


}


?>


<?php  include("../../templates/header.php"); ?>

<br/> 

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
 
    <form action="" method="post" enctype="multipart/form-data">
    
<div class="mb-3">
  <label for="nombre_puesto" class="form-label">Nombre del puesto:</label>
  <input type="text"
    class="form-control" name="nombre_puesto" id="nombre_puesto" aria-describedby="helpId" placeholder="Nombre del puesto">
</div>
<button type="submit" class="btn btn-success">Agregar</button>
<a name="" id="" class="btn btn-primary" href="index.php" role="button">Volver</a>
    </form>
    </div>
 
</div>

<?php  include("../../templates/footer.php"); ?>