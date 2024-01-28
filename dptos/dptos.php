<?php
//setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');
//date_default_timezone_set('America/Caracas');

require_once("../odbc/config.php");
require_once("../odbc/odbcss_c.php");

//echo $ODBC_name;
//print_r($_POST);

//echo $_SERVER['HTTP_REFERER'];

$from=$_SERVER['HTTP_REFERER'];
if($from==$raiz.'indexadm.php' || $from==$raiz.'index.php' || $from==$raiz.'index' || $from==$raiz)
{
if($_SERVER['HTTP_REFERER']!=$raiz && $_SERVER['HTTP_REFERER']!=$raiz.'index.php' && $_SERVER['HTTP_REFERER']!=$raiz.'indexadm.php' && $_SERVER['HTTP_REFERER']!=$raiz.'dptos/eleccion.php') die ("<script language=\"javascript\">alert('ACCESO PROHIBIDO!'); self.close();</script>");
$cedula=$_POST['cedula'];
$contra=$_POST['contra'];
$db=$_POST['user'];
include_once('../acceso/vImage.php'); 
include("../acceso/cedula_valida.php");

$verif=cedula_valida($cedula,$contra,$db,$ODBC_name,$usuario_db,$password_db);

$expediente=$verif[3][1];
$nom_conect=$verif[3][2];
$ape_conect=$verif[3][3];
$lap_conect=$verif[3][4];
$especialidad=$verif[3][5];
$cargo=$verif[4];
$conect = $nom_conect." ".$ape_conect;

if(!$verif[0] || !$verif[1]) die ("<script language=\"javascript\">alert('CEDULA O CLAVE INVALIDA!'); self.close();</script>");
if(!$verif[2]) die ("<script language=\"javascript\">alert('CODIGO DE SEGURIDAD INVALIDO!'); self.close();</script>");
if($cargo=="") die ("<script language=\"javascript\">alert('NO TIENE PERMISO PARA ACCESAR!'); self.close();</script>");

	if($cargo=="555")			// SI ES SUPER USUARIO
		{
			//session_start();
			//$_SESSION['ced']=$cedula;
			//$_SESSION['conect']=$conect;
					
			header("location:eleccion.php?ced=".$cedula."&conect=".$conect);
		}
}

elseif(substr($from,0,strpos($from,"?"))==$raiz.'dptos/eleccion.php')
{
//session_start();
$conect=$_POST['conect'];
$cargo=$_POST['cargo'];
$depart=$_POST['depart'];
$perm=$_POST['perm'];
}

//else die ("<script language=\"javascript\">alert('ACCESO PROHIBIDO!'); self.close();</script>");

?>
<div id="div_com" style="position:absolute;width:200px; height:200px;left:30%;top:10%;visibility:hidden;">
<table border="1" width="500" class="enc_p" style="border-collapse: collapse; border-style: solid;
	border-color: #999999 ; border-width:4px" cellspacing="0" cellpadding="0">
<tr>
<td width="100%">
  <table border="1" class="act" width="100%" cellspacing="0" cellpadding="4" height="36">
  <tr style="border-bottom:thick; border-bottom-color:#000000">
  <td id="titleBar" class="enc_p" style="cursor:move" width="100%">
  <ilayer width="100%" onSelectStart="return false">
  <layer id="titulo" width="100%" onMouseover="isHot=true;if (isN4) ddN4(div_com)" onMouseout="isHot=false">Comentar</layer>
  </ilayer>
  </td>
  <td style="cursor:hand" class="enc_p" valign="top">
  <a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
  </td>
  </tr>
  <tr>
  <td width="100%" bgcolor="#FFFFFF" style="padding:4px" colspan="2"><p align="left" >..</p>
<textarea id="comentario" class="datospf" cols="80" rows="15"></textarea><input type="hidden"/><br />
<input type="button" onclick="aplicar()" value="Aplicar"/>
  </td>
  </tr>
  </table> 
</td>
</tr>
</table>
</div>

<div id="div_informe" style="position:absolute;width:200px; height:200px;left:30%;top:10%;visibility:hidden;">
<table border="1" width="500" class="enc_p" style="border-collapse: collapse; border-style: solid;
	border-color: #999999 ; border-width:4px" cellspacing="0" cellpadding="0">
