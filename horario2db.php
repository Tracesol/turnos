<?php
header('Content-Type: application/json; charset=utf-8');

if(!isset($_REQUEST["datos"]) || !isset($_REQUEST["prof"]))
    die('{"rta":"ERROR","msg":"Faltan datos"}');

$datos=json_decode($_REQUEST["datos"],true);
$prof=$_REQUEST["prof"];

include("funcionesSQL.php");
$pdo=conectoDB();
$result=escriboDB($pdo,"DELETE FROM horarios WHERE prof=:prof",array(":prof"=>$prof));
$horarios=array();
foreach($datos as $d){
    array_push($horarios,array(":prof"=>$prof,":dia"=>$d["dia"],":hini"=>$d["hini"],":hfin"=>$d["hfin"],":nota"=>$d["nota"]));
}

$result=insertMultipleDB($pdo,"INSERT INTO horarios (prof,dia,hini,hfin,nota) VALUES (:prof,:dia,:hini,:hfin,:nota)",$horarios);

if($result)
    die('{"rta":"OK","msg":"Se almacenaron bien"}');
else
    die('{"rta":"ERROR","msg":"Error al guardar"}');

?>