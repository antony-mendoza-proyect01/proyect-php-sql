 <?php include("../../bd.php");
 if(isset($_GET['txtID'] )) {
 
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    
    $sentencia = $conexion->prepare("SELECT  *,(SELECT nombre_puesto
    FROM  tbl_puestoss
    WHERE tbl_puestoss.id=tbl_empleados.id_puesto limit 1) as puesto  FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute(); 
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $primernombre = $registro["primer_nombre"];
    $segundonombre = $registro["segundo_nombre"];
    $primerapellido = $registro["primer_apellido"];
    $segundoapellido = $registro["segundo_apellido"];

     $nombreCompleto = $primernombre . "" . $segundonombre . "" . $primerapellido . "" . $segundoapellido;
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["id_puesto"];
    $puesto = $registro["puesto"];
    $fechaingreso = $registro["fecha_ingreso"];


     $fechaInicio = new DateTime($fechaingreso);
     $fechaFin = new DateTime(date('y-m-d'));
     $diferencia = date_diff($fechaInicio, $fechaFin);

    }
 ob_start(); 
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendacion</title>
 </head>
 <body>
    <h1>Carta de Recomendacion</h1>
    <br/> <br/>
    Barranquilla, Colombia a <strong><?php echo date('d-m-y') ?></strong>
    <br/> <br/>
    A quien pueda interesar:
    <br/> <br/>
    Reciba un cordial saludo y respetuoso saludo.
    <br/> <br/>

   <p>
   A traves de esta linea desdee hacer de su conocimiento que Sr(a) <strong><?php echo $nombreCompleto; ?> </strong>,
    quien laboro en mi organizacion durante <strong><?php echo $diferencia->y;?> años(s)</strong>
    es un ciudadano con una conducta intachable.
    ha demostrado ser un excelente trabajador,
    comprometido, responsable y fiel cumplidor de sus tareas.
    siempre ha manifestado preocupacion por mejorar, capacitarse y actualizar sus conocimientos.
    <br/>  <br/>
    Durante estos años se ha desempeñado como <strong><?php echo $puesto; ?></strong>
    Es por ello mas nada que referirme y, esperando que esta masiva sea tomada en cuenta, dejo mi numero de contacto
    <br/>  <br/>  <br/>  <br/>  <br/>  <br/>  <br/>  <br/>  <br/>

    Atentamente,
    <br/>
    Ing. Antony Mendoza Quintero
   </p>


 </body>
 </html>


 <?php
 $HTML = ob_get_clean();
 require_once("../../libs/autoload.inc.php");
  use Dompdf\Dompdf;
 $dompdf=new Dompdf();
 $opciones = $dompdf->getOptions();
 $opciones->set(array("isRemoteEnabled" => true));

 $dompdf->setOptions($opciones);

 $dompdf->loadHTML($HTML);
 $dompdf->setPaper('letter');
 $dompdf->render();
 $dompdf->stream("archivo.pdf", array("attachment" => false));


 ?>