<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");

if ($_POST['tipo'] == 0){
	$solicitud=$_POST['solicitud'];
	$plant=$_POST['plant'];
	$resultados=$_POST['resultados'];
	$analisis=$_POST['analisis'];
	$recomen=$_POST['recomen'];
	$prueba=$_POST['prueba'];
	$con_recom=$_POST['con_recom'];

	$sol = array();
	$pla = array();
	$res = array();
	$ana = array();
	$rec = array();
	$pru = array();
	$c_r = array();
	$campo = array();

	$sol = explode("/",$solicitud);
	$pla = explode("/",$plant);
	$res = explode("/",$resultados);
	$ana = explode("/",$analisis);
	$rec = explode("/",$recomen);
	$pru = explode("/",$prueba);
	$c_r = explode("/",$con_recom);

	$mensaje="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
	require_once("../odbc/odbcss_c.php");
	$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
	$fecha=date('m/d/Y');

	for($i=0; $i<count($sol)-1 ; $i++)
		{
			if(substr($sol[$i],0,2)=="08")
				{
					$campo=explode(".",$pru[$i]);
					/*$mSQL  = "UPDATE space_prueba_apt SET fecha_eval='$fecha', raz_abs='$campo[0]', raz_verb='$campo[1]', raz_num='$campo[2]', raz_mec='$campo[3]', rel_espac='$campo[4]', int_airelib='$campo[5]', int_mec='$campo[6]', int_calc='$campo[7]', int_cientif='$campo[8]', int_persua='$campo[9]', int_artis='$campo[10]', int_liter='$campo[11]', int_music='$campo[12]', int_servsoc='$campo[13]', int_ofic='$campo[14]', con_recom='$c_r[$i]' WHERE solicitud='$sol[$i]'";*/

					$mSQL  = "UPDATE space_prueba_apt SET fecha_eval='$fecha' WHERE solicitud='$sol[$i]'";
				}
			else
				{
					$mSQL = "UPDATE space_inf_urdbe SET fecha='$fecha', plant_prob='$pla[$i]', result_invest='$res[$i]', an_acad='$ana[$i]', conc_recom='$rec[$i]' WHERE solicitud='$sol[$i]'";
				}
			$conex->ExecSQL($mSQL,__LINE__,true);
			$modif = $conex->fmodif;
			if($modif==1)
				{
					if(substr($sol[$i],0,2)=="08")
						{
							$mensaje.="$sol[$i] - Resultados de Prueba Aptitudinal Enviados<br>";
						}
					else
						{
							$mensaje.="$sol[$i] - Informe Enviado<br>";
						}
						
				}
			else
				{
					$mensaje.="$sol[$i] - NO Enviado<br>";
				}
		}
	echo "$mensaje";
}else if ($_POST['tipo'] == 1){

	$solicitud=$_POST['solicitud'];
	$plant=$_POST['plant'];
	$resultados=$_POST['resultados'];
	$analisis=$_POST['analisis'];
	$recomen=$_POST['recomen'];
	$prueba=$_POST['prueba'];
	$con_recom=$_POST['con_recom'];

	$sol = array();
	$pla = array();
	$res = array();
	$ana = array();
	$rec = array();
	$pru = array();
	$c_r = array();
	$campo = array();

	$sol = explode("/",$solicitud);
	$pla = explode("/",$plant);
	$res = explode("/",$resultados);
	$ana = explode("/",$analisis);
	$rec = explode("/",$recomen);
	$pru = explode("/",$prueba);
	$c_r = explode("/",$con_recom);

	$mensaje="<b>&nbsp;Solicitud &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;Operacion</b><br>";
	require_once("../odbc/odbcss_c.php");
	$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
	//$fecha=date('m/d/Y'); // para no mostrarlo al dpto hasta que no se envíe
	$fecha="";

	for($i=0; $i<count($sol)-1 ; $i++)
		{
			if(substr($sol[$i],0,2)=="08")
				{
					$campo=explode(".",$pru[$i]);
					if ($c_r[$i] != "--"){
						$mSQL  = "UPDATE space_prueba_apt SET fecha_eval='$fecha', raz_abs='$campo[0]', raz_verb='$campo[1]', raz_num='$campo[2]', raz_mec='$campo[3]', rel_espac='$campo[4]', int_airelib='$campo[5]', int_mec='$campo[6]', int_calc='$campo[7]', int_cientif='$campo[8]', int_persua='$campo[9]', int_artis='$campo[10]', int_liter='$campo[11]', int_music='$campo[12]', int_servsoc='$campo[13]', int_ofic='$campo[14]', con_recom='$c_r[$i]' WHERE solicitud='$sol[$i]'";
					}
				}
			else
				{
					$mSQL = "UPDATE space_inf_urdbe SET fecha='$fecha', plant_prob='$pla[$i]', result_invest='$res[$i]', an_acad='$ana[$i]', conc_recom='$rec[$i]' WHERE solicitud='$sol[$i]'";
				}
			if (!empty($mSQL)){
				$conex->ExecSQL($mSQL,__LINE__,true);
				empty($mSQL);
				$modif = $conex->fmodif;
				if($modif==1)
					{
						if(substr($sol[$i],0,2)=="08")
							{
								$mensaje.="$sol[$i] - Resultados de Prueba Aptitudinal almacenados correctamente.<br>";
							}
						else
							{
								$mensaje.="$sol[$i] - Informe Enviado<br>";
							}
							
					}
				else
					{
						$mensaje.="$sol[$i] - NO Enviado<br>";
					}
			}// fin mSQL valido
		}// fin for
	//echo "$mensaje";
}// fin else

?>