<script language=javascript>

function imprimir(){
var ocul;
botones=document.getElementById("oculto");
botones.style.visibility='hidden';
window.print();
setTimeout("botones.style.visibility='visible'",5000);
}
</script>

<?php 
//Retiro Extemporaneo 
$cuerpo01= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo01 .= " en Consejo de Departamento Nro. <b>$sesion</b> ";}
$cuerpo01 .= " una vez analizada la justificaci&oacute;n presentada, el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Retiro Extemporaneo</b> de la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> del lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo01 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo01 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Retiro Extemporaneo 
$cuerpo15= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo15 .= " en Consejo de Departamento Nro. <b>$sesion</b> ";}
$cuerpo15 .= " una vez analizada la justificaci&oacute;n presentada, el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Retiro Especial por Conflicto con Normativa</b> de la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> del lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo15 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo15 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Agregado extemporaneo  
$cuerpo02= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo02 .= " en Consejo de Departamento Nro. <b>$sesion</b> ";}
$cuerpo02 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Agregado Extemporaneo</b> de la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> en el lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo02 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo02 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Exoneracion de tres semestres
$cuerpo03= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo03 .= " en Consejo de Departamento Nro. <b>$sesion</b> ";}
$cuerpo03 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Exoneraci&oacute;n de Pre y/o Co Requisitos</b> para cursar la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> en el lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo03 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo03 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Prelacion de la asignatura
$cuerpo04 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo4 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo04 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Prelaci&oacute;n de Asignatura</b>, para cursar la asignatura <b>$co_asig[0] - $nom_asig[0]</b> en el lapso acad&eacute;mico <b>$lapso</b>, que es prelada por la asignatura <b>$c_asigna_prel - $nom_asig[1]</b>.<br> Agradecemos su gesti&oacute;n al respecto.";
//Traslado de lapso (tesis/entrenamiento)
$cuerpo05="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo05 .= " en Consejo de Departamento Nro. <b>$sesion</b> ";}
$cuerpo05 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Traslado de Lapso</b> de <b>$traslado</b>, C&oacute;digo <b>$c_asigna</b>, del lapso acad&eacute;mico <b>$lapso</b> al <b>$lapso_fin</b>.";
if($com_adm!="") $cuerpo05 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo05 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Cambio de Especialidad
$cuerpo08= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo08 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo08 .= " una vez analizada la informacion presentada y los resultados de la prueba Aptitudinal aplicada, el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de <b>Cambio de Especialidad</b> a <b>Ing. $nueva_esp</b>.";
if($com_adm!="") $cuerpo08 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo08 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Reingreso
$cuerpo10="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo10 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo10 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud de <b>Reingreso</b> del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, para el lapso acad&eacute;mico <b>$lapso</b>."; 
if($com_adm!="") $cuerpo10 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo10 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Inscripcion Tardia
$cuerpo11= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo11 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo11 .= " una vez analizada la justificacion presentada, el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud de <b>Inscripci&oacute;n Tard&iacute;a</b> del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> del lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo11 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo11 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Exceso 22UC
$cuerpo12="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo12 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo12 .= " el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, para cursar un exceso de <b>$exc</b> unidad de credito lo cual es el agregado de la(s) asignatura(s):
<blockquote><blockquote><blockquote>".materias($co_asig,$nom_asig)."</blockquote></blockquote></blockquote> para el lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo12 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo12 .= "<br> Agradecemos su gesti&oacute;n al respecto.";
//Correccion de Nota
$cuerpo13="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por medio de la presente me dirijo a usted, para informarle que ";
if($sesion!="") {$cuerpo13 .= " en Consejo de Departamento Nro. $sesion ";}
$cuerpo13 .= " una vez analizada la informacion suministrada por el Consejo de Secci&oacute;n correspondiente, el ".ucwords(strtolower($nomb_depart))." acord&oacute; <b>$desicion</b> la solicitud del Br. <b>$nom_alum $ape_alum</b>, expediente <b>$exp_e</b>, de la <b>Correci&oacute;n de Nota</b> en la asignatura <b>$co_asig[0] - $nom_asig[0]</b> donde obtuvo <b>$nota_fin</b> en el lapso acad&eacute;mico <b>$lapso</b>.";
if($com_adm!="") $cuerpo13 .= " De esto, el Departamento añade lo siguiente. <blockquote><b>$com_adm</b></blockquote>";
$cuerpo13 .= "<br> Agradecemos su gesti&oacute;n al respecto.";

//Funcion que quita el acento de una cadena y la pasa a Mayusculas 
function acento ($cadena)
{
$pos= strpos($cadena,"&");
if($pos===false)
{
$cadenaf =$cadena;
}
else
{
$part0=substr($cadena,0,$pos);
$posi=strpos($cadena ,";");
$part1=substr($cadena,$posi+1);
$letra=substr($cadena,$pos+1,1);
$cadenaf =$part0.$letra.$part1; 
}
return (strtoupper($cadenaf));
}

function materias($co_asig,$nom_asig){
for($i=0; $i< count($co_asig); $i++)
		{
			$body .= "<b>$co_asig[$i] - $nom_asig[$i]</b><br>";
		}
return $body;
}

//MES 
$fecha=array();
$fecha=explode("/",$f);
switch($fecha[1]){
case "01":
	$mes="Enero";
	break;
case "02":
	$mes="Febrero";
	break;
case "03":
	$mes="Marzo";
	break; 
case "04":
	$mes="Abril";
	break;
case "05":
	$mes="Mayo";
	break;
case "06":
	$mes="Junio";
	break;
case "07":
	$mes="Julio";
	break;
case "08":
	$mes="Agosto";
	break;
case "09":
	$mes="Septiembre";
	break;
case "10":
	$mes="Octubre";
	break;
case "11":
	$mes="Noviembre";
	break;
case "12":
	$mes="Diciembre";
	break;
	}
?>