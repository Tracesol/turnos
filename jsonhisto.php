<?php
header('Content-Type: application/json; charset=utf-8');

include("funcionesSQL.php");
$pdo=conectoDB();

$turnosdados=leoDB($pdo,"SELECT t.id,t.prof,u.nombre as profname,DATE_FORMAT(DATE(t.fechahora),'%d/%m/%Y') as dia, TIME(t.fechahora) as hora,t.nombre,t.email,t.telefono,t.estado,t.pais 
FROM turnos t LEFT JOIN usuarios u ON u.id=t.prof 
WHERE t.estado<>'Cancelado' AND t.fechahora < NOW() ORDER BY t.fechahora DESC",null);

echo json_encode($turnosdados);
?>
