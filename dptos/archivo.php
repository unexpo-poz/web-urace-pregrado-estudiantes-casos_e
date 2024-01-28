<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");

$exped=$_POST['exped'];
require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

//______________________________________NOMBRE DEL DEPARTAMENTO___________________________________________________

$depart=$_POST['depart'];

if($depart==7) $urace="UNIDAD REGIONAL DE ADMISION Y CONTROL DE ESTUDIOS";
elseif($depart==8) $urace="UNIDAD REGIONAL DE BIENESTAR ESTUDIANTIL";
elseif($depart==9) $urace="CONSEJO DIRECTIVO";
elseif($depart==10) $urace="CONSEJO UNIVERSITARIO";
elseif($depart==11) $urace="CONSEJO ACAD&Eacute;MICO";
elseif($depart==0) $urace="Estudiante";
else
	{
		$cargo_dep=$depart."0";
		$mSQL  = "SELECT cargo_d FROM autoridades WHERE cargo='$cargo_dep'";
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$urace=$result[0][0];
	}

//_______________________________________________________________________________________________

$title="ARCHIVO CASOS ESTUDIANTILES";
$raiz="../";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.0";
$copy="© 2009 - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";

include("../encabezado.php");
echo "<input type=\"hidden\" id=\"error\" value=\"NO\">";
print <<<TABLAINT
<table id="cuerpo" cellpadding="3" align="center" class="datos">
<tbody>
<tr><td align="right" border="none"><input class="fecha" size="50" type="text" id="fecha" name="fecha" readonly="" disabled="disabled"></td></tr>
TABLAINT;

if($depart=="7" || $depart=="8" || $depart=="9" || $depart=="10" || $depart=="11")
{
print<<<BUSQUEDA
	<tr><td>
	<fieldset class="fieldset"><legend class="legend">&Iacute;NDICE DE B&Uacute;SQUEDA</legend>
	<table>
	<tr><td>
	<blockquote><select id="por" onchange="param_bus(this)" class="datospf">
			<option value="0">.:BUSCAR POR:.</option>
			<option value="todos">TODOS</option>
			<option value="aprob">Aprobados</option>
			<option value="rechaz">Rechazados</option>
			<option value="proces">Procesados</option>
			<option value="fecha">Fecha</option>
			<option value="lapso">Lapso</option>
			<option value="caso">Caso</option>
			<option value="depar">Departamento</option>
			<option value="solic">Solicitud</option>
			<option value="exped">Expediente</option>
		</select><input type="button" value="Buscar" onclick="buscar(this)"><input type="hidden" value="space_archivo"><input type="hidden" value="capa">
	</blockquote>
	</td>
	<td id="campos"></td>
	</table>
	</fieldset>
	</td></tr>
BUSQUEDA;

}
else
{
$tab="space_archivo";
if($depart=="0")
	{
		$busq="exped";
		$param=$exped;		
	}
else
	{
		$busq="depar";
		$param=$depart;
	}
}

print<<<TABLAPIE
<tr><td colspan="2">
<div id="capa"></div>
</td></tr>
</tbody></table>
TABLAPIE;
if($depart!="7" && $depart!="8" && $depart!="9" && $depart!="10" && $depart!="11")
	{
		echo "<script language=javascript>fajax('ver_archivo.php','capa','por=$busq&parametro=$param&tabla=$tab','post','0');
		ajustar_ar();</script>";
	}

include("../pie.php");
?>