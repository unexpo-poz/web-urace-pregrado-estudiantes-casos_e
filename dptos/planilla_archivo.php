<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/archivo.php') die ("ACCESO PROHIBIDO!");
$solicitud=$_POST['sol'];
echo "<head><title>Planilla de Solicitud $solicitud</title></head>
<body>";
$num_caso=substr($solicitud,0,2);
$num_sol=$solicitud;
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT * FROM space_archivo WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

if($filas!=0)
	{
		$exp_alum=$result[0][1];
		$fecham=implode("/",array_reverse(explode("-",$result[0][2])));				// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
		$coment=$result[0][7];		
		$asignaturas=$result[0][9];
		$asig_pre=$result[0][10];
		$lapso_act=$result[0][11];
		$lapso_fin=$result[0][12];
		$exceso=$result[0][13];
		$traslado=$result[0][14];
		$num_esp=$result[0][15];
		$nota_act=$result[0][16];
		$nota_fin=$result[0][17];
		$seccion=$result[0][19];
		
		$co_asig=array();
		$nom_asig=array();
		$sec_asig=array();
		
		$sec_asig=explode("/",$seccion);
		
		if($num_caso==4)
			{
				$co_asig[0]=$asignaturas;
				$co_asig[1]=$asig_pre;
			}
		elseif($num_caso==5)
			{
				$codigo=$asignaturas;
			}
		else
			{
				$co_asig=explode("/",$asignaturas);
			}
		
		
		$mSQL  = "SELECT nombres,apellidos,c_uni_ca FROM dace002 where exp_e='$exp_alum'";		// Extrae los datos del alumno a partir de su cedula
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$nom_alum=$result[0][0];
		$ape_alum=$result[0][1];
		$esp_alum=$result[0][2];
		
		$mSQL  = "SELECT carrera1 FROM tblaca010 WHERE c_uni_ca='$esp_alum'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result=$conex->result;
		$esp_act=$result[0][0];
		
		$mSQL  = "SELECT carrera1 FROM tblaca010 WHERE c_uni_ca='$num_esp'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result=$conex->result;
		$nueva_eso=$result[0][0];
		
		$mSQL  = "SELECT tipo_caso FROM space_num_casos where numero='$num_caso'";		// Extrae el Nombre del caso
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$nom_caso=$result[0][0];
		
		include("../solicitud/plan_solicitud.php");
	}
else
	{
		echo "Solicitud No encontrada en el archivo";
	}

?>

</body>
</html>
