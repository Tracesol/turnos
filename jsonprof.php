<?php
header('Content-Type: application/json; charset=utf-8');

include("funcionesSQL.php");
$pdo=conectoDB();


if(isset($_REQUEST["prof"])){
    $usuarios=leoDB($pdo,"SELECT * FROM usuarios where prof=:prof",array(":prof"=>$_REQUEST["prof"]));
    $horarios=leoDB($pdo,"SELECT h.*,u.nombre as profname FROM horarios h LEFT JOIN usuarios u ON u.id=h.prof WHERE h.prof=:prof",array(":prof"=>$_REQUEST["prof"]));
    $turnosdados=leoDB($pdo,"SELECT t.id,t.prof,u.nombre as profname,DATE_FORMAT(DATE(t.fechahora),'%d/%m/%Y') as dia, TIME(t.fechahora) as hora,t.nombre,t.email,t.telefono,t.estado,t.pais 
    FROM turnos t LEFT JOIN usuarios u ON u.id=t.prof 
    WHERE t.prof=:prof AND t.estado<>'Cancelado' AND t.fechahora > (NOW() - INTERVAL 7 DAY) AND t.fechahora < (NOW() + INTERVAL 30 DAY) ORDER BY t.prof,t.fechahora ASC",array(":prof"=>$_REQUEST["prof"]));
}else{
    $usuarios=leoDB($pdo,"SELECT * FROM usuarios",null);
    $horarios=leoDB($pdo,"SELECT h.*,u.nombre as profname FROM horarios h LEFT JOIN usuarios u ON u.id=h.prof",null);
    $turnosdados=leoDB($pdo,"SELECT t.id,t.prof,u.nombre as profname,DATE_FORMAT(DATE(t.fechahora),'%d/%m/%Y') as dia, TIME(t.fechahora) as hora,t.nombre,t.email,t.telefono,t.estado,t.pais 
    FROM turnos t LEFT JOIN usuarios u ON u.id=t.prof 
    WHERE t.estado<>'Cancelado' AND t.fechahora > (NOW() - INTERVAL 7 DAY) AND t.fechahora < (NOW() + INTERVAL 30 DAY) ORDER BY t.prof,t.fechahora ASC",null);
}

$rta=array("usuarios"=>$usuarios,"horarios"=>$horarios,"turnosdados"=>$turnosdados, "diaarg"=>date('d'), "horaarg"=>date('H'));

echo json_encode($rta);
?>
