<?php
$busq=$_POST['por'];
$desde=$_POST['p1'];
$hasta=$_POST['p2'];
$param=$_POST['parametro'];
$tabla=$_POST['tabla'];

//echo $tabla;

require_once("../odbc/odbcss_c.php");
require_once("../odbc/config.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
//echo $tabla;
switch($busq)
{
	case "todos":
		$mSQL  = "SELECT * FROM $tabla";
		break;
	case "aprob":
		$mSQL  = "SELECT * FROM $tabla WHERE estado LIKE '2%'";
		break;
	case "rechaz":
		$mSQL  = "SELECT * FROM $tabla WHERE estado LIKE '3%'";
		break;
	case "proces":
		$mSQL  = "SELECT * FROM $tabla WHERE estado LIKE '4%'";
		break;
	case "fecha":
		$desde=implode("-",array_reverse(explode("-",$desde)));
		$hasta=implode("-",array_reverse(explode("-",$hasta)));
		$mSQL  = "SELECT * FROM $tabla WHERE f_emision BETWEEN '$desde' AND '$hasta'";
		break;
	case "lapso":
		$mSQL  = "SELECT * FROM $tabla WHERE lapso BETWEEN '$desde' AND '$hasta'";
		break;
	case "caso":
		$mSQL  = "SELECT * FROM $tabla WHERE solicitud LIKE '$param%'";
		break;
	case "depar":
		$mSQL  = "SELECT * FROM $tabla WHERE depart='$param'";
		break;
	case "solic":
		$mSQL  = "SELECT * FROM $tabla WHERE solicitud='$param'";
		break;
	case "exped":
		$mSQL  = "SELECT * FROM $tabla WHERE exp_e LIKE '%$param'";
		break;
	default:
		$mSQL  = "SELECT * FROM $tabla";
		break;
}

$mSQL .= " ORDER BY f_conclu DESC";
//echo $mSQL;
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

if($tabla=="space_archivo")
	{
		echo "<table id=\"tab_casos\" width=\"100%\" border=\"solid\" cellpadding=\"3\" align=\"center\" class=\"datos\">
		<thead class=\"enc_materias\"><tr>
		<th>Solicitud</th><th>Expediente</th><th>Fecha Emisi&oacute;n</th><th>Fecha Conclusi&oacute;n</th><th>Sesi&oacute;n</th><th>Resoluci&oacute;n</th><th>Solicitud				</th><th>Carta Departamento</th><th>Estado</th></tr></thead>
		<tbody id=\"tbod\" align=\"center\">";

		$R=0;
		$prev;
		$dif=$filas;
		for($i=0 ; $i<$filas ; $i++)
			{
				//_______________filas repetidas________________
				if($result[$i][0]==$prev) 
					{
						$R++;
						$dif--;
					}
				$prev=$result[$i][0];
				//______________________________________________				
				$cas=substr($result[$i][0],0,2);
				$est = substr($result[$i][6],0,1);
				if($cas!="06" && $cas!="07" && $cas!="09" && $cas!="14" && $est!=7) $dis="";
				else $dis="disabled";
				echo "<tr><td>".$result[$i][0]."</td><td>".$result[$i][1]."</td><td>".implode("/",array_reverse(explode("-",$result[$i][2])))."</td><td>".implode("/",array_reverse(explode("-",$result[$i][3])))."</td><td>".$result[$i][4]."</td><td>".$result[$i][5]."</td><td><form method=\"POST\" action=\"planilla_archivo.php\" target=\"pagina\" onSubmit=\"window.open('','pagina')\"><input type=\"button\" onclick=\"planilla(this)\" value=\"Ver solicitud\"><input type=\"hidden\" name=\"sol\"></form>";

				if (substr($result[$i][0],0,2) == '08'){
					echo "<form method=\"POST\" action=\"informe.php\" target=\"pagina\" onSubmit=\"\"><input type=\"hidden\" name=\"sol\" value=\"".$result[$i][0]."\"><input type=\"submit\" onclick=\"window.open('','pagina')\" value=\"Ver Informe\"></form>";
				}

				echo "</td><td><form method=\"POST\" action=\"cartadep_archivo.php\" target=\"carta\" onSubmit=\"window.open('','carta')\"><input type=\"button\" onclick=\"planilla(this)\" value=\"Ver Carta\" $dis><input type=\"hidden\" name=\"sol\"></form></td><td>".$result[$i][6]."</td></tr>";
			}

		if($filas==0)
			{
				echo "<tr><td colspan=\"17\"><br>NO HAY RESULTADOS PARA ESTA BUSQUEDA - Revise los Parametros de busqueda</td></tr>";
			}

		echo "<tr><td colspan=\"10\" align=\"right\"><b>Total de Filas Consultadas: $filas<br>Total de Solicitudes Repetidas: $R<br>Total de Solicitudes Diferentes: $dif</b></td></tr></tbody></table>";
// si se quiere un INDICE agregar lo siguiente: <td>",$i+1,"</td> a la linea 66 lo siguiente: <th></th> a la linea 11 y modificar el span 9 -> 10

	}

elseif($tabla=="space_casos")
	{
		//________________________________IMPRIME TABLA SPACE_CASOS________________________________
		print<<<ENC_CASOS
		<blockquote><p style="font-size:16px; font-weight:bold ">SPACE_CASOS</p></blockquote>
		<table id="space_casos" width="100%" border="solid" cellpadding="3" align="center" class="datos">
		<thead class="enc_materias"><tr>
		<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>SOLICITUD</th><th>EXP_E</th><th>F_EMISION</th><th>F_CONCLU</th><th>SESION</th><th>RESOLUCION</th><th>ESTADO</th><th>DEPART</th>
		</tr></thead><tbody id="tbod_casos" align="center">

ENC_CASOS;

		$solic=array();

		for($i=0; $i<$filas ; $i++)
			{
				$td=$result[$i];
				$solic[$i]=$td[0];
				print<<<BODY_CASOS
				<tr><td><input id="sel$i" type="checkbox"></td><td><input class="datos" type="text" value="$td[0]" readonly="" size="11" maxlength="10" align="center" style="border-width:0px"></td><td>$td[1]</td><td>$td[2]</td><td>$td[3]</td><td>$td[4]</td><td>$td[5]</td><td>$td[6]</td><td>$td[7]</td></tr>
BODY_CASOS;
			}
	
		print<<<PIE_CASOS
		<tr><td colspan="30" align="right"><b>Total de Filas Consultadas: $filas</b></td></tr></tbody></table>
PIE_CASOS;
		//________________________________CARGA TODAS LAS SOLICITUDES CONSULTADAS EN SPACE_CASOS__________________________


		for($i=0; $i<count($solic) ; $i++)
			{
				$consulta.="'".$solic[$i]."'";
				if($i!=(count($solic)-1)) $consulta.=",";
			}

		if($busq!="todos") $SQL="SELECT * FROM space_comen WHERE solicitud IN (".$consulta.")";
		else $SQL="SELECT * FROM space_comen";
		@$conex->ExecSQL($SQL,__LINE__,true);

//________________________________IMPRIME TABLA SPACE_COMEN________________________________
		print<<<ENC_COMEN
<blockquote><p style="font-size:16px; font-weight:bold ">SPACE_COMEN</p></blockquote>
<table id="space_comen" width="100%" border="solid" cellpadding="3" align="center" class="datos">
<thead class="enc_materias"><tr>
<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>SOLICITUD</th><th>COM_ALUM</th><th>COM_DEPART</th>
</tr></thead><tbody id="tbod_comen" align="center">

ENC_COMEN;

		for($i=0; $i<$conex->filas ; $i++)
			{
				$td=$conex->result[$i];
				print<<<BODY_COMEN
				<tr><td><input id="sel$i" type="checkbox"></td><td><input class="datos" type="text" value="$td[0]" readonly="" size="11" maxlength="10" align="center" style="border-width:0px"></td><td>$td[1]</td><td>$td[2]</td></tr>
BODY_COMEN;
			}
		print<<<PIE_COMEN
		<tr><td colspan="30" align="right"><b>Total de Filas Consultadas: $conex->filas</b></td></tr></tbody></table>
PIE_COMEN;

		//________________________________IMPRIME TABLA SPACE_MATERIAS________________________________

		if($busq!="todos") $SQL="SELECT * FROM space_materias WHERE solicitud IN (".$consulta.")";
		else $SQL="SELECT * FROM space_materias";
		@$conex->ExecSQL($SQL,__LINE__,true);

		print<<<ENC_MATERIAS
		<blockquote><p style="font-size:16px; font-weight:bold ">SPACE_MATERIAS</p></blockquote>
		<table id="space_materias" width="100%" border="solid" cellpadding="3" align="center" class="datos">
		<thead class="enc_materias"><tr>
		<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>SOLICITUD</th><th>C_ASIGNA</th><th>C_ASIGNA_PREL</th><th>LAPSO</th><th>LAPSO_FINAL</th><th>NOTA_ACT</th><th>NOTA_FINAL</th><th>CREDITO_EXC</th><th>TRASLADO</th><th>SECCION</th>
		</tr></thead><tbody id="tbod_materias" align="center">

ENC_MATERIAS;

		$solic=array();
		for($i=0; $i<$conex->filas ; $i++)
			{
				$td=$conex->result[$i];
				$solic[$i]=$td[0];
				print<<<BODY_MATERIAS
				<tr><td><input id="sel$i" type="checkbox"></td><td><input class="datos" type="text" value="$td[0]" readonly="" size="11" maxlength="10" align="center" style="border-width:0px"></td><td>$td[1]</td><td>$td[2]</td><td>$td[3]</td><td>$td[4]</td><td>$td[5]</td><td>$td[6]</td><td>$td[7]</td><td>$td[8]</td><td>$td[9]</td></tr>
BODY_MATERIAS;
			}
		print<<<PIE_MATERIAS
		<tr><td colspan="30" align="right"><b>Total de Filas Consultadas: $conex->filas</b></td></tr></tbody></table>
PIE_MATERIAS;

		//________________________________IMPRIME TABLA SPACE_INF_URDBE________________________________

		if($busq!="todos") $SQL="SELECT * FROM space_inf_urdbe WHERE solicitud IN (".$consulta.")";
		else $SQL="SELECT * FROM space_inf_urdbe";
		@$conex->ExecSQL($SQL,__LINE__,true);

		print<<<ENC_INF_URDBE
		<blockquote><p style="font-size:16px; font-weight:bold ">SPACE_INF_URDBE</p></blockquote>
		<table id="space_inf_urdbe" width="100%" border="solid" cellpadding="3" align="center" class="datos">
		<thead class="enc_materias"><tr>
		<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>SOLICITUD</th><th>FECHA</th><th>PLANT_PROB</th><th>RESULT_INVEST</th><th>AN_ACAD</th><th>		CONC_RECOM</th></tr></thead><tbody id="tbod_inf_urdbe" align="center">

ENC_INF_URDBE;

		for($i=0; $i<$conex->filas ; $i++)
			{
				$td=$conex->result[$i];
				print<<<BODY_INF_URDBE
				<tr><td><input id="sel$i" type="checkbox"></td><td><input class="datos" type="text" value="$td[0]" readonly="" size="11" maxlength="10" align="center" style="border-width:0px"></td><td>$td[1]</td><td>$td[2]</td><td>$td[3]</td><td>$td[4]</td><td>$td[5]</td></tr>
BODY_INF_URDBE;
			}
		print<<<PIE_INF_URDBE
		<tr><td colspan="30" align="right"><b>Total de Filas Consultadas: $conex->filas</b></td></tr></tbody></table>
PIE_INF_URDBE;

		//________________________________IMPRIME TABLA SPACE_PRUEBA_APT________________________________

		if($busq!="todos") $SQL="SELECT * FROM space_prueba_apt WHERE solicitud IN (".$consulta.")";
		else $SQL="SELECT * FROM space_prueba_apt";
		@$conex->ExecSQL($SQL,__LINE__,true);

		print<<<ENC_PRUEBA_APT
		<blockquote><p style="font-size:16px; font-weight:bold ">SPACE_PRUEBA_APT</p></blockquote>
		<table id="space_prueba_apt" width="100%" border="solid" cellpadding="3" align="center" class="datos">
		<thead class="enc_materias"><tr>
		<th><input id="todas" type="checkbox" onclick="selec(this)"></th><th>SOLICITUD</th><th>FECHA_EVAL</th><th>NUEVA_ESP</th><th>RAZ_ABS</th><th>RAZ_VERB</th><th>RAZ_NUM</th><th>RAZ_MEC</th><th>REL_ESPAC</th><th>INT_AIRELIB</th><th>INT_MEC</th><th>INT_CALC</th><th>INT_CIENTIF</th><th>INT_PERSUA</th><th>INT_ARTIS</th><th>INT_LITER</th><th>INT_MUSIC</th><th>INT_SERVSOC</th><th>INT_OFIC</th><th>CONC_RECOM</th><th>FECHA_SOL</th></tr></thead><tbody id="tbod_prueba_apt" align="center">

ENC_PRUEBA_APT;

		for($i=0; $i<$conex->filas ; $i++)
			{
				$td=$conex->result[$i];
				print<<<BODY_PRUEBA_APT
				<tr><td><input id="sel$i" type="checkbox"></td><td><input class="datos" type="text" value="$td[0]" readonly="" size="11" maxlength="10" align="center" style="border-width:0px"></td><td>$td[1]</td><td>$td[2]</td><td>$td[3]</td><td>$td[4]</td><td>$td[5]</td><td>$td[6]</td><td>$td[7]</td><td>$td[8]</td><td>$td[9]</td><td>$td[10]</td><td>$td[11]</td><td>$td[12]</td><td>$td[13]</td><td>$td[14]</td><td>$td[15]</td><td>$td[16]</td><td>$td[17]</td><td>$td[18]</td><td>$td[19]</td></tr>
BODY_PRUEBA_APT;
			}
		print<<<PIE_PRUEBA_APT
		<tr><td colspan="30" align="right"><b>Total de Filas Consultadas: $conex->filas</b></td></tr></tbody></table>
PIE_PRUEBA_APT;

}

?>