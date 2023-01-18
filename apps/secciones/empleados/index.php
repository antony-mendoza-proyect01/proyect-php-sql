<?php  include("../../bd.php");

if(isset($_GET['txtID'] )) {
 
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    //borrar archivo y saber cual es el archivo 

    //buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetchAll(PDO::FETCH_LAZY);

    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!="" ) {
       if (file_exists("./".$registro_recuperado["foto"])) {
           unlink("./".$registro_recuperado["foto"]);
        
       }
    }

    if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!="" ) {
        if (file_exists("./".$registro_recuperado["cv"])) {
            unlink("./".$registro_recuperado["cv"]);
         
        }
     }

//eliminar
    $sentencia = $conexion->prepare("DELETE FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);

    $sentencia->execute();
   
    $mensaje = "Registro Eliminado";
    header("Location:index.php?mensaje=".$mensaje);

    }
    
    $sentencia = $conexion->prepare("SELECT *,
    (SELECT nombre_puesto
     FROM  tbl_puestoss
     WHERE tbl_puestoss.id=tbl_empleados.id_puesto limit 1)as id_puesto
     FROM `tbl_empleados`");
    $sentencia->execute();
    
    $lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    
?>


<?php  include("../../templates/header.php"); ?>

<h4>Empleados</h4> 
<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar</a>
    </div>
    <div class="card-body">
    <div class="table-responsive-sm">
        <table class="table" id="tabla_id">
            <thead>
                <tr>
                <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Foto</th>
                    <th scope="col">CV</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Fecha de ingreso</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
             foreach($lista_tbl_empleados as $registro){?>

                <tr class="">
                <td ><?php echo $registro['id']; ?></td>
                <td  scope="row">
                <?php echo $registro['primer_nombre']; ?>
                <?php echo $registro['segundo_nombre']; ?>
                <?php echo $registro['primer_apellido']; ?>
                <?php echo $registro['segundo_apellido']; ?>
            </td>
                    <td> <img width="50"
                     src="<?php echo $registro['foto']; ?>"
                     class="img-fluid rounded" alt="">
                    </td>
                    <td>
                    <a href="<?php echo $registro['cv']; ?>">
                    <?php echo $registro['cv']; ?>
                    </a>
                </td>
                    <td> <?php echo $registro['id_puesto']; ?></td>
                    <td> <?php echo $registro['fecha_ingreso']; ?></td>
                    <td><a href="carta_recomendacion.php?txtID=<?php echo $registro['id']; ?>" class="btn btn-primary"  role="button">Carta</a> |
                    <a  class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                     |  
                     <a  class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>

                </td>
                <?php }?>  
            </tbody>
        </table>
    </div>
    </div>
    
</div>

<?php  include("../../templates/footer.php"); ?>