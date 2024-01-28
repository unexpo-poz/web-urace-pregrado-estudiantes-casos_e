<?php
$cuerpo = "cuerpo$num_caso";
include("funciones.php");  

print<<<ENC
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>:: CARTA DEL DEPARTAMENTO - Solicitud $solicitud ::</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  </head>
 <body>
<html>
<head>
<title>CASO ESTUDIANTIL No. $solicitud </title>
</head> 
<table width="750" align="center" style="font-size:large"> 
<tr><td colspan="2"><table><tr><td width="250" align="center"><img src="../unexpo.jpg" width="148" height="120" ></td> 
<td align="center" valign="center" style="font-family: arial; font-size:17px; font-weight:bold">
REPUBLICA BOLIVARIANA DE VENEZUELA<br>  
UNIVERSIDAD EXPERIMENTAL POLIT&Eacute;CNICA<br>
"ANTONIO JOS&Eacute; DE SUCRE"<br>
VICE-RECTORADO PUERTO ORDAZ<br>
ENC;

echo acento($nomb_depart);

print<<<CUERPO
</td></tr></table></td></tr>
<tr><td colspan="2" style="border-top:solid; font-weight:bold"><br><br><blockquote>$resol</blockquote></td></tr>
<tr><td colspan="2" align="right"><blockquote>Ciudad Guayana, $fecha[0] de $mes de $fecha[2]</blockquote></td></tr>
<tr><td colspan="2"><blockquote>Ciudadano:<br>$jefe_dace<br><b>Unidad Regional de Admisi&oacute;n y Control de Estudios</b><br>Presente</blockquote></td></tr>
<tr><td height="300" valign="center" colspan="2"><blockquote><br><p align="justify">
CUERPO;

echo  $$cuerpo;

if($depart==9 || $depart==10 || $depart==11)			//---------------------CARTA EMITIDA POR CONSEJO ACADEMICO, DIRECTIVO O UNIVERSITARIO -----------
{
print<<<PIE
</p><br></blockquote></td></tr>
<tr><td colspan="2" align="center">Sin otro particular del que hacer referencia, le saluda<br><br><br>Atentamente,<br><br><br><br></td></tr>
<tr><td width="50%" align="center">___________________________<br>$firma1<br>$cargo_d1</td>
<td width="50%" align="center">___________________________<br>$firma2<br>$cargo_d2</td>
</tr>
<tr>
  <td>
	<br>
	<br>C.C. Archivo/Direcci&oacute;n Acad&eacute;mica
  </td>
</tr>
PIE;
}

else {
print<<<PIE
</p><br></td></tr>
<tr><td colspan="2" align="center">Sin otro particular del que hacer referencia, le saluda<br><br><br>Atentamente,<br><br><br><br>___________________________<br>$firma1<br>$cargo_d1</td>
</tr>
<tr>
  <td>
	<br><span style="style=font-family:serif; font-size:10pt; font-style:italic;">$nota_planilla</span>
	<br>C.C. Archivo
  </td>
</tr>
PIE;

} 

print<<<IMPRIMIR
<tr><td id="oculto" colspan="2" align="center">
<br><br><input type="button" value="IMPRIMIR" onclick="imprimir()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="SALIR" onclick="window.close()"></td></tr>
</table>
</html>
IMPRIMIR;

?>