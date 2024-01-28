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
$nota_p = "0";
$nota_a = "0";
$nota_planilla = "";

switch ($num_caso){
	case "02": case "03": case "04": case "05": case "11": case "11": case "12":
		$nota_planilla.= "Recuerde consignar, en Control de Estudios, la planilla de agregado firmada por el Docente una vez que su caso sea aprobado.<br>";
		$nota_p = "1";
		break;
	case "10":
		$nota_planilla.= "Recuerde consignar en Control de Estudios los soportes para estudiar su caso.<br>";
		$nota_p = "1";
		break;
	case "13":
		$nota_planilla.= "Recuerde que el docente debe consignar en el Departamento correspondiente los soportes para validar su solicitud.<br>";
		$nota_p = "1";
		break;
}

switch ($num_caso){
	case "01": case "02": case "10":
		$nota_planilla.= "Usted tiene quince (15) d&iacute;as h&aacute;biles a partir de la presente fecha para consignar ante la Unidad Regional de Dise&ntilde;o Curricular los siguientes recaudos: <ul><li>R&eacute;cord Acad&eacute;mico.</li><li>Soportes que avalen su solicitud (Constancias, Informes, Reposos, etc.).</li><li>Constancia de vencimiento de sanci&oacute;n emitido por URACE (Si aplica).</li>";
		$nota_p = "1";
		$nota_a = "1";
		break;
}



/*if($num_caso == "02" || $num_caso == "03" || $num_caso==04 || $num_caso==05 || $num_caso==11 || $num_caso==12){
	$nota_planilla.= "Recuerde consignar, en Control de Estudios, la planilla de agregado firmada por el Docente una vez que su caso sea aprobado.<br>";
	$nota_p = "1";
}*/

/*if($num_caso==10){
	$nota_planilla.= "Recuerde consignar en Control de Estudios los soportes para estudiar su caso.<br>";
	$nota_p = "1";
}*/

/*if($num_caso==13){
	$nota_planilla.= "Recuerde que el docente debe consignar en el Departamento correspondiente los soportes para validar su solicitud.<br>";
	$nota_p = "1";
}*/

if($num_caso == "01" || $num_caso== "15" || $num_caso== "02" || $num_caso== "03" || $num_caso== "04" || $num_caso== "11" || $num_caso== "12" || $num_caso== "13")
	{
//----------------Solicitamos los nombres de Todos las materias cuyos codigos introdujo el estudiante ------------
			if (strlen($co_asig[0]) == 5){
				$co_asig[0] = "3".$co_asig[0];
			}

			$mSQL  = "SELECT asignatura FROM tblaca008 where c_asigna='$co_asig[0]'";
			
			for($i=1; $i< count($co_asig); $i++)
				{
					$mSQL.="OR c_asigna='$co_asig[$i]'";
				}
			if($num_caso=='4')
				{
					$mSQL.="OR c_asigna='$asig_pre'";
				}
				
			$conex->ExecSQL($mSQL,__LINE__,true);
			$result = $conex->result;
			$nom_asig=array();
			for($i=0; $i< count($co_asig); $i++)
				{
					$nom_asig[$i]=$result[$i][0];
				}
			if($num_caso=='4')
				{
					$nom_asig[1]=$result[1][0];
				}
	}

echo "<table width=\"750\" align=\"center\" cellpadding=\"10\" ><tr>
<td width=\"200\" align=\"center\"><img src=\"../unexpo.jpg\" width=\"148\" height=\"120\" ></td> 
<td align=\"center\" valign=\"center\" style=\"font-family: arial; font-size:17px; font-weight:bold\">
REPUBLICA BOLIVARIANA DE VENEZUELA<br> 
UNIVERSIDAD EXPERIMENTAL POLITECNICA<br>
\"ANTONIO JOSE DE SUCRE\"<br>
VICE-RECTORADO PUERTO ORDAZ<br>",
strtoupper($nom_depart),"</td></tr>

<tr><td colspan=\"2\" align=\"center\" style=\"font-family: arial; font-size:15px\">
<br>PLANILLA DE SOLICITUD 
<br><b>$solicitud</b><br><br>
</td></tr>
<tr><td colspan=\"2\">
<table style=\"font-family: arial; font-size:15px\">
<tr><td width=\"100\"></td><td colspan=\"2\">
Fecha de Solicitud: <b>$fecham</b><br><br>
El Bachiller: <b>$nom_alum $ape_alum</b><br>
Expediente: <b>$exp_alum</b><br><br>
Solicita: <b>$nom_caso</b>";

