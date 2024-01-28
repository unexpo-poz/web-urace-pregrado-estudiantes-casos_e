<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$sol=$_POST['solicitud'];
$solicitud=array();
$solicitud=explode("/",$sol);
$mensaje="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";

require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

for($i=0; $i<count($solicitud)-1 ; $i++)
{
	$caso=substr($solicitud[$i],0,2);
	$mSQL  = "DELETE FROM space_casos WHERE solicitud='$solicitud[$i]'";
	$conex->ExecSQL($mSQL,__LINE__,true);
	$modif = $conex->fmodif;
	if($modif==1)
		{
			$mSQL  = "DELETE FROM space_comen WHERE solicitud='$solicitud[$i]'";
			$conex->ExecSQL($mSQL,__LINE__,true);
			$modif = $conex->fmodif;
			if($modif==1)
				{
					if($caso==06 ||$caso==07 || $caso==09 || $caso==14)
						{
							$mensaje.="$solicitud[$i] - Eliminada Correctamente<br>";
						}
					elseif($caso=="08")
						{
							$mSQL  = "DELETE FROM space_comen WHERE solicitud='$solicitud[$i]'";
							$conex->ExecSQL($mSQL,__LINE__,true);
							$modif = $conex->fmodif;
							if($modif==1)
								{
									$mensaje.="$solicitud[$i] - Eliminada Correctamente<br>";
								}
							else
								{
									$mensaje.="$solicitud[$i] - No ha sido Eliminada de Tabla de Comentarios<br>";
								}
						}
					else
						{
							$mSQL  = "DELETE FROM space_materias WHERE solicitud='$solicitud[$i]'";
							$conex->ExecSQL($mSQL,__LINE__,true);
							$modif = $conex->fmodif;
							if($modif==1)
								{
									$mensaje.="$solicitud[$i] - Eliminada Correctamente<br>";
								}
							else
								{
									$mensaje.="$solicitud[$i] - No ha sido Eliminada de Tabla Materias<br>";
								}
						}
				}
			
		}
	else
		{
			$mensaje.="$solicitud[$i] - No ha sido Eliminada<br>";
		}
	
}

echo $mensaje;
?>