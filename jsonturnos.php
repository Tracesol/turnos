<?php
header('Content-Type: application/json; charset=utf-8');
include("funcionesSQL.php");
$pdo=conectoDB();

if(isset($_REQUEST["e"])){
    $result=leoDB($pdo,"SELECT * FROM turnos WHERE email=:email",array(":email"=>$_REQUEST["e"]));
    if(count($result) > 0)
        echo json_encode($result[0]);
    else
        die('{"rta":"ERROR","msg":"No existe"}');
}else{
    $turnosdados=leoDB($pdo,"SELECT t.prof,u.nombre as profname,DATE_FORMAT(DATE(t.fechahora),'%d/%m/%Y') as dia, TIME(t.fechahora) as hora,t.nombre,t.email,t.telefono,t.estado 
    FROM turnos t LEFT JOIN usuarios u ON u.id=t.prof 
    WHERE t.prof=:prof AND t.estado<>'Cancelado' AND t.fechahora > NOW() AND t.fechahora < (NOW() + INTERVAL 30 DAY) ORDER BY t.prof,t.fechahora ASC",null);
}



?>
