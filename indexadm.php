<?php
include_once('acceso/vImage.php'); 
include_once('odbc/config.php');
$user="userdoc";

$title="ACCESO A CASOS ESTUDIANTILES";
$raiz="";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.5";
$copy="© ".date('Y')." - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";

$titulo=strtoupper($title);
$css="css/estilo.css";
echo "<input type=\"hidden\" id=\"error\" value=\"NO\">";
//$jscript=$raiz."js/funciones.js";
print <<<ENC
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>:: $title :: Sistema Web URACE :: UNEXPO $poz ::</title>
  <meta name="Author" content="UNEXPO Vicerrectorado Puerto Ordaz">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="$css" type="text/css" media="screen">
  <script type="text/javascript" src="js/funciones.js"></script>
  <script type="text/javascript" src="acceso/md5.js"></script>
 </head>
 <body onload="actualizaReloj()">
	<table border="1px" align="center" width="720px" style="border-collapse: collapse;border-color:black;">
			<tr>
				<td class="act" colspan="2">
					Universidad Nacional Experimental Polit&eacute;cnica<BR>
					"Antonio Jos&eacute; de Sucre"<BR>
					$poz<BR>
					M&oacute;dulo Docentes
				</td>
			</tr>
			<tr>
				<td class="enc_p" colspan="2">$titulo</td>
			</tr>
		</table>
ENC;


//echo "Disculpe, el sistema est&aacute; en mantenimiento.<br><br>";
print <<<TABLAINT
<table id="login" width="720px" cellpadding="3" align="center">
<tbody>
<tr><td align="right" border="none"><input class="fecha" size="40" type="text" id="fecha" name="fecha" readonly="" disabled="disabled"></td></tr>
<tr><td>
<table id="table1" style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="1" width="720" class="datos">

  <tbody>
  <tr>

       <td width="720px" align="center">

	   <font style="font-size: 11px"><br>Por
favor escribe tus datos y el c&oacute;digo de seguridad, luego pulsa el bot&oacute;n "Entrar" para acceder.</font></td>
   </tr>
  <tr>
      <td width="720" align="center"  style="font-size: 12px">
      <form method="post" name="chequeo" onSubmit="return validar_ced(this)" 
            action="dptos/dptos.php" target="planillab" >
          <p class="normal">&nbsp; C&eacute;dula:&nbsp;
        <input class="datospf" name="cedula_v" size="15" tabindex="1" type="text">&nbsp; &nbsp;
		Clave:&nbsp;<input name="contra_v" size="20" tabindex="2" type="password" class="datospf">&nbsp;&nbsp;  
  &nbsp; C&oacute;digo de la derecha:&nbsp;
  <input name="vImageCodC" size="5" tabindex="3" type="text" class="datospf">&nbsp;
  <img src="acceso/img.php?size=4" height="30" style="vertical-align: middle;">
  <input value="Entrar" name="b_enviar" tabindex="3" type="submit"> 
  <input value="x" name="cedula" type="hidden"> 
  <input value="x" name="contra" type="hidden">
  <input value="" name="vImageCodP" type="hidden"> 
  <input value="$user" name="user" type="hidden">
</p>
      </form>

  </td>
    </tr>
    <tr>
      <td class ="titulo_tabla"><b>NOTAS:</b>
      <ul>
        <li>Si no posees la clave o la olvidaste, puedes solicitarla en la Unidad 
          Regional de Admisi&oacute;n y Control Estudios -URACE-
          en el siguiente horario <B>de 8:30 am a 11:00 am</B>.
Requisito indispensable: <B>C&eacute;dula de identidad ORIGINAL</B> o
<B>Carnet Estudiantil ORIGINAL</B>. No se aceptan fotocopias. </li>
       </ul>      </td>
    </tr>
	</td></tr>
  </tbody>
</table>
<table><tr><td>

TABLAINT;

include("pie.php");

?>