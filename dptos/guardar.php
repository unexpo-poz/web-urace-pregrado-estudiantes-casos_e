<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$sol=$_POST['solicitud'];
$res=$_POST['resolucion'];
$ses=$_POST['sesion'];
$com=$_POST['coment'];
$est=$_POST['estado'];
$depart=$_POST['depart'];

$solicitud=array();
$resolucion=array();
$sesion=array();
$coment=array();
$estado=array();


$solicitud=explode("/",$sol);
$resolucion=explode("/",$res);
$sesion=explode("/",$ses);
$coment=explode("/",$com);
$estado=explode("/",$est);

$fecha=date('m/d/Y');

$mensaje="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
$arc=0;
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

for($i=0; $i<count($solicitud)-1 ; $i++)
{
$SQL  = "SELECT com_alum FROM space_comen WHERE solicitud='$solicitud[$i]'";
$conex->ExecSQL($SQL,__LINE__,true);
$arreg = $conex->result;
$com_alum=$arreg[0][0];

if(	$depart==1 ||
	$depart==2 || 
	$depart==3 || 
	$depart==4 || 
	$depart==5 || 
	$depart==6 || 
	$depart==9 || 
	$depart==10 ||
	$depart==11) 
	{
		if(substr($estado[$i],0,1)==2)						// Solicitud Aprobada y remitida a URACE (7) para procesar
			{
				if($depart<7 && (substr($solicitud[$i],0,2)==4 || strstr($com_alum,"RECURSAR")!=false)) $dep=11;
				else $dep=7;
				
				$mSQL  = "UPDATE space_casos SET f_conclu='$fecha',sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]',depart='$dep' WHERE solicitud='$solicitud[$i]'";
				$arc=1;
			}
		elseif(substr($estado[$i],0,1)==3)					// Solicitud Rechazada, remitida a Estudiante (0)
			{
				$mSQL  = "UPDATE space_casos SET f_conclu='$fecha',sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]',depart='0' WHERE solicitud='$solicitud[$i]'";
				$arc=1;
			}
		
		else
			{
				if(substr($estado[$i],0,18)=="1) En Consejo Acad" && $depart!=11)		// Transferencia de Especialidad a Consejo Academico (11)
					{
						$mSQL  = "UPDATE space_casos SET sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]',depart='11' WHERE solicitud='$solicitud[$i]'";
					}
				elseif($estado[$i]=="1) En Consejo Directivo - Por Aprobar" && $depart!=9)		// Transferencia de Especialidad a Consejo directivo (9)
					{
						$mSQL  = "UPDATE space_casos SET sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]',depart='9' WHERE solicitud='$solicitud[$i]'";
					}
				elseif($estado[$i]=="1) En Consejo Universitario - Por Aprobar" && $depart==9)	// Transferencia de Especialidad a Consejo Universitario (10)
					{
						$mSQL  = "UPDATE space_casos SET sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]',depart='10' WHERE solicitud='$solicitud[$i]'";
					}
				elseif($estado[$i]==6)
					{
						$mSQL  = "UPDATE space_casos SET estado='$estado[$i] - $coment[$i]' WHERE solicitud='$solicitud[$i]'";
						//echo $mSQL;
					}
				if(substr($estado[$i],0,1)==7)
					{
						$mSQL  = "UPDATE space_casos SET estado='$estado[$i]', depart='0', f_conclu='$fecha' WHERE solicitud='$solicitud[$i]'";
						$arc=1;
					}
				else // El estado del caso no cambio SOLO SE CARGARON LOS VALORES DE SESION Y RESOLUCION
					{
						if($estado[$i]==6) {
							$mSQL  = "UPDATE space_casos SET estado='$estado[$i] - $coment[$i]' WHERE solicitud='$solicitud[$i]'";
						} else {
							$mSQL  = "UPDATE space_casos SET sesion='$sesion[$i]',resolucion='$resolucion[$i]',estado='$estado[$i]' WHERE solicitud='$solicitud[$i]'";
						}
						
					}
				
			}
	}
elseif($depart==7)
	{
		if(substr($estado[$i],0,1)==4)					// PROCESADA LA SOLICITUD
			{
				$caso=substr($solicitud[$i],0,2);
				if($caso=="06" || $caso=="07" || $caso=="09" || $caso=="14") $mSQL  = "UPDATE space_casos SET f_conclu='$fecha',depart='0',estado='$estado[$i]' WHERE solicitud='$solicitud[$i]'";
				else $mSQL  = "UPDATE space_casos SET depart='0',estado='$estado[$i]' WHERE solicitud='$solicitud[$i]'";
				$stat="PROCESADA";
				
			}
		if(substr($estado[$i],0,1)==5)					// RECHAZADA SOLICITUD POR URACE
			{
				$mSQL  = "UPDATE space_casos SET f_conclu='$fecha',depart='0',estado='$estado[$i]' WHERE solicitud='$solicitud[$i]'";
				$stat="RECHAZADA";
			}
		$arc=1;
	}
elseif($depart==0)	// RECHAZADO POR LOS DEPARTAMENTOS - EL ESTUDIANTE APELA
	{
		if($estado[$i]=="1) En Consejo Directivo - Por Aprobar")
			{
				$dep=9;
			}
		elseif($estado[$i]=="1) En Consejo Universitario - Por Aprobar")
			{
				$dep=10;
			}
		elseif(substr($estado[$i],0,18)=="1) En Consejo Acad") $dep=11;
		$mSQL  = "UPDATE space_casos SET estado='$estado[$i]',depart='$dep' WHERE solicitud='$solicitud[$i]'";
	}

$ssqll = $mSQL;

//echo $mSQL;

@$conex->ExecSQL($mSQL,__LINE__,true);
$modif = $conex->fmodif;

if($modif==1)
	{
		if($depart==7)
			{
				$mensaje.="$solicitud[$i] - $stat<br>";

			}
		else
		{
		$coment[$i] = $depart. "- ".$coment[$i];
		$mSQL  = "UPDATE space_comen SET com_adm='$coment[$i]' WHERE solicitud='$solicitud[$i]'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$modif = $conex->fmodif;
		if($modif==1)
			{
				$mensaje.="$solicitud[$i] - Cambios Guardados<br>";
			}
		else
			{
				$mensaje.="$solicitud[$i] - No se guardó el Comentario<br>";
			}
		}
	}
else
	{
		$mensaje.="$solicitud[$i] - No se guardaron los cambios<br>";
		$arc=0;
	}
	
	if($arc==1)					// Si se guarda en archivo se llama a la funcion..
		{
			archivo($solicitud[$i],$depart,$ODBC_name,$usuario_db,$password_db);
			$mensaje.="$solicitud[$i] - Se guardó en Archivo<br>";
			$arc=0;
		}
}

