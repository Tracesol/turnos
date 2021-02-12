<?php


function str2Hexa($cad){
	$hexa="";
	for($i=0;$i<strlen($cad);$i++){
		$hexa.=dechex(ord($cad[$i]));
	}
	return $hexa;
}


header('Content-Type: application/json; charset=utf-8');

if(!isset($_REQUEST['obj']) || !isset($_REQUEST['estado'])){
	$rta=array("rta"=>"ERROR","msg"=>$_REQUEST);
	echo json_encode($rta);
	die();
}

$confirmado=false;
if($_REQUEST["estado"] == "ok"){
	$confirmado=true;
}


$obj = json_decode( $_REQUEST["obj"] , true);
$to=$obj["email"];
$nombre=$obj["nombre"];
$prof=$obj["profname"];
$profid=$obj["prof"];
$fechahora=$obj["fechahora"];
$f=explode(" ",$fechahora);
$d=explode("-",$f[0]);
$hora=substr($f[1],0,5);
$dia=$d[2]."/".$d[1]."/".$d[0];
$cc="fedebonino75@gmail.com";

//mando mail
include("utils.php");
$url='http://www.sivet.com.ar/phpmailer/mailsivet.php';
$userdata=array("yourName"=>$nombre,"yourId"=>str2Hexa($to),"targetId"=>$profid,"targetName"=>$prof,"osocial"=>"NA","soy"=>"cliente","r"=>rand(0,10000),"business"=>1001);

$body= '<p>Estimado/a '.$nombre.'<br>
		Enviamos la confirmación del turno de la VideoConsulta.<br>
		Día: <strong>'.$dia.'</strong><br>
		Hora:<strong>'.$hora.' hs.</strong><br>
		Veterinario/a: <strong>'.$prof.'</strong><br>
		Enlace a la Videoconsulta: <strong><a href="https://doxvir.web.app/sivet.html?d='.urlencode(json_encode($userdata)).'">Hacer click acá el '.$dia.' a las '.$hora.'</a></strong><br><br>
		Saludos y cualquier duda comuníquese al (0341) 425 1035<br><strong>Sistema de Turnos SiVET</strong></p>';


if($confirmado){
	$sbj='Turno confirmado VideoConsulta SiVET';
	$query=http_build_query(array("to"=>$to, "sbj"=>$sbj,"msg"=>$body,"cc"=>$cc));	
}else{
	$sbj='Turno para revisar VideoConsulta SiVET';
	$query=http_build_query(array("to"=>$cc, "sbj"=>$sbj,"msg"=>$body));
}
$json=postLocalPage($url, $query);
echo $json;
?>
