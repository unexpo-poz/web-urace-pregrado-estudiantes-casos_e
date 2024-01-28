<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Casos Estudiantiles - Planilla de Solicitud</title>
</head>
<?php
$exp=$_POST['exp_e'];
while(strlen($cedula)<8)
{
$cedula="0".$cedula;
}
require_once("../odbc/config.php");

require_once("../odbc/odbcss_c.php");
require_once("../odbc/config.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT nombres,apellidos,exp_e,lapso_in,c_uni_ca FROM dace002 where exp_e='$exp'";				// Extrae los datos del alumno a partir de su cedula
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;


if($filas!=1)
{
	echo "ERROR: $filas FILAS RECIBIDAS";
}

else
{
//--------se cargan los datos del alumno extraidos de la base de datos en las variables correspondientes-----
	$num_caso=$_POST['num_caso'];
	$coment=$_POST['descrip'];
	if($_POST['obser']!="") $coment.="<br><br><p style=\"color:#FF0000\">".$_POST['obser']."</p>";
	$fecha=date('m/d/Y');
	$fecham=date('d/m/Y');
	$nom_alum=$result[0][0];
	$ape_alum=$result[0][1];
	$exp_alum=$result[0][2];
	$lapso_in_alum=$result[0][3];
	$esp_alum=$result[0][4];

	$mSQL = "SELECT tipo_caso FROM space_num_casos WHERE numero='$num_caso'";
	$conex->ExecSQL($mSQL,__LINE__,true);
	$result = $conex->result;
	$nom_caso=$result[0][0];
	
		
	
//--------Dependiendo del Tipo de Caso------------
	switch($num_caso)
	{
	case 1:
	case 15:
	case 2:
	case 3:
	case 4:
	case 11:
	case 12:
	case 13:
		$co_asig=array();
		$sec_asig=array();
		$asig_bas= array();
		$asig_esp=array();
		$sec_bas=array();
		$sec_esp=array();
		$cant_asig=$_POST['cant_mat'];
		$estado="1) En Dpto. Académico - Por Aprobar";
		$lapso_act= $_POST['ano_act']."-".$_POST['lap_act'];
		
		
		
		for($i=0; $i < $cant_asig; $i++)
			{
				if (strlen($_POST['c_asigna'.$i]) == 5){
					$_POST['c_asigna'.$i] = "3".$_POST['c_asigna'.$i];
				}


				if(substr($_POST['c_asigna'.$i],0,3)=="300" && substr($_POST['c_asigna'.$i],0,4)!="30000")
					{
						$asig_bas[$i]=$_POST['c_asigna'.$i];
						if($num_caso==2 || $num_caso==3 || $num_caso==4 || $num_caso==11 || $num_caso==12) $sec_bas[$i]=$_POST['seccion'.$i];
					}
				else
					{
						$asig_esp[$i]=$_POST['c_asigna'.$i];
						if($num_caso==2 || $num_caso==3 || $num_caso==4 || $num_caso==11 || $num_caso==12) $sec_esp[$i]=$_POST['seccion'.$i];
					}
				$co_asig[$i]=$_POST['c_asigna'.$i];
				$sec_asig[$i]=$_POST['seccion'.$i];
			}
		
		// si son varias Asignaturas se hace un string con todas los codigos separados por "/" ejemplo: 111111/222222/333333/4444444	
		$veces=1;
		if(count($asig_bas)==0)// Si hay asignaturas de la especialidad
			{
				$asignaturas = implode("/",$asig_esp);
				$secciones = implode("/",$sec_esp);
				$depart=$esp_alum;
			}
		elseif(count($asig_esp)==0)// Si hay asignaturas del basico
			{
				$asignaturas = implode("/",$asig_bas);
				$secciones = implode("/",$sec_bas);
				$depart=1;
			}
		else // Si hay asignaturas del basico y de la especialidad
			{
				$asignaturas = implode("/",$asig_bas);			// Primero las materias del Basico
				$secciones = implode("/",$sec_bas);
				$veces=2;
				$depart=1;
			}
					
		for($i=0; $i<$veces ; $i++)
		{
		
		if($i==1)
			{	
				
				$array=array();
				$asignaturas = implode("/",$asig_esp);			// La segunda vez se cargan las materias de la especialidad
				$secciones = implode("/",$sec_esp);
				$depart=$esp_alum;
				$array=array();
				$array=explode("-",$num_sol);
				$array[1]++;
				if(strlen($array[1])==1)
					{
						$array[1]="00".$array[1];
					}
				if(strlen($array[1])==2)
					{
						$array[1]="0".$array[1];
					}
				$solic2= implode("-",$array);
				
				$num_sol=$solic2;
			}
		else
			{
				$num_sol=solicitud($num_caso,$lapsoProceso,$ODBC_name,$usuario_db,$password_db,$log);
				$solic1=$num_sol;
			}
		
		//----- se cargan los campos a la Base de Datos----------
		//--------en la Tabla "space_materias" se cargan diferentes campos si el caso es numero 04, 12 o 13---------
		
		//----------------quita parte del comentario que no corresponde al departamento----------------
				$asig=array();
				$asig= explode("/",$asignaturas);
				
				$com=array();
				$com=explode("-",$coment);
				for($j=0; $j<count($com) ; $j++)
					{
						if(strstr($com[$j],"RECURSAR")!=false)
							{
								$flag=false;
								for($k=0; $k<count($asig) ; $k++)
									{
										if(strstr($com[$j],$asig[$k])!=false) {$flag=true;}
									}
								if($flag==false) $com[$j]="";
							}
					}
				$com_aux=implode("-",$com);
		//---------------------------------------------------------------------------------------------
		
		#### RUTINA PARA GENERAR NUMERO DE CASO ####
		$encontrado = true;
		while($encontrado){
			$sSQL = "SELECT * FROM space_casos WHERE solicitud='".$num_sol."' ";
			$conex->ExecSQL($sSQL,__LINE__,true);

			if($conex->filas == 0){// Solicitud no encontrada.
				$encontrado = false;
				$nros.=$num_sol."<br>";
			}else{// Soliccitud encontrada, generar nuevo numero.
				$num = explode("-",$num_sol);
				$numero = $num[1]+1;
				$lapso= substr($lapsoProceso,2,2).substr($lapsoProceso,5);
				$num_sol = $num_caso.$lapso."-".$numero;
			}
		}
		###### ----
		
		if($num_caso=='04')
			{
				$asig_pre=$_POST['prelacion'];
				$mSQL = "INSERT INTO space_materias (solicitud,c_asigna,c_asigna_prel,lapso,seccion) VALUES ('$num_sol','$asignaturas','$asig_pre','$lapso_act','$secciones')";
			}
		elseif($num_caso=='12')
			{
				$exceso=$_POST['exceso'];
				$mSQL = "INSERT INTO space_materias (solicitud,c_asigna,lapso,credito_exc,seccion) VALUES ('$num_sol','$asignaturas','$lapso_act','$exceso','$secciones')";
			}
		elseif($num_caso=='13')
			{
				$nota_act=$_POST['nota_act'];
				$nota_fin=$_POST['nota_fin'];
				$mSQL  = $mSQL  = "INSERT INTO space_materias (solicitud,c_asigna,lapso,nota_act,nota_final) VALUES ('$num_sol','$asignaturas','$lapso_act','$nota_act','$nota_fin')";
			}
		//-------si el caso es 01, 02, 03 o 11 se cargan de los mismos campos
		else
			{
				$mSQL  = "INSERT INTO space_materias (solicitud,c_asigna,lapso,seccion) VALUES ('$num_sol','$asignaturas','$lapso_act','$secciones')";
			}
			
		$conex->ExecSQL($mSQL,__LINE__,true);
		if($conex->fmodif==1)							// si se cargo exitosamente la tabla "space_materias" se procede a cargar las demas
			{
		
				$mSQL  = "INSERT INTO space_casos (solicitud,exp_e,f_emision,estado,depart) VALUES ('$num_sol','$exp_alum','$fecha','$estado','$depart')";
				$conex->ExecSQL($mSQL,__LINE__,true);
		
				$mSQL  = "INSERT INTO space_comen (solicitud,com_alum) VALUES ('$num_sol','$com_aux')";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$ok=1;
			}
		else
			{
				$ok=0;
			}
		
		}// end for veces
		if($veces==1)
			{
				$solic1="";
			}
		include("plan_solicitud.php");				
		break;

	case 5:
	case 6:
	case 7:
	case 8:
	case 9:
	case 10:
	case 14:
		$num_sol=solicitud($num_caso,$lapsoProceso,$ODBC_name,$usuario_db,$password_db,$log);
		if($num_caso==5)
			{	
				$depart=$esp_alum;
				$traslado=$_POST['traslado'];
				$codigo=$_POST['c_asigna0'];
				$lapso_act= $_POST['ano_act']."-".$_POST['lap_act'];
				$lapso_fin= $_POST['ano_fin']."-".$_POST['lap_fin'];
				$estado="1) En Dpto. Académico - Por Aprobar";
				$mSQL  = "INSERT INTO space_materias (solicitud,c_asigna,lapso,lapso_final,traslado) VALUES ('$num_sol','$codigo','$lapso_act','$lapso_fin','$traslado')";
			}
		elseif($num_caso==8)
			{
				$depart=$esp_alum;
				$nueva_esp=substr($_POST['nueva_esp'],1);
				$depart=substr($_POST['nueva_esp'],0,1);
				$estado="1) En Dpto. Académico - Por Aprobar";
				$mSQL  = "SELECT carrera1 FROM tblaca010 WHERE c_uni_ca='$esp_alum'";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result=$conex->result;
				$esp_act=$result[0][0];
				
				$mSQL  = "INSERT INTO space_prueba_apt (solicitud,nueva_esp) VALUES ('$num_sol','$depart')";
				
				$ok=1;
			}
		elseif($num_caso==10)
			{
				$depart=7;
				$lapso_act= $_POST['ano_act']."-".$_POST['lap_act'];
				$estado="1) En URACE - Por Procesar";
				$mSQL  = "INSERT INTO space_materias (solicitud,lapso) VALUES ('$num_sol','$lapso_act')";
				$ok=1;
			}
		else{	
				$depart=7;
				$estado="1) En URACE - Por Procesar";
				$ok=1;
			}
		$conex->ExecSQL($mSQL,__LINE__,true);
		
		if($conex->fmodif >= 1 || $ok==1)							// si se cargo exitosamente la tabla "space_materias" se procede a cargar las demas
			{
				
				$mSQL  = "INSERT INTO space_casos (solicitud,exp_e,f_emision,estado,depart) VALUES ('$num_sol','$exp_alum','$fecha','$estado','$depart')";
				$conex->ExecSQL($mSQL,__LINE__,true);
		
				$mSQL  = "INSERT INTO space_comen (solicitud,com_alum) VALUES ('$num_sol','$coment')";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$ok=1;
				
				include("plan_solicitud.php");
			}
		else 
			{
				echo "NO SE PROCESO LA SOLICITUD";
				$ok=0;
			}
		break;
		

	}
	
	if($ok >= 1)
		{
			if(substr($num_sol,-3)=='001')												// si se ha reseteado el contador es que es la primera solicitud en el lapso
					{
						$mSQL  = "UPDATE space_num_casos SET ult_solicitud=''";			// se resetea todas las "ultimas solicitudes" de la tabla space_num_casos
						$conex->ExecSQL($mSQL,__LINE__,true);
					}
		
				$mSQL  = "UPDATE space_num_casos SET ult_solicitud='$num_sol' WHERE numero='$num_caso'";	// se actualiza la Ultima solicitud
				$conex->ExecSQL($mSQL,__LINE__,true);
				$modif = $conex->fmodif;		
				
				
		}
	else
		{
			echo "No se Proceso la Solicitud";
		}
}
//--------------------------------------FUNCIONES-----------------------------------------------------
function solicitud($num_caso,$lapsoProceso,$ODBC_name,$usuario_db,$password_db,$log){
	$cont="000";
		$lapso= substr($lapsoProceso,2,2).substr($lapsoProceso,5);				// extrae una parte del codigo del lapso ejemplo: 2009-1 = 091
		$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
		$mSQL  = "SELECT ult_solicitud FROM space_num_casos";									// consulta todos los numeros de solicitudes en la tabla Casos
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$fila =$conex->filas;
		for($i=0; $i < $fila; $i++)
			{
				if(substr($result[$i][0],2,-4)==$lapso)							// elije las filas que coincida con el lapso actual
					{	
						if(substr($result[$i][0],-3) > $cont)					// elije el valor del contador mayor
							{
								$cont=substr($result[$i][0],-3);
							}
					}
				elseif($result[$i][0]!='')										// si no coincide con el lapso chequea si es por que la tabla esta vacia
					{
						$cont="000";											// si se trata de otro lapso se resetea el contador
					}
			}
		if($fila==0){$cont="000";}
		$cont++;
		
		// Se rellena con "0" para lograr 3 digitos
		if(strlen($cont)==1)
			{
				$cont="00".$cont;
			}
		elseif(strlen($cont)==2)
			{
				$cont="0".$cont;
			}
		
		return($num_caso.$lapso."-".$cont);									// retorna un numero de solicitud en formato XXYYY-ZZZ
																				// donde XX: dos digitos del tipo de caso, YYY: 3 o 4 digitos para el lapso
}																		// ZZZ: numero de solicitud en el lapso	

?> 