<?php
$titulo=strtoupper($title);
$css=$raiz."css/estilo.css";
$jscript=$raiz."js/funciones.js";
$css2=$raiz."css/ajaxtabs.css";
$jscript2=$raiz."js/ajaxtabs.js";
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
  <link rel="stylesheet" href="$css2" type="text/css" media="screen">
  <script type="text/javascript" src="$jscript"></script>
  <script type="text/javascript" src="$jscript2"></script>
 </head>
 <body onload="actualizaReloj()">
	<table border="1px" align="center" width="720px" style="border-collapse: collapse;border-color:black;">
			<tr>
				<td class="act" colspan="2">
					Universidad Nacional Experimental Polit&eacute;cnica<BR>
					"Antonio Jos&eacute; de Sucre"<BR>
					$poz<BR>
					$urace
				</td>
			</tr>
			<tr>
				<td class="enc_p" colspan="2">$titulo</td>
			</tr>
		</table>
ENC;

?>