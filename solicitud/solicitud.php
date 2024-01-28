<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$title="FORMULARIO DE CASOS ESTUDIANTILES";
$poz="Vicerrectorado Puerto Ordaz";
$urace="Unidad Regional de Admisión y Control de Estudios";
$version="Version 1.0";
$copy="© 2009 - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";
include("../encabezado.php");
echo "<input type=\"hidden\" id=\"error\" value=\"NO\">";
//session_start();
$conect=$_POST['conect'];
$lapso = $_POST['lapso_in'];
$exp_e=$_POST['exp'];
$especialidad=$_POST['espec'];

require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT c_uni_ca,pensum FROM dace002 WHERE exp_e='$exp_e'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$c_uni_ca=$result[0][0];
$pensum=$result[0][1];


$mSQL = "SELECT MAX(a.rep_sta) FROM repitencia a,tblaca008 b WHERE rep_exp='$exp_e' AND b.c_asigna=a.rep_mat";
$conex->ExecSQL($mSQL,__LINE__,true);
$rep_sta=$conex->result[0][0];

$mSQL  = "SELECT a.rep_mat,b.asignatura FROM repitencia a,tblaca008 b, tblaca009 c WHERE rep_exp='$exp_e' AND b.c_asigna=a.rep_mat and rep_sta='".$rep_sta."' AND a.rep_mat=c.c_asigna AND c.pensum='$pensum' AND c.c_uni_ca='$c_uni_ca' ";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;

$filas = $conex->filas;
$rep_mat=$result[0][0];
$nom_rep_mat=$result[0][1];


if($filas > 0)
	{
		if($rep_sta==1) $articulo="61";
		if($rep_sta==2 || $rep_sta==3) $articulo="62";
		if($rep_sta>3) $articulo="63";
		
		$aviso= " - NOTA: El Bachiller $conect se encuentra en R&eacute;gimen de Repitencia segun el articulo No. $articulo por la asignatura: $rep_mat - $nom_rep_mat.<br>\n";
	}
else $aviso="";
?>
<table width="720px" align="center"><tr><td>
<form action="procesar.php" method="POST" id="formulario" name="formulario" target="pagina" onsubmit="javascript:window.open('','pagina')">
<input type="hidden" name="cant_mat" id="cant" value="1">
<input type="hidden" name="lap_in" id="lap_in" <?php echo "value=\"$lapso\"";?> >
<input type="hidden" name="lap_proc" id="lap_proc" <?php echo "value=\"$lapsoProceso\"";?> >
<input type="hidden" name="aviso" id="aviso" <?php echo "value=\"$aviso\"";?> >
<input type="hidden" name="c_uni_ca" id="c_uni_ca" <?php echo "value=\"$c_uni_ca\"";?> >

<input type="hidden" id="p01" <?php echo "value=\"$retiro\"";?> />
<input type="hidden" id="p02" <?php echo "value=\"$agrega\"";?> />
<input type="hidden" id="p03" <?php echo "value=\"$exon3s\"";?> />
<input type="hidden" id="p04" <?php echo "value=\"$prelac\"";?> />
<input type="hidden" id="p05" <?php echo "value=\"$trasla\"";?> />
<input type="hidden" id="p06" <?php echo "value=\"$ca_tes\"";?> />
<input type="hidden" id="p07" <?php echo "value=\"$co_dat\"";?> />
<input type="hidden" id="p08" <?php echo "value=\"$cambio\"";?> />
<input type="hidden" id="p09" <?php echo "value=\"$ca_equ\"";?> />
<input type="hidden" id="p10" <?php echo "value=\"$reingr\"";?> />
<input type="hidden" id="p11" <?php echo "value=\"$inscri\"";?> />
<input type="hidden" id="p12" <?php echo "value=\"$exc22u\"";?> />
<input type="hidden" id="p13" <?php echo "value=\"$co_not\"";?> />
<input type="hidden" id="p14" <?php echo "value=\"$reclam\"";?> />
<input type="hidden" id="p15" <?php echo "value=\"$retire\"";?> />

