<?php
//session_start();
$cedula=$_GET['ced'];
$conect=$_GET['conect'];

require_once("../odbc/odbcss_c.php");
require_once("../odbc/config.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

$title="CASOS ESTUDIANTILES";
$raiz="../";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.0";
$copy="© 2009 - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";

include("../encabezado.php");
echo "<input type=\"hidden\" id=\"error\" value=\"NO\">";

$mSQL  = "SELECT cargo_d,cargo FROM autoridades WHERE cedula='$cedula'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

print<<<TABLA
<table id="cuerpo" align="center" width="720px" class="datos"><tbody>
<tr><td class="datos">&nbsp;&nbsp;&nbsp;Sesion: <b>$conect
</b></td><td align="right"><input class="fecha" size="50" type="text" id="fecha" name="fecha" readonly="" disabled="disabled"></td></tr><tr><td colspan="2"style="font-size:12px" align="center">
<br><br>Usted tiene permisos asignados para mas de un departamento, Indique por cual desea entrar<br><br>
<form action="dptos.php" target="_self" method="POST">
<select name="depart" class="datospf">
TABLA;

for($i=0; $i<$filas ; $i++)
	{
		$cargo=$result[0][1];
		$cargo_d=$result[0][0];
		if($cargo=="17" || $cargo=="18") {
			echo "<option value=\"9\">Consejo Directivo</option><option value=\"11\">Consejo Acad&eacute;mico</option>"; $perm=1;
		}
		elseif($cargo=="81") {echo "<option value=\"8\">Unidad Regional de Bienestar Estudiantil</option><option value=\"11\">Consejo Acad&eacute;mico</option>";  $perm=1;}
		else
			{
				$depart=substr($cargo,0,1);
				$perm=(substr($cargo,-1));
				echo "<option value=\"$depart\">$cargo_d</option>";
			}
	}

print<<<TABLACON
</select>
<input type="submit" value="Entrar"><br><br>
<input type="hidden" name="perm" value="$perm">
<input type="hidden" name="conect" value="$conect">
</form>
</td></tr></tbody></table>

TABLACON;
include("../pie.php");

?>