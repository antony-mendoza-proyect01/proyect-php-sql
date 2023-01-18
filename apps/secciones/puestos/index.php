<?php
include("../../bd.php");

//eliminar
if(isset($_GET['txtID'] )) {
 
$txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

$sentencia = $conexion->prepare("DELETE FROM `tbl_puestoss` WHERE id=:id");
$sentencia->bindParam(":id",$txtID);
$sentencia->execute();
$mensaje = "Registro Eliminado";
header("Location:index.php?mensaje=".$mensaje);
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
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar</a>
    </div>
    <div class="card-body">
    <div class="table-responsive-sm">
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre del puesto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
       
      
        <tbody>
        <?php
             foreach($lista_tbl_puestoss as $registro){?>

<tr class="">
                <td scope="row"><?php echo $registro['id']; ?></td>
                <td><?php echo $registro['nombre_puesto']; ?></td>
                <td>
                <a  class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                    |
                    <a  class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>

            </td>
            </tr>
<?php }?>     
        </tbody>
    </table>
</div>
    </div>
</div>



<?php  include("../../templates/footer.php"); ?>