<table  align="center" width="720px">
<tr><td class="datos" width="50%"><?php echo "&nbsp;&nbsp;&nbsp;Sesion Iniciada: <b>$conect</b><br> &nbsp;&nbsp;&nbsp;Expediente: <b>$exp_e</b><br> &nbsp;&nbsp;&nbsp;Lapso de Ingreso: <b>$lapso</b><br> &nbsp;&nbsp;&nbsp;Especialidad: <b>$especialidad</b>"; ?></td><td align="right" width="50%"><input class="fecha" size="50" type="text" id="fecha" name="fecha" readonly="" disabled="disabled" style="overflow: auto;"></td></tr>
<tr><td class="datosp" colspan="2">Tipo de Caso<br>
<select id="caso" name="num_caso" class="datospf" onChange="campos()">
<option value="0">Seleccione una Opci&oacute;n</option>
<option value="01">Retiro Extempor&aacute;neo</option>
<option value="15">Retiro Especial por Conflicto con Normativa</option>
<option value="02">Agregado Extempor&aacute;neo / Recursar</option>
<option value="03">Exoneraci&oacute;n de Co y/o Pre Requisitos</option>
<option value="04">Prelacion de Asignatura</option>
<option value="05">Traslado de Lapso (Tesis/Entrenamiento)</option>
<option value="06">Solicitud de Carga de Notas (Tesis)</option> 
<option value="07">Correcci&oacute;n de Datos Personales</option> 
<option value="08">Cambio de Especialidad</option>
<option value="09">Carga de Materias por Equivalencia (Interna)</option>
<option value="10">Reingreso</option>
<option value="11">Inscripci&oacute;n Tard&iacute;a</option>
<option value="12">Exceso de 22 Unidades de Cr&eacute;dito</option> 
<option value="13">Correcci&oacute;n de Nota</option>
<option value="14">Reclamo de Operaciones Web</option>
</select>

</td></tr>
<tr><td class="datosp" colspan="2">
<table cellpadding="5" id="tabla_campos" align="center" width="100%"><tr id="campos"></tr></table>
</td></tr>
<tr><td class="datosp" colspan="2"><table><tr><td>Descripci&oacute;n del Caso<br><textarea  cols="110" id="mensaje" name="descrip" class="datospf" rows="5" onkeyup="restantes(this)"></textarea><br /></td><td valign="bottom">Caracteres restantes<br /><input type="text" size="2" id="rest" value="300" readonly="readonly"/></td></tr><tr><td><textarea cols="110" id="obser" name="obser" rows="1" readonly="readonly" class="datospf" style="visibility:hidden; color:#FF0000; font-weight:bold"></textarea></td></tr></table></td></tr> 
<tr><td align="center" colspan="2"><input type="button" value="Enviar" id="enviar" onclick="validar(this)">
<input type="button" onclick="window.close()" value="Salir"></form></td></tr>
<tfoot><tr class="resumen">
<td colspan="2" style="padding-left:10px;text-align:justify;"> - Los casos que requieran Documentos Justificativos, Soportes o Constancias, el estudiante debe de presentarlos directamente por <b>URDBE</b>.<br>
                 - Todos los casos tienen 15 d&iacute;as h&aacute;biles para entregar los recaudos en al departamento solicitado.<br>
				 - Para el cambio de especialidad, el estudiante debe acercarse a <b>URDBE</b> para ser aplicada una Prueba Aptitudinal.<br><br>
				 - Si no conoces el C&oacute;digo de la(s) asignaturas <a href="/web/urace/consultas/consulta_pensum/inicio.php" target="_blank" style="color:#FFFF00;font-weight:bold;">Consulta tu Pensum de Estudio</a><br>
				 <!-- <a href="/web/consultas/consulta_pensum/inicio.php" target="_blank">

							
							<select name="Esp" size="1" id="Esp" style="font-size: 8pt">
							<option>&lt;&lt; Pensum a Consultar &gt;&gt;</option>
							<option value="3">Ingeniería Eléctrica</option>
							<option value="5">Ingeniería Electrónica</option>
							<option value="6">Ingeniería Industrial</option>

							<option value="2">Ingeniería Mecánica</option>
							<option value="4">Ingeniería Metalúrgica</option>
							</select> </p>
							<font size="1">
							<input type="submit" name="submit1" value="Consultar" style="font-size: 8pt">
							</font></p> -->
				
			 	
