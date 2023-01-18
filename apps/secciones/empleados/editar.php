<?php include("../../bd.php");

if(isset($_GET['txtID'] )) {
 
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $primernombre = $registro["primer_nombre"];
    $segundonombre = $registro["segundo_nombre"];
    $primerapellido = $registro["primer_apellido"];
    $segundoapellido = $registro["segundo_apellido"];
    
    $foto = $registro["foto"];
    $cv = $registro["cv"];

    $idpuesto = $registro["id_puesto"];
    $fechaingreso = $registro["fecha_ingreso"];


    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestoss`");
    $sentencia->execute();
    $lista_tbl_puestoss = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    if ($_POST) {
     
    
      $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
      $primernombre = (isset($_POST["primer_nombre"]) ? $_POST["primer_nombre"] : "");
      $segundonombre = (isset($_POST["segundo_nombre"]) ? $_POST["segundo_nombre"] : "");
      $primerapellido = (isset($_POST["primer_apellido"]) ? $_POST["primer_apellido"] : "");
      $segundoapellido = (isset($_POST["segundo_apellido"]) ? $_POST["segundo_apellido"] : "");
      
      $idpuesto = (isset($_POST["id_puesto"]) ? $_POST["id_puesto"] : "");
      $fechaingreso = (isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : "");
    
      $sentencia = $conexion->prepare("UPDATE tbl_empleados 
      SET
        primer_nombre=:primer_nombre,
        segundo_nombre=:segundo_nombre,
        primer_apellido=:primer_apellido,
        segundo_apellido=:segundo_apellido,
        id_puesto=:id_puesto,
        fecha_ingreso=:fecha_ingreso,
       WHERE  id=id");
    
    $sentencia->bindParam(":primer_nombre", $primernombre);
    $sentencia->bindParam(":segundo_nombre", $segundonombre);
    $sentencia->bindParam(":primer_apellido", $primerapellido);
    $sentencia->bindParam(":segundo_apellido", $segundoapellido);
    $sentencia->bindParam(":id_puesto", $idpuesto);
    $sentencia->bindParam(":fecha_ingreso", $fechaingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    
    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    
    $fecha_=new DateTime();
    $nombreArchivo_foto = ($foto != '')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name'] : "";
    
      $tmp_foto = $_FILES["foto"]['tmp_name'];
      if ($tmp_foto='') {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
//buscamos la foto
           $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=id");
           $sentencia->bindParam(":id",$txtID);
           $sentencia->execute();
           $registro_recuperado = $sentencia->fetchAll(PDO::FETCH_LAZY);
    
           if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!="" ) {
           if (file_exists("./".$registro_recuperado["foto"])) {
            //borramos el registro
               unlink("./".$registro_recuperado["foto"]);
           }
        }
        //actualizamos la foto 
        $sentencia = $conexion->prepare("UPDATE tbl_empleados  SET foto=:foto WHERE  id=:id");
        $sentencia->bindParam(":foto", $nombreArchivo_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
      }
 

    $cv = (isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");

    $nombreArchivo_cv = ($cv != '')?$fecha_->getTimestamp()."_".$_FILES["cv"]['name'] : "";
    $tmp_cv = $_FILES["cv"]['tmp_name'];
    if ($tmp_cv='') {
      move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);

      //buscamos la arhivo
      $sentencia = $conexion->prepare("SELECT cv FROM `tbl_empleados` WHERE id=id");
      $sentencia->bindParam(":id",$txtID);
      $sentencia->execute();
      $registro_recuperado = $sentencia->fetchAll(PDO::FETCH_LAZY);
//recuperamos registro
      if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!="" ) {
        if (file_exists("./".$registro_recuperado["cv"])) {
            unlink("./".$registro_recuperado["cv"]);
        }
     }
    //actualizamos la archivo
    $sentencia = $conexion->prepare("UPDATE tbl_empleados  SET cv=:cv WHERE  id=:id");
    $sentencia->bindParam(":cv", $nombreArchivo_cv);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
     
    }
  header("location:index.php");
  }


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
       <label for="txtID" class="form-label">ID</label>
       <input type="text"
       value="<?php echo $txtID;?>"
         class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
     </div>

    <div class="mb-3">
      <label for="primer_nombre" class="form-label">Primer Nombre</label>
      <input type="text"
      value="<?php echo $primernombre;?>"
        class="form-control" name="primer_nombre" id="primer_nombre" aria-describedby="helpId" placeholder="Primer Nombre">
    </div>

 <div class="mb-3">
   <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
   <input type="text"
   value="<?php echo $segundonombre;?>"
     class="form-control" name="segundo_nombre" id="segundo_nombre" aria-describedby="helpId" placeholder="Segundo Nombre">
 </div>

 <div class="mb-3">
   <label for="primer_apellido" class="form-label">Primer Apellido</label>
   <input type="text"
   value="<?php echo $primerapellido;?>"
     class="form-control" name="primer_apellido" id="primer_apellido" aria-describedby="helpId" placeholder="Primer Apellido">
 </div>

 
 <div class="mb-3">
   <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
   <input type="text"
   value="<?php echo $segundoapellido;?>"
     class="form-control" name="segundo_apellido" id="segundo_apellido" aria-describedby="helpId" placeholder="Segundo Apellido">
 </div>

 <div class="mb-3">
   <label for="foto" class="form-label">Foto</label>
 <br/>
  <img width="100" src="<?php echo $foto; ?>"
                     class=" rounded" alt="">
                     <br/><br/>
   <input type="file"
     class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
 </div>

 <div class="mb-3">
   <label for="cv" class="form-label">CV: (PDF)</label>
<br/>
   <a href="<?php echo $cv;?>"><?php echo $cv;?></a>
   <input type="file"
     class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
 </div>

<div class="mb-3">
    <label for="id_puesto" class="form-label">Puesto: </label>
    <select class="form-select form-select-sm" name="id_puesto" id="id_puesto">
    <?php foreach($lista_tbl_puestoss as $registro){?>
      
        <option <?php echo ($idpuesto == $registro['id']) ? "selected" : ""; ?> value ="<?php echo $registro ['id'] ?>">
        <?php echo $registro ['nombre_puesto'] ?>
       </option>
        <?php }?> 
        
    </select>

</div>

<div class="mb-3">
  <label for="fecha_ingreso" class="form-label">Fecha de ingreso: </label>
  <input type="date"
  value="<?php echo $fechaingreso;?>"
   class="form-control" name="fecha_ingreso" id="fecha_ingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso ">
  
</div>

<button type="submit" class="btn btn-success">Actualizar Registro</button>
<a name="" id="" class="btn btn-info" href="index.php" role="button">Volver</a>


    </form>
    </div>
</div>


<?php  include("../../templates/footer.php"); ?>