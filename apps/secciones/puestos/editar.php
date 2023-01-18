<?php
include("../../bd.php");

if(isset($_GET['txtID'] )) {
 
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestoss` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto = $registro["nombre_puesto"];

    }
if ($_POST) {
    print_r($_POST);
    //recolectamos los datos del metodo POST
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $nombredelpuesto = (isset($_POST["nombre_puesto"]) ? $_POST["nombre_puesto"] : "");
    //preparar la inserccion de los datos
    $sentencia = $conexion->prepare("UPDATE  tbl_puestoss SET  nombre_puesto=:nombre_puesto
    where id=:id");
    //asignando los valores que vienen del metodo POST (formularios)
    $sentencia->bindParam(":nombre_puesto", $nombredelpuesto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro Actualizado";
    header("Location:index.php?mensaje=".$mensaje);


}


?>



<?php  include("../../templates/header.php"); ?>
<?php if(isset($_GET['mensaje'])){?>
<script>
    Swal.fire({icon:"success", title:"<?php$_GET['mensaje']; ?>"});
</script>
<?php } ?>

<br/> 

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
 
    <form action="" method="post" enctype="multipart/form-data">

     <div class="mb-3">
       <label for="txtID" class="form-label">ID</label>
       <input type="text"
       value="<?php echo $txtID;?>"
         class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
     </div>

<div class="mb-3">
  <label for="nombre_puesto" class="form-label">Nombre del puesto:</label>
  <input type="text"
  value="<?php echo $nombredelpuesto;?>"
    class="form-control" name="nombre_puesto" id="nombre_puesto" aria-describedby="helpId" placeholder="Nombre del puesto">
 </div>
 
 <button type="submit" class="btn btn-success">Actualizar</button>
 |
 <a name="" id="" class="btn btn-primary" href="index.php" role="button">Volver</a>
    </form>
    </div>
 
</div>

<?php  include("../../templates/footer.php"); ?>