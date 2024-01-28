<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$solicitud=$_POST['sol'];
echo "<head><title>Planilla de Solicitud $solicitud</title></head>
<body>";
$num_caso=substr($solicitud,0,2);
$num_sol=$solicitud;
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT exp_e,f_emision,depart FROM space_casos where solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

//echo $mSQL;

if($filas == 1)
	{
		$exp_alum=$result[0][0];
		$fecham=implode("/",array_reverse(explode("-",$result[0][1])));				// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
		$depart=$result[0][2];
		
		//______________________________________NOMBRE DEL DEPARTAMENTO___________________________________________________

		if($depart==7) $nom_depart="UNIDAD REGIONAL DE ADMISION Y CONTROL DE ESTUDIOS";
		elseif($depart==9) $nom_depart="CONSEJO DIRECTIVO";
		elseif($depart==10) $nom_depart="CONSEJO UNIVERSITARIO";
		elseif($depart==11) $nom_depart="CONSEJO ACAD&Eacute;MICO";
		else
			{
				if($depart==1) $cargo_dep="70";
				else $cargo_dep=$depart."0";
				$mSQL  = "SELECT cargo_d FROM autoridades WHERE cargo='$cargo_dep'";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result = $conex->result;
				$nom_depart=$result[0][0];
			}

		//_________________________________________________________________________________________________________________
		
		$mSQL  = "SELECT nombres,apellidos,c_uni_ca FROM dace002 where exp_e='$exp_alum'";		// Extrae los datos del alumno a partir de su cedula
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$nom_alum=$result[0][0];
		$ape_alum=$result[0][1];
		$esp_alum=$result[0][2];
		$mSQL  = "SELECT tipo_caso FROM space_num_casos where numero='$num_caso'";		// Extrae el Nombre del caso
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$nom_caso=$result[0][0];
		
		$mSQL  = "SELECT com_alum FROM space_comen where solicitud='$num_sol'";			// Extrae el Comentario del alumno
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$coment=utf8_encode($result[0][0]);
		
		if($num_caso==8)
			{
				
				$mSQL  = "SELECT a.carrera1 FROM tblaca010 a,space_prueba_apt b WHERE b.solicitud='$num_sol' AND a.c_uni_ca=b.nueva_esp";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result = $conex->result;
				$nueva_esp=$result[0][0];
				$mSQL  = "SELECT carrera1,carrera1 FROM tblaca010 WHERE c_uni_ca='$esp_alum'";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result=$conex->result;
				$esp_act=$result[0][0];
				
			}
		
		$mSQL  = "SELECT c_asigna,c_asigna_prel,lapso,lapso_final,nota_act,nota_final,credito_exc,traslado,seccion FROM space_materias where solicitud='$solicitud'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$asignaturas=$result[0][0];
		$asig_pre=$result[0][1];
		$lapso_act=$result[0][2];
		$lapso_fin=$result[0][3];
		$nota_act=$result[0][4];
		$nota_fin=$result[0][5];
		$exceso=$result[0][6];
		$traslado=$result[0][7];
		$seccion=$result[0][8];
		
		$co_asig=array();
		$sec_asig=array();
		$nom_asig=array();
		
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
	
		include("../solicitud/plan_solicitud.php");
	
	}
else
	{
		echo "NUMERO DE SOLICITUD DUPLICADA ";
		//print_r($_POST);
	}

?>

</body>
</html>