</td>
</tr>
</tfoot>
</table>
</form>
<?php
include("../pie.php");
?>
<!-- ----------------OCULTO------------- -->
<?php// print_r($_POST); ?>
<table id="tabla" style="visibility:hidden" width="650px">
<tr id="fila">
<td id="td_asig" align="center">C&oacute;digo de Asignatura&nbsp;&nbsp;<input type="text" size="6" name="c_asigna0" maxlength="6" class="datospf" onkeyup="nomasig(this)" onBlur="nomasig(this)"><div id="capa"></div></td><td id="td_prela">
Asignatura Requisito&nbsp;&nbsp;<input type="text" size="6" name="prelacion" maxlength="6" class="datospf" onkeyup="nomasig(this)"><div id="capap"></div>
</td><td id="td_lapso_act" width="130">
Lapso &nbsp;<input type="text" size="4" name="ano_act" id="lap1" maxlength="4" class="datospf" onKeyup="apuntar(this)" >-<input type="text" size="2" name="lap_act" id="lap2" maxlength="2" onblur="mayus(this)" class="datospf" >
</td><td id="td_lapso_fin" width="190">
Lapso Destino&nbsp;<input type="text" size="4" name="ano_fin" maxlength="4" class="datospf" onkeyup="apuntar(this)">-<input type="text" size="2" name="lap_fin" maxlength="2" onblur="mayus(this)" class="datospf">
</td><td id="td_nota_act">
Nota Actual&nbsp;&nbsp;<input type="text" size="4" name="nota_act" maxlength="4" onkeyup="punto(this)" class="datospf">
</td><td id="td_nota_fin">
Nota Real&nbsp;&nbsp;<input type="text" size="4" name="nota_fin" maxlength="4" onkeyup="punto(this)" class="datospf">
</td>
<td id="td_exceso">
Cr&eacute;ditos en exceso&nbsp;&nbsp;<input type="text" size="2" name="exceso" maxlength="2" class="datospf"> 
</td>
</tr><tr><!-- Cambio de especialidad -->
<?php
#Rutina para aplicar normativa para cambio de especialidad.

$cumple = true;// Inicialmente todo estudiante cumple con los requisitos.
$mensaje = "";// 

$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,true,"normativa_cambio_".date('m-Y').".log");
$conex->iniciarTransaccion("Inicia Transaccion: ".$exp_e." - ");

#Articulo 1
$mSQL = "SELECT solicitud, f_emision, estado FROM space_casos WHERE exp_e='".$exp_e."' ";
$mSQL.= "AND @SUBSTRING(solicitud,0,2) ='08' AND @SUBSTRING(estado,0,1) NOT IN  ('3','7') ORDER BY 2 ";
$conex->ExecSQL($mSQL,__LINE__,true);// Busca si tiene solicitud de cambio sin rechazados o vencidos.

if ($conex->filas > 0){
	$cumple = false;
	$mensaje.= "Ud. no cumple con el <b>Articulo 1º</b> de la <a style='font-weight:bold;color:#000000;' href='/web/pdf/leyes_y_reglamentos/nor_cambio_especialidad.pdf' target='_blank'>Normativa Interna para Cambios de Especialidad</a>.";

	$mensaje.= "<br><br>Ya posee ".$conex->filas;
	$mensaje.= ($conex->filas > 1) ? " solicitudes " : " solicitud ";
	$mensaje.= "para cambio de especialidad. Los datos se muestran a continuacion:";

	$mensaje.= "<table border='1' style='border-collapse:collapse;background-color:#FFFFFF;' width='100%'>";
	$mensaje.= "<tr style='text-align:center;font-weight:bold;'>";
		$mensaje.= "<td>Nro. Solicitud</td>";
		$mensaje.= "<td>Fecha Emision</td>";
		$mensaje.= "<td>Estado</td>";
	$mensaje.= "</tr>";
	foreach ($conex->result as $sol_prev) {
		$mensaje.= "<tr style='text-align:center;'>";
			$mensaje.= "<td>".$sol_prev[0]."</td>";
			$mensaje.= "<td>".implode("/",array_reverse(explode("-",$sol_prev[1])))."</td>";
			$mensaje.= "<td>".substr($sol_prev[2],2)."</td>";
		$mensaje.= "</tr>";
	}
	$mensaje.= "</table><br><br>";
}
# Fin Articulo 1