<tr>
<td width="100%">
  <table border="1" class="act" width="100%" cellspacing="0" cellpadding="4" height="36">
  <tr style="border-bottom:thick; border-bottom-color:#000000">
  <td id="titleBar" class="enc_p" style="cursor:move" width="100%">
  <ilayer width="100%" onSelectStart="return false">
  <layer id="titulo" width="100%" onMouseover="isHot=true;if (isN4) ddN4(div_informe)" onMouseout="isHot=false">ELABORAR INFORME</layer>
  </ilayer>
  </td>
  <td style="cursor:hand" class="enc_p" valign="top">
  <a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
  </td>
  </tr>
  <tr>
  <td width="100%" bgcolor="#FFFFFF" style="padding:4px" colspan="2"><p align="left" >..</p><br />Planteamiento del Problema
<textarea id="planteamiento" class="datospf" cols="80" rows="5"></textarea><br />
Resultados de la Investigaci&oacute;n
<textarea id="resultados" class="datospf" cols="80" rows="5"></textarea><br>
An&aacute;lisis Acad&eacute;mico
<textarea id="analisis" class="datospf" cols="80" rows="5"></textarea><br />
Conclusiones y Recomendaciones
<textarea id="recomendacion" class="datospf" cols="80" rows="5"></textarea><input type="hidden"/><br />
<input type="button" onclick="aplicar_inf()" value="Aplicar"/>
  </td>
  </tr>
  </table> 
</td>
</tr>
</table>
</div>


<div id="div_prueba" style="width:200px; height:200px;position: fixed;left:8%;top:15%;visibility:hidden;">
<table border="1" width="500" class="enc_p" style="border-collapse: collapse; border-style: solid;
	border-color: #999999 ; border-width:4px" cellspacing="0" cellpadding="0">
<tr>
<td width="100%" >
  <table border="0" class="act" width="100%" cellspacing="0" cellpadding="4" height="36">
	<tr style="border-bottom:thick; border-bottom-color:#000000">
		<td id="titleBar" class="enc_p" style="cursor:move" width="100%" colspan="4">
			<ilayer width="100%" onSelectStart="return false">
				<layer id="titulo" width="100%" onMouseover="isHot=true;if (isN4) ddN4(div_prueba)" onMouseout="isHot=false">RESULTADOS PRUEBA APTITUDINAL</layer>
			</ilayer>
		</td>
		<td style="cursor:hand" class="enc_p" valign="top">
			<a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
		</td>
	</tr>
	<tr>
		<td width="100%" bgcolor="#FFFFFF" style="padding:4px" valign="top"><p align="left" style="color:red;font-size:12pt;text-decoration:underline;">..</p>
			<p align="center">PRUEBAS APTITUDINALES</p>
			<table id="razon" align="center" cellpadding="3" border="1" style="border-collapse:collapse;font-size:10pt;" class="enc_materias"><thead><th>Razonamiento</th><th>Puntaje</th><th>Percentil</th><th>Categoria</th></thead>
			<tbody><tr><td>Abstracto</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
			<tr><td>Verbal</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
			<tr><td>Num&eacute;rico</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
			<tr><td>Mec&aacute;nico</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
			<tr><td>Relaciones Espaciales</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
			</tbody>
			</table>
		</td>
		<td bgcolor="#FFFFFF">
<p>PRUEBA DE INTERESES</p>
<table id="inter" align="center" cellpadding="3" border="1" style="border-collapse:collapse;"  class="enc_materias"><thead><th>Inter&eacute;s</th><th>Puntaje</th><th>Percentil</th><th>Categoria</th></thead>
<tbody><tr><td>Aire Libre</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Mec&aacute;nico</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>C&aacute;lculo</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Cient&iacute;fico</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Persuasivo</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Art&iacute;stico</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Literario</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Musical</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Servicio Social</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
<tr><td>Oficina</td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="3" maxlength="3"/></td><td><input type="text" size="15" maxlength="17"/></td></tr>
</tbody>
</table>
</td>
<td valign="top">
<input type="hidden"/><p>CONCLUSIONES Y RECOMENDACIONES</p><textarea id="con_recom" class="datospf" cols="80" rows="5"></textarea><br /><br />
<input type="button" onclick="aplicar_prueba()" value="Aplicar"/>
  </td>
  </tr>
  </table> 
