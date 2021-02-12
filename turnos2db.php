<?php
header('Content-Type: application/json; charset=utf-8');

if(!isset($_REQUEST["email"]) || !isset($_REQUEST["fechahora"]) || !isset($_REQUEST["prof"]))
    die('{"rta":"ERROR","msg":"Faltan datos"}');

$prof=$_REQUEST["prof"];
$nombre=$_REQUEST["nombre"];
$email=$_REQUEST["email"];
$estado=$_REQUEST["estado"];
$fechahora=$_REQUEST["fechahora"];
$telefono=$_REQUEST["telefono"];


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