echo "$mensaje";//-- $mSQL -- $ssqll

function archivo($sol,$depart,$ODBC_name,$usuario_db,$password_db)
{
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT * FROM space_casos WHERE solicitud='$sol'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;

$exp=$result[0][1];
$femision=$result[0][2];
$fconclu=$result[0][3];
$ses=$result[0][4];
$resol=$result[0][5];
$esta=$result[0][6];

$mSQL  = "SELECT * FROM space_materias WHERE solicitud='$sol'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;

$asig=$result[0][1];
$prel=$result[0][2];
$lact=$result[0][3];
$lfin=$result[0][4];
$notaact=$result[0][5];
$notafin=$result[0][6];
$exces=$result[0][7];
$trasl=$result[0][8];
$secc=$result[0][9];

$mSQL  = "SELECT * FROM space_comen WHERE solicitud='$sol'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;

$comalum=$result[0][1];
$comadm=$result[0][2];

$mSQL  = "SELECT nueva_esp FROM space_prueba_apt WHERE solicitud='$sol'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;

$esp=$result[0][0];


$mSQL  = "INSERT INTO space_archivo (solicitud,exp_e,f_emision,f_conclu,sesion,resolucion,estado,com_alum,com_adm,c_asigna,c_asigna_prel,lapso,lapso_fin,nota_act,nota_fin,credito_exc,traslado,nueva_esp,depart,seccion) VALUES ('$sol','$exp','$femision','$fconclu','$ses','$resol','$esta','$comalum','$comadm','$asig','$prel','$lact','$lfin','$notaact','$notafin','$exces','$trasl','$esp','$depart','$secc')";
$conex->ExecSQL($mSQL,__LINE__,true);

}

?>