if($num_caso==1 || $num_caso==2 || $num_caso==3 || $num_caso==4 || $num_caso==11 || $num_caso==12 || $num_caso==13 || $num_caso==15)
{

	echo " de la(s) asignatura(s): <br><br>
	</td></tr>
	<tr><td></td>
	<td width=\"50\"></td>
	<td>";

	for($i=0; $i< count($co_asig); $i++)
		{
			$secc = (!empty($sec_asig[$i])) ? "- SECCI&Oacute;N ".$sec_asig[$i] : "";

			if($co_asig[$i]!=$asig_pre)	echo "<b>$co_asig[$i] - $nom_asig[$i] ".$secc."</b><br>";
		}
	echo "<br>
	</td></tr>";
	if($num_caso==4)
		{
			echo "<tr><td></td><td colspan=\"2\">
					La cual es prelada por: </td></tr><tr><td></td><td></td><td>
					<br><b>$asig_pre - $nom_asig[1]</b><br><br> ";
		}
	if($num_caso==12)
		{
			echo "<tr><td></td><td colspan=\"2\">
					Con lo que presenta un exceso de: <b>$exceso</b> Unidades de Cr&eacute;dito<br>";
		}
	if($num_caso==13)
		{
			echo "<tr><td></td><td colspan=\"2\">
					Cuya nota actual es: <b>$nota_act</b><br>
					Para ser corregida a: <b>$nota_fin</b><br>";
		}
	echo "</td></tr>
	<tr><td></td><td colspan=\"2\">
	En el Lapso: <b>$lapso_act</b><br></td></tr>";

}

else 
	{
		echo "</td></tr>
			<tr><td></td><td colspan=\"2\">";
		if($num_caso==5)
			{
				echo "Traslado de: <b>$traslado</b>, C&oacute;digo: <b>$codigo</b><br>
						del Lapso : <b>$lapso_act</b> al Lapso <b>$lapso_fin</b><br>";
			}
		elseif($num_caso==8)
			{
				echo "De la Especialidad: <b>Ing. $esp_act</b><br>A la especialidad: <b>Ing. $nueva_esp</b><br>";
			}
		elseif($num_caso==10)
			{
				echo "Para el Lapso: <b>$lapso_act</b><br>";
			}
		echo "</td></tr>";
	}

echo "<tr><td></td><td colspan=\"2\">
Donde el estudiante comenta: <br><blockquote><b>".utf8_decode($coment)."</b></blockquote>
</td></tr>
</table>
</td></tr>";

if($veces==2)
	{
		$solicitudes = explode("<br>",$nros);
		//print_r($solicitudes);
		echo "<tr><td colspan=\"2\" style=\"font-family: arial; font-size:13px\"><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b>NOTA IMPORTANTE:</b><blockquote>Se han generado dos (2) Solicitudes, <b>".$solicitudes[0]."</b> dirigida al Dpto. de Estudios Generales y <b>$solic2</b> al Dpto. de la Especialidad, con la misma informaci&oacute;n, excepto las materias que le corresponda a cada Departamento.</blockquote><td></tr>";
	}
	//echo $nota_a;
	if($nota_p == 1)
	{
		echo "<tr><td colspan=\"2\" style=\"font-family: arial; font-size:13px; padding-left:120px; font-style:italic;\"><br><br><br>
		<b>NOTA IMPORTANTE:</b> $nota_planilla <td></tr>";
		if ($nota_a == 0){
			echo "<tr><td colspan=\"2\" style=\"font-family: arial; font-size:13px; padding-left:120px; font-style:italic;text-align:justify;\">
			Todos los casos estudiantiles tienen quince (15) d&iacute;as h&aacute;biles a partir de la fecha de su solicitud para consignar los recaudos necesarios ante la Unidad o Departamento que corresponda.<td></tr>";		
		}
	} else if ($nota_a == 0){
		echo "<tr><td colspan=\"2\" style=\"font-family: arial; font-size:13px; padding-left:120px; font-style:italic;text-align:justify;\"><br><br><br>
		<b>NOTA IMPORTANTE:</b> Todos los casos estudiantiles tienen quince (15) d&iacute;as h&aacute;biles a partir de la fecha de su solicitud para consignar los recaudos necesarios ante la Unidad o Departamento que corresponda.<td></tr>";		
	}

echo "<tr><td id=\"oculto\" colspan=\"3\" align=\"center\">
<br><br><input type=\"button\" value=\"IMPRIMIR\" onclick=\"imprimir()\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"SALIR\" onclick=\"window.close()\"></td></tr>
</table>";

?>



