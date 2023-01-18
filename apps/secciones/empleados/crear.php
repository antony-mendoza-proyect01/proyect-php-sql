<?php  include("../../bd.php");

    if ($_POST) {
  print_r($_POST);
  print_r($_FILES);

  $primer_nombre = (isset($_POST["primer_nombre"]) ? $_POST["primer_nombre"] : "");
  $segundo_nombre = (isset($_POST["segundo_nombre"]) ? $_POST["segundo_nombre"] : "");
  $primer_apellido = (isset($_POST["primer_apellido"]) ? $_POST["primer_apellido"] : "");
  $segundo_apellido = (isset($_POST["segundo_apellido"]) ? $_POST["segundo_apellido"] : "");
  

  $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
  $cv = (isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");

  $id_puesto = (isset($_POST["id_puesto"]) ? $_POST["id_puesto"] : "");
  $fecha_ingreso = (isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : "");

  $sentencia = $conexion->prepare("INSERT INTO tbl_empleados (id, primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,foto,cv,id_puesto,fecha_ingreso)
    VALUES(null, :primer_nombre,:segundo_nombre,:primer_apellido,:segundo_apellido,:foto,:cv,:id_puesto, :fecha_ingreso )");

$sentencia->bindParam(":primer_nombre", $primer_nombre);
$sentencia->bindParam(":segundo_nombre", $segundo_nombre);
$sentencia->bindParam(":primer_apellido", $primer_apellido);
$sentencia->bindParam(":segundo_apellido", $segundo_apellido);

$fecha_=new DateTime();
//adjuntar fotos
$nombreArchivo_foto = ($foto != '')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name'] : "";

  $tmp_foto = $_FILES["foto"]['tmp_name'];
  if ($tmp_foto='') {
    move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
  }

$sentencia->bindParam(":foto", $nombreArchivo_foto);

//adjuntar archivo
$nombreArchivo_cv = ($cv != '')?$fecha_->getTimestamp()."_".$_FILES["cv"]['name'] : "";

  $tmp_cv = $_FILES["cv"]['tmp_name'];
  if ($tmp_cv='') {
    move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
  }
$sentencia->bindParam(":cv", $nombreArchivo_cv);
$sentencia->bindParam(":id_puesto", $id_puesto);
$sentencia->bindParam(":fecha_ingreso", $fecha_ingreso);
$sentencia->execute();



    }
// buscar
$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestoss`");
$sentencia->execute();
$lista_tbl_puestoss = $sentencia->fetchAll(PDO::FETCH_ASSOC);


?>

<?php  include("../../templates/header.php"); ?>

<br/>

<div class="card">
    <div class="card-header">
     Datos del Empleado
    </div>
    <div class="card-body">

    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="primer_nombre" class="form-label">Primer Nombre</label>
      <input type="text"
        class="form-control" name="primer_nombre" id="primer_nombre" aria-describedby="helpId" placeholder="Primer Nombre">
    </div>

 <div class="mb-3">
   <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
   <input type="text"
     class="form-control" name="segundo_nombre" id="segundo_nombre" aria-describedby="helpId" placeholder="Segundo Nombre">
 </div>

 <div class="mb-3">
   <label for="primer_apellido" class="form-label">Primer Apellido</label>
   <input type="text"
     class="form-control" name="primer_apellido" id="primer_apellido" aria-describedby="helpId" placeholder="Primer Apellido">
 </div>

 
 <div class="mb-3">
   <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
   <input type="text"
     class="form-control" name="segundo_apellido" id="segundo_apellido" aria-describedby="helpId" placeholder="Segundo Apellido">
 </div>

 <div class="mb-3">
   <label for="foto" class="form-label">Foto</label>
   <input type="file"
     class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
 </div>

 <div class="mb-3">
   <label for="cv" class="form-label">CV: (PDF)</label>
   <input type="file"
     class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
 </div>

<div class="mb-3">
    <label for="id_puesto" class="form-label">Puesto: </label>
    <select class="form-select form-select-sm" name="id_puesto" id="id_puesto">
    <?php foreach($lista_tbl_puestoss as $registro){?>
      
        <option value=""> <?php echo $registro ['id'] ?>
        <?php echo $registro ['nombre_puesto'] ?> </option>
  
        <?php }?> 
        
    </select>

</div>

<div class="mb-3">
  <label for="fecha_ingreso" class="form-label">Fecha de ingreso: </label>
  <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso ">
</div>

<button type="submit" class="btn btn-success">Agregar Registro</button>
<a name="" id="" class="btn btn-info" href="index.php" role="button">Volver</a>


    </form>
    </div>
</div>




<?php  include("../../templates/footer.php"); ?>