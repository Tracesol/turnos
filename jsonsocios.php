<?php
header('Content-Type: application/json; charset=utf-8');
include("funcionesSQL.php");
$pdo=conectoDB();

if(isset($_REQUEST["e"])){
    $result=leoDB($pdo,"SELECT * FROM socios WHERE email=:email",array(":email"=>$_REQUEST["e"]));
    if(count($result) > 0)
        echo json_encode($result[0]);
    else
        die('{"rta":"ERROR","msg":"No existe"}');
}else{
    $result=leoDB($pdo,"SELECT * FROM socios",null);
    echo json_encode($result);
}



?>