</td>
</tr>
</table>
</div>

<?php
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

if(!isset($depart) && !isset($perm))
{
	if($cargo=="7" || $cargo=="8" || $cargo=="15" || $cargo=="16")
		{
			$depart=9;
			$perm=1;
		}
	elseif($cargo=="100") 
		{
			$urace="Estudiante";
			$depart=0;
		}
	elseif($cargo=="3" || $cargo=="4" || $cargo=="5" || $cargo=="6" || $cargo=="11" || $cargo=="12" || $cargo=="13" || $cargo=="14")
		{
			
			$depart=10;
			$perm=1;
		}
	elseif($cargo=="1" || $cargo=="0")
		{
			
			$depart=7;
			$perm=1;
		}
	elseif($cargo=="18")
		{
			
			$depart=9;
			$perm=1;
		}
	else
	{
		$depart=substr($cargo,0,1);
		$perm=(substr($cargo,-1));
		$cargo_dep=$depart."0";
		$mSQL  = "SELECT cargo_d FROM autoridades WHERE cargo='$cargo_dep'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$urace=$result[0][0];
		if($depart==7) $depart=1;
	}
}
	
if($depart==7) $urace="UNIDAD REGIONAL DE ADMISION Y CONTROL DE ESTUDIOS";
if($depart==8) $urace="UNIDAD REGIONAL DE BIENESTAR ESTUDIANTIL";
if($depart==9) $urace="CONSEJO DIRECTIVO";
if($depart==10) $urace="CONSEJO UNIVERSITARIO";
if($depart==11) $urace="CONSEJO ACAD&Eacute;MICO";


$title="CASOS ESTUDIANTILES";
$raiz="../";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.0";
$copy = utf8_encode("© ".date(Y)." - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información");

include("../encabezado.php");
echo "<input type=\"hidden\" id=\"error\" value=\"SI\">";
//session_start();
//$_SESSION['conect'] = $conect;
//$_SESSION['depart'] = $depart;
//$_SESSION['lapso_in'] = $lap_conect;
//$_SESSION['espec']=$especialidad;

// Extrae todas las solicitudes a partir del departamento
$mSQL  = "SELECT solicitud,exp_e,f_emision,estado FROM space_casos WHERE depart='$depart' ORDER BY f_emision ";				
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

$solicitud=array();
$exp_e=array();
$f_emision=array();
$estado=array();

for($i=0; $i<$filas ; $i++)
	{
		$solicitud[$i]=$result[$i][0];
		$exp_e[$i]=$result[$i][1];
		$f_emision[$i]=implode("/",array_reverse(explode("-",$result[$i][2])));						// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
		$estado[$i]=$result[$i][3];		
	}

$conect = utf8_encode($conect);
print<<<TABLA

<input type="hidden" id="depart" value="$depart">
<table id="cuerpo" align="center" width="720px"><tbody>
<tr><td class="datos">&nbsp;&nbsp;&nbsp;Sesion: <b>$conect
TABLA;

if($depart==0) echo "</b><br>&nbsp;&nbsp;&nbsp;Expediente: <b>$expediente</b><br> &nbsp;&nbsp;&nbsp;Lapso de Ingreso: <b>$lap_conect</b><br> &nbsp;&nbsp;&nbsp;Especialidad: <b>$especialidad";

if($perm==1 || $perm==2) $permiso="";
else $permiso="disabled";

print<<<TABLACON
</b></td><td align="right"><input class="fecha" size="50" type="text" id="fecha" name="fecha" readonly="" disabled="disabled"></td></tr><tr><td colspan="2">
TABLACON;

