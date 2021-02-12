<?php
header('Content-Type: application/json; charset=utf-8');

if(isset($_REQUEST['usr']) && isset($_REQUEST['pwd'] )){

	include("funcionesSQL.php");

	$pdo=conectoDB();

	$usr=$_REQUEST['usr'];
	$pwd=md5($_REQUEST['pwd']);

	$sql="SELECT id, usuario, password, nombre, nivel,email  FROM usuarios WHERE usuario=:usuario AND password=:password";
	$result=leoDB($pdo,$sql,array(":usuario"=>$usr , ":password"=>$pwd));
	$row=$result[0];
	$idusuario=$row["id"];
	$nombre=$row["nombre"];
	$nivel=$row["nivel"];
	$email=$row["email"];

	if($idusuario != ""){
		echo json_encode(array("rta"=>"OK","data"=>array("id"=>$idusuario,"nombre"=>$nombre,"nivel"=>$nivel,"email"=>$email)));
	}else{
		echo json_encode(array("rta"=>"ERROR","msg"=>"NOTFOUND"));
	}
	cierroDB($pdo);
}else
	echo json_encode(array("rta"=>"ERROR","msg"=>"BADDATA"));

die();
?>
