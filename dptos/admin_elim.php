<?php

require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/admin.php') die ("ACCESO PROHIBIDO!");

$casos=$_POST['casos'];
$sol_casos=array();
$sol_casos=explode("/",$casos);

$comen=$_POST['comen'];
$sol_comen=array();
$sol_comen=explode("/",$comen);

$materias=$_POST['materias'];
$sol_materias=array();
$sol_materias=explode("/",$materias);

$inf_urdbe=$_POST['inf_urdbe'];
$sol_inf_urdbe=array();
$sol_inf_urdbe=explode("/",$inf_urdbe);

$prueba_apt=$_POST['prueba_apt'];
$sol_prueba_apt=array();
$sol_prueba_apt=explode("/",$prueba_apt);

require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

$cont=0;
$mensaje.="<b>__________________________TABLA SPACE_CASOS__________________________</b><br>";
$mensaje.="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
for($i=0; $i<(count($sol_casos)-1) ; $i++)
	{
		$mSQL  = "DELETE FROM space_casos WHERE solicitud='$sol_casos[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1) {$mensaje.="$sol_casos[$i] - Eliminada Correctamente<br>"; $cont++;}
		elseif($modif==0) $mensaje.="$sol_casos[$i] - No ha sido Eliminada de la Tabla<br>";
	}
$mensaje.="<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filas Eliminadas: $cont</b><br><br>";

$cont=0;
$mensaje.="<b>__________________________TABLA SPACE_COMEN__________________________</b><br>";
$mensaje.="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
for($i=0; $i<(count($sol_comen)-1) ; $i++)
	{
		$mSQL  = "DELETE FROM space_comen WHERE solicitud='$sol_comen[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1) {$mensaje.="$sol_comen[$i] - Eliminada Correctamente<br>"; $cont++;}
		elseif($modif==0) $mensaje.="$sol_comen[$i] - No ha sido Eliminada de la Tabla<br>";
	}
$mensaje.="<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filas Eliminadas: $cont</b><br><br>";

$cont=0;
$mensaje.="<b>__________________________TABLA SPACE_MATERIAS_______________________</b><br>";
$mensaje.="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
for($i=0; $i<(count($sol_materias)-1) ; $i++)
	{
		$mSQL  = "DELETE FROM space_materias WHERE solicitud='$sol_materias[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1) {$mensaje.="$sol_materias[$i] - Eliminada Correctamente<br>"; $cont++;}
		elseif($modif==0) $mensaje.="$sol_materias[$i] - No ha sido Eliminada de la Tabla<br>";
	}
$mensaje.="<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filas Eliminadas: $cont</b><br><br>";

$cont=0;
$mensaje.="<b>__________________________TABLA SPACE_INF_URDBE______________________</b><br>";
$mensaje.="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
for($i=0; $i<(count($sol_inf_urdbe)-1) ; $i++)
	{
		$mSQL  = "DELETE FROM space_inf_urdbe WHERE solicitud='$sol_inf_urdbe[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1) {$mensaje.="$sol_inf_urdbe[$i] - Eliminada Correctamente<br>"; $cont++;}
		elseif($modif==0) $mensaje.="$sol_inf_urdbe[$i] - No ha sido Eliminada de la Tabla<br>";
	}
$mensaje.="<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filas Eliminadas: $cont</b><br><br>";

$cont=0;
$mensaje.="<b>__________________________TABLA SPACE_PRUEBA_APT_____________________</b><br>";
$mensaje.="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
for($i=0; $i<(count($sol_prueba_apt)-1) ; $i++)
	{
		$mSQL  = "DELETE FROM space_prueba_apt WHERE solicitud='$sol_prueba_apt[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1) {$mensaje.="$sol_prueba_apt[$i] - Eliminada Correctamente<br>"; $cont++;}
		elseif($modif==0) $mensaje.="$sol_prueba_apt[$i] - No ha sido Eliminada de la Tabla<br>";
	}
$mensaje.="<br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filas Eliminadas: $cont</b><br><br>";

echo $mensaje;

?>