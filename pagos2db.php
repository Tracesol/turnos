<?php
header('Content-Type: application/json; charset=utf-8');

if(!isset($_REQUEST["estado"]))
    die('{"rta":"ERROR","msg":"Error en proceso de pago."}');



include("funcionesSQL.php");
$pdo=conectoDB();
$parametros=array(":prof"=>$prof,":nombre"=>$nombre,":email"=>$email,":telefono"=>$telefono,":fechahora"=>$fechahora,":estado"=>$estado);

$result=escriboDB($pdo,"INSERT INTO turnos (prof, nombre, email, telefono, fechahora, estado) VALUES (:prof, :nombre, :email, :telefono, :fechahora, :estado)", $parametros);

if($result){
    $result2=leoDB($pdo,"select max(id) as maxid from turnos",null);
    die('{"rta":"OK","msg":"Se almacenaron bien","maxid":'.$result2[0]["maxid"].'}');
}else
    echo json_encode(array("rta"=>"ERROR","msg"=>$result));

?>