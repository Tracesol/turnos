<?php
header('Content-Type: application/json; charset=utf-8');

if(!isset($_REQUEST["prof"]))
    die('{"rta":"ERROR","msg":"Faltan datos"}');

include("funcionesSQL.php");
$pdo=conectoDB();
$result=leoDB($pdo,"SELECT h.*,u.* FROM horarios h LEFT JOIN usuarios u ON u.id=h.prof WHERE h.prof=:prof",array(":prof"=>$_REQUEST["prof"]));

echo json_encode($result);


?>
