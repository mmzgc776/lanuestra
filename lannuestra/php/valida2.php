<?php
//Implementamos un "bloqueo" de la script si "paso" no es 1
if(isset($_SESSION["paso"])&&$_SESSION["paso"]==1){
	//Aquí veremos si está conectado comparando con la lista "Conectados"	
	$flag2=0;
	//Sentencia con sql, da 0 o 1 si está conectado el usuario.
	$conectado=checaConectado($user);
	if($conectado=="1"){
		echo '3';	
		$flag2=1;
	}
	if($flag2==0){	
		//echo "Puede continuar, no está en uso";
		$_SESSION["paso"]=2;		
		require_once("aplicador.php");
	}
}
else{
	echo "Ha ocurrido un error";
	}
?>