<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$solicitud=$_POST['solicitud'];
$depart=$_POST['depart'];
$mensaje="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$fecha=date('m/d/Y');

if(substr($solicitud,0,2)=="08")
{
	$mSQL  = "UPDATE space_prueba_apt SET fecha_sol='$fecha' WHERE solicitud='$solicitud'";
}
else
{
	$mSQL  = "INSERT INTO space_inf_urdbe (solicitud) VALUES ('$solicitud')";
}
$conex->ExecSQL($mSQL,__LINE__,true);
$modif = $conex->fmodif;

if($modif==0)
	{
		$mensaje .= "$solicitud - No se pudo Solicitar Informe";
	}
else
	{
		$mensaje .= "$solicitud - Informe Solicitado";
	}
echo $mensaje;

?>