switch($depart)
	{
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 9:
		case 10:
		case 11:
			print <<<TABLAINT
			<table id="tab_casos" width="100%" border="solid" cellpadding="3" align="center" class="datos">
					<thead class="enc_materias"><tr>
					<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>Solicitud</th><th>Expediente</th><th>Fecha Emision</th><th>Planilla Solicitud</th><th>Informe URDBE</th><th>Resolucion</th><th>Sesion</th><th>Comentar</th><th>Estado</th>
					</tr></thead><tbody id="tbod" align="center">
TABLAINT;
			if($filas==0)
				{
					echo "<tr><td colspan=\"10\" align=\"center\">No hay Solicitudes Pendientes</td></tr><tr><td align=\"right\" colspan=\"10\"><form action=\"archivo.php\" target=\"_blank\" method=\"POST\"><input type=\"hidden\" name=\"depart\" value=\"$depart\"><input type=\"submit\" value=\"Archivo\"></form></td></tr></tbody></table>";
				}
			else
				{
					
					for($i=0; $i<$filas; $i++)
						{	

							//---------------------- Se busca en la base de Datos si se emitio el Informe de URDBE----------------------------
							if(substr($solicitud[$i],0,2)=="08")
								{
									$val_btn="Resultados Prueba";
									$click="planilla(this)";
									$mSQL  = "SELECT fecha_eval,fecha_sol FROM space_prueba_apt WHERE solicitud='$solicitud[$i]'";
									$conex->ExecSQL($mSQL,__LINE__,true);
									$result = $conex->result;
									$fila = $conex->filas;
									if($conex->result[0][1]=="")// PRUEBA NO ENVIADA
										{
											$val_btn="Solicitar Prueba";
											$click="solicitar(this)";
											$dis_btn="";
											$dis_slt="";
											$dis_opt="disabled";
										}
									else
										{
											$dis_opt="";
											if($result[0][0]=="")				// si existe fecha de evaluacion el Boton se Habilita
												{
													$dis_btn="disabled";
													$dis_slt="disabled";
												}
											else
												{
													$dis_btn="";
													$dis_slt="";
												}
										}
								}
							else
								{
									$dis_opt="";
									$val_btn="Ver Informe";
									$click="planilla(this)";
									$mSQL  = "SELECT fecha FROM space_inf_urdbe WHERE solicitud='$solicitud[$i]'";
									$conex->ExecSQL($mSQL,__LINE__,true);
									$result = $conex->result;
									$fila = $conex->filas;
									if($fila==0)
										{
											if(substr($solicitud[$i],0,2)=="01" || substr($solicitud[$i],0,2)=="11") $dis_btn="";
											else $dis_btn="disabled";
											$val_btn="Solicitar Informe";
											$click="solicitar(this)";
											$dis_slt="";
										}
									else
										{
											if($result[0][0]=="")				// si existe fecha de informe el Boton se Habilita
												{
													$dis_btn="disabled";
													$dis_slt="disabled";
												}
											else
												{
													$dis_btn="";
													$dis_slt="";
												}
										}
								}


							if(substr($estado[$i],0,1)=="6") 
							{
								$com_esp=substr($estado[$i],15);
								$espera="selected=selected";
							}
							else 
							{
								$com_esp="";
								$espera="";
							}
							//------------ARMA EL SELECT DEL ESTADO SEGUN LA ENTIDAD O DEPARTAMENTO----------------------
							if($depart==9)
								{
									$estado[$i]="<select class=\"datospf\" $dis_slt>
									<option value=\"1) En Consejo Directivo - Por Aprobar\">En Consejo Directivo - Por Aprobar</option>
									<option value=\"2) Aprobado por Consejo Directivo - Por Procesar\">Aprobado por Consejo Directivo - Por Procesar</option>
									<option value=\"3) Rechazado por Consejo Directivo\">Rechazado por Consejo Directivo</option>
									<option value=\"1) En Consejo Universitario - Por Aprobar\">Transferir al Consejo Universitario</option>";
									
								}
							elseif($depart==10)
								{
									$estado[$i]="<select class=\"datospf\" $dis_slt>
									<option value=\"1) En Consejo Universitario - Por Aprobar\">En Consejo Universitario - Por Aprobar</option>
									<option value=\"2) Aprobado por Consejo Universitario - Por Procesar\">Aprobado por Consejo Universitario - Por Procesar</option>
									<option value=\"3) Rechazado por Consejo Universitario\">Rechazado por Consejo Universitario</option>";
								}
							elseif($depart==11)
								{
									$estado[$i]="<select class=\"datospf\" $dis_slt>
									<option value=\"1) En Consejo Academico - Por Aprobar\">En Consejo Academico - Por Aprobar</option>
									<option value=\"2) Aprobado por Consejo Academico - Por Procesar\">Aprobado por Consejo Academico - Por Procesar</option>
									<option value=\"3) Rechazado por Consejo Academico\">Rechazado por Consejo Academico</option>
									<option value=\"1) En Consejo Directivo - Por Aprobar\">Transferir al Consejo Directivo</option>";
									
								}
							else
								{
									$estado[$i]="<select class=\"datospf\" $dis_slt>
									<option value=\"1) En Dpto. Academico - Por Aprobar\">En Dpto. Academico - Por Aprobar</option>
									<option value=\"2) Aprobado por Dpto. Academico - Por Procesar\" $dis_opt>Aprobado por Dpto. Academico - Por Procesar</option>
									<option value=\"3) Rechazado por Dpto. Academico\">Rechazado por Dpto. Academico</option>
									<option value=\"1) En Consejo Academico - Por Aprobar\">Transferir a Consejo Academico</option>";
								}
							
							$estado[$i].="<option value=\"6) En Espera\" $espera>En Espera</option>";
							
							$estado[$i].="<option value=\"7) Caso Vencido\">Caso Vencido</option>";

							$estado[$i].="</select>";
							
							
							$estado[$i] = utf8_encode($estado[$i]);
							print <<<TABLAINT2
							<tr id="fila$i"><td><input id="sel$i" type="checkbox"></td><td>$solicitud[$i]</td><td><a style='cursor: pointer;' class="exp"  onClick="window.open('datos_e.php?e=$exp_e[$i]&c=$conect')">$exp_e[$i]</a></td><td>$f_emision[$i] </td><td><form method="POST" action="planilla.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="planilla(this)" value="Ver solicitud"><input type="hidden" name="sol"></form></td><td><form method="POST" action="informe.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="$click" value="$val_btn" $dis_btn><input type="hidden" name="sol"></form></td><td><input type="text" size="8"  class="datospf"></td><td><input type="text" size="8" class="datospf"></td><td><textarea onmousedown="editar(this)" onmouseup="showMe(this)" id="comen$i" rows="2" cols="8" class="datospf" readonly="readonly" name="div_com">$com_esp</textarea></td><td>$estado[$i]</td></tr>
TABLAINT2;

						} //fin de ciclo de filas
						
				
# botones de accion			
			print <<<CIERRA
</tbody><tbody><tr><td colspan="9" align="center" style="border:none"><input type="button" onclick="guardar(this)" value="Guardar Cambios" $permiso></td><td style="border:none" align="right" valign="bottom"><br><form action="archivo.php" target="_blank" method="POST"><input type="hidden" name="depart" value="$depart"><input type="submit" value="Archivo"></form></td></tr><tr><td colspan="10"><div id="capa"></div></td></tr></tbody></table></td></tr></tbody></table>
CIERRA;
				}
				
			break;
		
		case 7:
			print <<<TABLAINT
					<table id="tab_casos"  width="100%" border="solid" cellpadding="3" align="center" class="datos">
					<thead class="enc_materias"><tr>
					<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>Solicitud</th><th>Expediente</th><th>Especialidad</th><th>Fecha Emision</th><th>Planilla Solicitud</th><th>Carta Departamento</th><th>Estado</th>
					</tr></thead><tbody id="tbod" align="center">
TABLAINT;
			if($filas==0)
				{
					echo "<tr><td colspan=\"8\" align=\"center\">No hay Solicitudes Pendientes</td></tr><tr><td align=\"right\" colspan=\"7\"><form action=\"archivo.php\" target=\"_blank\" method=\"POST\"><input type=\"hidden\" name=\"depart\" value=\"7\"><input type=\"submit\" value=\"Archivo\"></form></td></tr></tbody></table>";
				}
			else
				{
					for($i=0; $i<$filas; $i++)
						{	
							$mSQL  = "SELECT a.carrera1 FROM tblaca010 a, dace002 b, space_casos c WHERE b.c_uni_ca=a.c_uni_ca AND b.exp_e='$exp_e[$i]'";
							$conex->ExecSQL($mSQL,__LINE__,true);
							$espec = $conex->result[0][0];
																					
							
							if(substr($estado[$i],0,21)=="2) Aprobado por Dpto.")
								{
									$estado[$i]="2) Aprobado por Dpto. Academico - Por Procesar";
								}
							if(	substr($solicitud[$i],0,2)=="06" || 
								substr($solicitud[$i],0,2)=="07" || 
								substr($solicitud[$i],0,2)=="09" || 
								substr($solicitud[$i],0,2)=="14" || 
								substr($solicitud[$i],0,2)=="10"
							)
								{
									$dis_btn="disabled";
									$estado[$i]=substr($estado[$i],3);
								}
							else
								{
									$dis_btn="";
									$estado[$i]=substr($estado[$i],3);
								}
							print <<<TABLAINT2
							<tr id="fila$i">
							<td><input id="sel$i" type="checkbox"></td><td>$solicitud[$i]</td><td>$exp_e[$i]</td><td>$espec</td><td>$f_emision[$i]</td><td><form method="POST" action="planilla.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="planilla(this)" value="Ver solicitud"><input type="hidden" name="sol"></form></td><td><form method="POST" action="cartadep.php" target="carta" onSubmit="window.open('','carta')"><input type="button" onclick="planilla(this)" value="Ver Carta" $dis_btn><input type="hidden" name="sol"></form></td><td>$estado[$i]</td></tr>
TABLAINT2;
						}
					
				
			print <<<CIERRA
</tbody><tbody>
<tr>
	<td colspan="7" align="center" style="border:none">
		<input type="button" onclick="guardar(this)" value="Procesado" $permiso>
		<input type="button" onclick="guardar(this)" value="Rechazado" $permiso>
	</td>
	<td style="border:none" align="right" valign="bottom">
		<br>
		<form action="archivo.php" target="_blank" method="POST">
			<input type="hidden" name="depart" value="7">
			<input type="submit" value="Archivo">
		</form>
	</td>
</tr><tr><td colspan="10"><div id="capa"></div></td></tr></tbody></table></td></tr></tbody></table>
CIERRA;

				}
			break;
		case 0:
			//------------------------ Se busca en la tabla las solicitudes solo del estudiante---------------
			$mSQL  = "SELECT solicitud,f_emision,estado FROM space_casos WHERE exp_e='$expediente'";
			$conex->ExecSQL($mSQL,__LINE__,true);
			$result = $conex->result;
			$filas = $conex->filas;
			
			print <<<TABLAINT
					<table id="tab_casos" width="100%" border="solid" cellpadding="3" align="center" class="datos">
					<thead class="enc_materias"><tr>
					<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>Solicitud</th><th>Fecha Emision</th><th>Planilla Solicitud</th><th>Carta Departamento</th><th>Estado</th>
					</tr></thead><tbody id="tbod" align="center">
TABLAINT;
			
			if($filas==0)
			{
				echo "<tr><td colspan=\"6\" align=\"center\">No hay Solicitudes Pendientes</td></tr><tr><td colspan=\"2\" align=\"left\" valign=\"bottom\" style=\"border:none\"><form action=\"../solicitud/solicitud.php\" method=\"POST\" target=\"_blank\"><input type=\"hidden\" name=\"exp\" value=\"$expediente\"><input type=\"hidden\" name=\"conect\" value=\"$conect\"><input type=\"hidden\" name=\"lapso_in\" value=\"$lap_conect\"><input type=\"hidden\" name=\"espec\" value=\"$especialidad\"><input type=\"submit\" value=\"Nueva Solicitud\"></form></td><td style=\"border:none\" align=\"right\" colspan=\"7\"><form action=\"archivo.php\" target=\"_blank\" method=\"POST\"><input type=\"hidden\" name=\"depart\" value=\"$depart\"><input type=\"hidden\" name=\"exped\" value=\"$expediente\"><input type=\"submit\" value=\"Archivo\"></form></td></tr></tbody></table>";
			}
			else
			{
			$solicitud=array();
			$f_emision=array();
			$estado=array();
	
			for($i=0; $i<$filas ; $i++)
				{
					$solicitud[$i]=$result[$i][0];
					$f_emision[$i]=implode("/",array_reverse(explode("-",$result[$i][1])));						// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
					$estado[$i]=$result[$i][2];		
					
					if(substr($estado[$i],0,1)=="2" || $estado[$i]=="3) Rechazado por Consejo Universitario") $dis_chk="disabled";
					else $dis_chk="";
						
					if(substr($estado[$i],0,21)=="3) Rechazado por Dpto")
						{
							$estado[$i]="<select class=\"datospf\">
							<option value=\"3) Rechazado por Dpto. Academico\">Rechazado por Dpto. Academico</option>
							<option value=\"1) En Consejo Academico - Por Aprobar\">Apelar Desición</option>
							</select>";
							$dis_btn="";
						}
					elseif(substr($estado[$i],0,29)=="3) Rechazado por Consejo Acad")
						{
							$estado[$i]="<select class=\"datospf\">
							<option value=\"3) Rechazado por Consejo Academico\">Rechazado por Consejo Academico</option>
							<option value=\"1) En Consejo Directivo - Por Aprobar\">Apelar Desición</option>
							</select>";
							$dis_btn="";
						}
					elseif($estado[$i]=="3) Rechazado por Consejo Directivo")
						{
							$estado[$i]="<select class=\"datospf\">
							<option value=\"3) Rechazado por Consejo Directivo\">Rechazado por Consejo Directivo</option>
							<option value=\"1) En Consejo Universitario - Por Aprobar\">Apelar Desición</option>
							</select>";
							$dis_btn="";
						}
					elseif(substr($estado[$i],0,1) == 7)
						{
							/*$estado[$i]="<select class=\"datospf\">
							<option value=\"3) Rechazado por Consejo Directivo\">Rechazado por Consejo Directivo</option>
							<option value=\"1) En Consejo Universitario - Por Aprobar\">Apelar Desición</option>
							</select>";*/
							$dis_btn="disabled";
						}
					else
						{
							if((substr($estado[$i],0,1)!="1") and (substr($estado[$i],0,1)!="6"))
								{
									$dis_btn="";
								}
							else
								{
									$dis_btn="disabled";
								}
							$estado[$i]=substr($estado[$i],3);
						}


					if (substr($solicitud[$i],0,2) == '10'){
						$dis_btn="disabled";
					}
							
					print <<<TABLAINT2
					<tr id="fila$i">
					<td><input id="sel$i" type="checkbox" $dis_chk></td><td>$solicitud[$i]</td><td>$f_emision[$i]</td><td><form method="POST" action="planilla.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="planilla(this)" value="Ver solicitud"><input type="hidden" name="sol"></form></td><td><form method="POST" action="cartadep.php" target="carta" onSubmit="window.open('','carta')"><input type="button" onclick="planilla(this)" value="Ver Carta" $dis_btn><input type="hidden" name="sol"></form></td><td>$estado[$i]</td></tr>
TABLAINT2;
				}
			
			print <<<CIERRA
</tbody><tbody><tr><td align="center" colspan="6"><table align="center" width="100%"><tr><td colspan="2" align="left" valign="bottom" style="border:none"><form action="../solicitud/solicitud.php" method="POST" target="_blank"><input type="hidden" name="exp" value="$expediente"><input type="hidden" name="conect" value="$conect"><input type="hidden" name="lapso_in" value="$lap_conect"><input type="hidden" name="espec" value="$especialidad"><input type="submit" value="Nueva Solicitud"></form></td>
<td colspan="3" align="center"  style="border:none"><input type="button" onclick="guardar(this)" value="Guardar Cambios"></td><td><input type="button" onclick="guardar(this)" value="Eliminar Solicitud"></td><td style="border:none" align="right" colspan="1"><form action="archivo.php" target="_blank" method="POST"><input type="hidden" name="depart" value="$depart"><input type="hidden" name="exped" value="$expediente"><input type="submit" value="Archivo"></form></td></tr></table></td></tr><tr><td colspan="6"><div id="capa"></div></td></tr></tbody></table></td></tr></tbody></table>
CIERRA;

			}
		break;
	case 8:
		//----------- Se consulta en la Base de Datos si existe una peticion de informe de URDBE por parte de algun Departamento-------------------
		$mSQL  = "SELECT solicitud,fecha FROM space_inf_urdbe";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$parte1 = $conex->filas;
		
		//-------------------se cargan las solicitudes a un vector--------------------------
		$sol=array();
		$fec=array();
		for($i=0; $i<$parte1; $i++)
			{
				$sol[$i]=$result[$i][0];
				$fec[$i]=$result[$i][1];
			}
		//-------------------- Se consulta en la Base de Datos si existe alguna solicitud para la prueba Aptitudinal------------------------
		$nada="";
		
		if ($perm != '3'){
//AND @SUBSTRING(solicitud,0,5)='08132'
		$mSQL  = "SELECT solicitud,fecha_eval,fecha_sol FROM space_prueba_apt WHERE fecha_sol is not null AND solicitud IN (SELECT solicitud FROM space_casos WHERE @SUBSTRING(estado,0,1) IN ('1','6') AND @SUBSTRING(solicitud,0,2) = '08') ORDER BY fecha_sol ";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$filas = $conex->filas;
		$parte = $conex->filas + $parte1;
		$j=0;
		$num=0;
		for($i=$parte1; $i<$parte; $i++, $j++)
			{
				if($result[$j][2]=="") $num++;
				else
					{
					 $sol[$i]=$result[$j][0];
					 $fec[$i]=$result[$j][1];
					}
			}
		$parte = $parte-$num;					// Excluye los casos que los departamentos aun no solicitan la Prueba aptitudinal a DOBE
		}else $parte=$parte1;
		print <<<TABLAINT
					<table id="tab_casos"  width="100%" border="solid" cellpadding="3" align="center" class="datos">
					<thead class="enc_materias"><tr>
					<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>Solicitud</th><th>Planilla Solicitud</th><th>Elaborar</th><th>Ver Informe</th></tr></thead><tbody id="tbod" align="center">
TABLAINT;
		if($parte==0)
				{
					echo "<tr><td colspan=\"5\" align=\"center\">No hay Solicitudes Pendientes</td></tr><tr><td align=\"right\" colspan=\"7\"><form action=\"archivo.php\" target=\"_blank\" method=\"POST\"><input type=\"hidden\" name=\"depart\" value=\"7\"><input type=\"submit\" value=\"Archivo\"></form></td></tr></tbody></table>";
				}
		else
		{
		for($i=0; $i<$parte; $i++)
			{
			if($fec[$i]=="")
				{
				if(substr($sol[$i],0,2)=="08")
					{
						$val_btn="Resultados Prueba Aptitudinal";
						$click="result(this)";
						$name="div_prueba";
						$campos="<input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\"><input type=\"hidden\" value=\"--\">";
					}
				else
					{
						$val_btn="Informe";
						$click="informe(this)";
						$name="div_informe";
						$campos="<input type=\"hidden\" id=\"plant$i\"><input type=\"hidden\" id=\"res$i\"><input type=\"hidden\" id=\"ana$i\"><input type=\"hidden\" id=\"rec$i\">";
					}
				if($cargo!="85" || ($cargo=="85" && substr($sol[$i],0,2)=="08"))	//---Permiso al Psicologo solo de ver los casos que le corresponde
					{
					print <<<TABLAINT2
					<tr id="fila$i">
					<td><input id="sel$i" type="checkbox"></td><td>$sol[$i]</td><td><form method="POST" action="planilla.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="planilla(this)" value="Ver solicitud"><input type="hidden" name="sol"></form></td><td><input type="button" onmousedown="$click" onmouseup="showMe(this)" value="$val_btn" name="$name" id="boton$i">$campos</td><td><form method="POST" action="informe.php" target="pagina" onSubmit="window.open('','pagina')"><input type="button" onclick="planilla(this)" value="Ver Informe"><input type="hidden" name="sol"></form></td></tr>
TABLAINT2;
					}
				}				
			}

			print <<<CIERRA
</tbody><tbody><tr><td colspan="3" align="center" style="border:none"><input type="button" onclick="env_inf(this)" value="Enviar"></td><td style="border:none" align="right" valign="bottom"><br><form action="archivo.php" target="_blank" method="POST"><input type="hidden" name="depart" value="$depart"><input type="submit" value="Archivo"></form></td></tr><tr><td colspan="10"><div id="capa"></div></td></tr></tbody></table></td></tr></tbody></table>
CIERRA;

	}
		break;
	}
echo "<script language=javascript>ajustar();</script>";

include("../pie.php");
?>