#Articulo 3
$mSQL = "SELECT a.c_asigna, b.asignatura FROM tblaca009 a, tblaca008 b ";
$mSQL.= "WHERE semestre<'03' AND c_uni_ca='".$c_uni_ca."' AND pensum='".$pensum."' AND a.c_Asigna=b.c_asigna ";
$mSQL.= "AND a.c_asigna NOT IN (SELECT c_asigna FROM dace004 WHERE exp_e='".$exp_e."' AND status IN ('0','3','B','C')) ";
$conex->ExecSQL($mSQL,__LINE__,true);// Busca si tiene materias pendientes menores al 3er semestre.

if ($conex->filas > 0){
	$cumple = false;
	$mensaje.= "Ud. no cumple con el <b>Articulo 3º</b> de la <a style='font-weight:bold;color:#000000;' href='/web/pdf/leyes_y_reglamentos/nor_cambio_especialidad.pdf' target='_blank'>Normativa Interna para Cambios de Especialidad</a>.";

	$mensaje.= "<br><br>Para poder solicitar un cambio de especialidad debe aprobar  ".$conex->filas;
	$mensaje.= ($conex->filas > 1) ? " las siguientes asignaturas:" : " la siguiente asignatura:";

	$mensaje.= "<table border='1' style='border-collapse:collapse;background-color:#FFFFFF;' width='100%'>";
	$mensaje.= "<tr style='text-align:center;font-weight:bold;'>";
		$mensaje.= "<td>Codigo</td>";
		$mensaje.= "<td>Asignatura</td>";
	$mensaje.= "</tr>";
	foreach ($conex->result as $pendientes) {
		$mensaje.= "<tr style='text-align:center;'>";
			$mensaje.= "<td>".$pendientes[0]."</td>";
			$mensaje.= "<td>".$pendientes[1]."</td>";
		$mensaje.= "</tr>";
	}
	$mensaje.= "</table>";
}
# Fin Articulo 3

$conex->finalizarTransaccion("Fin Transaccion: ".$exp_e." - ");
?>
<td id="td_nueva_esp" colspan="3">
<?php
echo "<input type='hidden' name='cumple' id='cumple' value='".$cumple."'>";
if ($cumple) {
?>
Nueva Especialidad: 
<select name="nueva_esp" class="datospf">
	<option value="0">Seleccione una Especialidad</option>
	<?php 
		$cSQL = "SELECT c_uni_ca, carrera1, carrera FROM tblaca010 WHERE c_uni_ca <> '".$c_uni_ca."' ";
		$conex->ExecSQL($cSQL,__LINE__,true);// Busca las especialidades excepto la de origen.

		foreach ($conex->result as $carrera) {
			echo "<option value='".$carrera[0].$carrera[1]."'>".$carrera[2]."</option>\n";
		}
	?>
<?php
} else {
	echo $mensaje;
}
?>
<!-- Fin cambio -->
</td><td id="td_traslado" colspan="3" width="135"> 
Traslado de&nbsp;<select name="traslado" class="datospf">
<option value="0">Seleccione una Opci&oacute;n</option>
<option value="Tesis">Tesis</option>
<option value="Entrenamiento">Entrenamiento</option>
</select>
</td>


<td id="agregar" align="center">C&oacute;digos de Asignaturas<table align="center" id="tab_mat"><tbody></tbody></table></td>
</tr>

<tr id="materia"><td width="250" align="center"><input type="text" size="6" maxlength="6" class="datospf" name="c_asigna" onKeyUp="nomasig(this)"><div id="capa"></div></td></tr>
</table></td></tr>

</table> 
<?php

	echo "<input type=\"hidden\" name=\"exp_e\" value=\"$exp_e\" id=\"exp_e\">
	<script language=javascript>
	var exped=document.getElementById('exp_e');
	var form=document.getElementById('formulario');
	form.appendChild(exped);</script>";
?>