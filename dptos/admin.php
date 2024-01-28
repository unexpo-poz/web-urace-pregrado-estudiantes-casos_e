<?php
require_once("../odbc/config.php");
require_once("../odbc/odbcss_c.php");
$title="CASOS ESTUDIANTILES";
$raiz="../";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.0";
$copy="© 2009 - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";
$urace="ADMINISTRADOR DE TABLAS";

include("../encabezado.php");
echo "<input type=\"hidden\" id=\"error\" value=\"NO\">";
print <<<TABLAINT
<table id="cuerpo" cellpadding="3" align="center" class="datos" width="700px">
<tbody>
<tr><td align="right" border="none"><input class="fecha" size="40" type="text" id="fecha" name="fecha" readonly="" disabled="disabled"></td></tr>
TABLAINT;

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
			<option value="caso">Caso</option>
			<option value="depar">Departamento</option>
			<option value="solic">Solicitud</option>
			<option value="exped">Expediente</option>
		</select><input type="button" value="Buscar" onclick="buscar(this)"><input type="hidden" value="space_casos"><input type="hidden" value="capa">
	</blockquote>
	</td>
	<td id="campos"></td>
	</table>
	</fieldset>
	</td></tr>
BUSQUEDA;

print<<<TABLAPIE
<tr><td colspan="2">
<div id="capa"></div>
</td></tr>
</tbody>
<tfoot><tr><td><br><br><fieldset class="fieldset"><legend class="legend">Resultados</legend><div id="status"></div></fieldset></td></tr><tr><td align="center" colspan="2"><input type="button" onclick="admin_elim()" value="Eliminar Filas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="javascript:self.close()" value="Salir"></td></tr></tfoot>
</table>
TABLAPIE;

include("../pie.php");

?>