<?php
//****
session_start();

//print_r ($_POST);

$solicitud=$_POST['sol'];
$num_caso=substr($solicitud,0,2);
require_once("../odbc/odbcss_c.php");
require_once("../odbc/config.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);

$mSQL  = "SELECT exp_e FROM space_casos where solicitud='$solicitud'";		// Extrae los datos del alumno a partir de su cedula
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$exp_e=$result[0][0];

$mSQL  = "SELECT nombres,apellidos,c_uni_ca FROM dace002 WHERE exp_e='$exp_e'";		// Extrae los datos del alumno a partir de su cedula
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$nom_alum=$result[0][0];
$ape_alum=$result[0][1];
$esp=$result[0][2];

$mSQL  = "SELECT carrera1 FROM tblaca010 WHERE c_uni_ca='$esp'";		// Extrae el Nombre de la especialidad del alumno
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$esp_actual=$result[0][0];


print<<<ENC
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>CASO ESTUDIANTIL No. $solicitud </title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script language=javascript>
function imprimir(){
		fila=document.getElementById("oculto");
		tbod=fila.parentNode;
		tbod.deleteRow(tbod.rows.length-1);
		window.print();
		setTimeout("var celda=tbod.insertRow(-1).insertCell(0);celda.align='center';celda.innerHTML=\"<br><input type='button' value='IMPRIMIR' onclick='imprimir()'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='SALIR' onclick='window.close()'>\"",5000);
		}
</script >

  </head>
 <body>
<html>
<table width="750" align="center" style="font-size:large">
<tbody style="font-family: arial; font-size:14px">
<tr><td colspan="2"><table><tr><td width="200" align="center"><img src="../unexpo.jpg" width="148" height="120" ></td> 
<td align="center" valign="center" style="font-family: arial; font-size:16px; font-weight:bold">
REPUBLICA BOLIVARIANA DE VENEZUELA<br>  
UNIVERSIDAD EXPERIMENTAL POLIT&Eacute;CNICA<br>
"ANTONIO JOS&Eacute; DE SUCRE"<br>
VICE-RECTORADO PUERTO ORDAZ<br>
UNIDAD REGIONAL DE DESARROLLO Y BIENESTAR ESTUDIANTIL<br>
</td></tr></table></td></tr>
<tr><td style="border-top:solid"></td></tr>
ENC;

if($num_caso=="08") 
{
$mSQL  = "SELECT solicitud,fecha_eval,nueva_esp,raz_abs,raz_verb,raz_num,raz_mec,rel_espac,int_airelib,int_mec,int_calc,int_cientif,int_persua,int_artis,int_liter,int_music,int_servsoc,int_ofic,con_recom FROM space_prueba_apt WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;
if($filas==1)
	{
		
		$nueva_esp=$result[0][2];
		$esp=$nueva_esp;
		$fecha_eval=implode("/",array_reverse(explode("-",$result[0][1])));				// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
		$razonam=array();
		$inter=array();
		for($i=3; $i<=7; $i++)
			{
				//echo $i."-".$result[0][$i]."<br>";
				$razonam[$i-3]=$result[0][$i];
				//echo ($i-3)."-".$razonam[$i-3]."<br>";
			}
		for($i=8; $i<=17; $i++)
			{
				$inter[$i-8]=$result[0][$i];
			}
		$con_recom=$result[0][18];
		
		$eSQL  = "SELECT carrera1 FROM tblaca010 WHERE c_uni_ca='$nueva_esp'";
		$conex->ExecSQL($eSQL,__LINE__,true);
		$nueva_esp = $conex->result[0][0];
			
			session_start();
			$_SESSION['esp']=$result[0][2];
		
			
print<<<RES_RAZ
		<tr><td align="center"><br><br>INFORME DE EVALUACION APTITUDINAL<br><b>Solicitud $solicitud</b></td></tr>
		<tr><td align="left"><br><blockquote>
		<b>DATOS DE IDENTIFICACI&Oacute;N</b><br><blockquote>
		Estudiante: <b>$nom_alum $ape_alum</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Expediente: <b>$exp_e</b><br>
		Inscrito en la Especialidad: <b>$esp_actual</b><br>
		Solicita Cambio a la Especialidad: <b>$nueva_esp</b><br>
		Fecha de la evaluaci&oacute;n: <b>$fecha_eval</b></blockquote></blockquote>
		</td></tr>
		<tr><td><blockquote>
		<b>RESULTADOS</b><br>
		<blockquote><b>PRUEBAS APTITUDINALES</b></blockquote></blockquote>
		</td></tr>
		
		<tr><td align="center">
			<table width="500" id="razon" border="1">
			<thead><th>Prueba</th><th>Puntaje</th><th>Percentil</th><th>Categor&iacute;a</th></thead>
			<tbody align="center">
			<tr>
				<td align="left">Razonamiento Abstracto</td>
				<td>nico</td>
				<td>-</td>
				<td>-</td>
			</tr>
			<tr>
				<td align="left">Razonamiento Verbal</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>
			<tr><td align="left">Razonamiento Num&eacute;rico</td><td>-</td><td>-</td><td>-</td></tr>
			<tr><td align="left">Razonamiento Mec&aacute;nico</td><td>-</td><td>-</td><td>-</td></tr>
			<tr><td align="left">Relaciones Espaciales</td><td>-</td><td>-</td><td>-</td></tr>		
			</tbody>
			</table>
		</tr></td>
		<tr><td><br><blockquote><blockquote><b>Gr&aacute;fica de Resultados</b></blockquote></blockquote></td></tr><tr><td align="center">
RES_RAZ;

function red($x)
	{
		$aux= array();
		$aux= explode ('-',$x);
		echo $aux[1];
		return($aux[1]/5);
	}

//print_r ($razonam);

$_SESSION['xr0']=red($razonam[0]);
$_SESSION['xr1']=red($razonam[1]);
$_SESSION['xr2']=red($razonam[2]);
$_SESSION['xr3']=red($razonam[3]);
$_SESSION['xr4']=red($razonam[4]);

//print_r ($_SESSION);

/*$_SESSION['xr0']="5";
$_SESSION['xr1']="10";
$_SESSION['xr2']="15";
$_SESSION['xr3']="20";
$_SESSION['xr4']="25";*/

echo "<img src='../graf_prueba/graf_raz.php' width='700'>";

print<<<RES_INT
		<br><span style="color: #0000FF"><b>Perfil Ideal</b></span> - <span style="color: #FF0000"><b>Perfil Real</b></span>
		</tr></td>
		<tr><td>		
		<blockquote>
		<blockquote><b>PRUEBA DE INTERESES</b></blockquote></blockquote></td></tr>
		<tr><td align="center">
		<table width="500" id="int" border="1">
		<thead><th>Inter&eacute;s</th><th>Puntaje</th><th>Percentil</th><th>Categor&iacute;a</th></thead>
		<tbody align="center">
		<tr><td align="left">Aire Libre</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Mec&aacute;nico</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">C&aacute;lculo</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Cient&iacute;fico</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Persuasivo</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Art&iacute;stico</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Literario</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Musical</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Servicio Social</td><td>-</td><td>-</td><td>-</td></tr>
		<tr><td align="left">Oficina</td><td>-</td><td>-</td><td>-</td></tr>
		</tbody>
		</table>
		</tr></td>
		<tr><td><br><blockquote><blockquote><b>Gr&aacute;fica de Resultados</b></blockquote></blockquote></td></tr><tr><td align="center">
RES_INT;

$_SESSION['xi0']=red($inter[0]);
$_SESSION['xi1']=red($inter[1]);
$_SESSION['xi2']=red($inter[2]);
$_SESSION['xi3']=red($inter[3]);
$_SESSION['xi4']=red($inter[4]);
$_SESSION['xi5']=red($inter[5]);
$_SESSION['xi6']=red($inter[6]);
$_SESSION['xi7']=red($inter[7]);
$_SESSION['xi8']=red($inter[8]);
$_SESSION['xi9']=red($inter[9]);

echo "<img src='../graf_prueba/graf_int.php' width='700'>";


//____________________FIRMA Y CARGO DEL PSICOLOGO___________________
$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo='85'";
$conex->ExecSQL($fSQL,__LINE__,true);
$result = $conex->result;
$firma1= ucwords(strtolower($result[0][0]));
$prof=ucwords(strtolower($result[0][1]));
$cargo_d1=ucwords(strtolower($result[0][3]));
//__________________________________________________________________

///____________________________FIRMA JEFE URDBEPO___________________________
$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo IN ('81','82') ORDER BY cargo ASC";
$conex->ExecSQL($fSQL,__LINE__,true);
$result = $conex->result;
if($result[0][0]=="") $i=1;
else $i=0;
$firma2= ucwords(strtolower($result[$i][0]));
$prof2=ucwords(strtolower($result[$i][1]));
$cargo_d2=$result[$i][3];
//_________________________________________________________________________

print<<<FIRMA
		<br><span style="color: #0000FF"><b>Perfil Ideal</b></span> - <span style="color: #FF0000"><b>Perfil Real</b></span>
		</tr></td>
		<tr><td align="justify">		
		<blockquote><blockquote><b>CONCLUSIONES Y RECOMENDACIONES</blockquote></b>		
		<blockquote>$con_recom</blockquote></blockquote>
		</tr></td>
		<tr><td align="center">
		<br><br><br><br>
		__________________________________<br>
		<b>$prof $firma1<br>
		$cargo_d1</b><br>
        
		</td></tr>
        
		<!--<tr>
		<td>
			__________________________________<br>
			V�B�<br>
			<b>$prof2 $firma2<br>
			$cargo_d2</b><br>
		</td>
		</tr>-->
		<tr id="oculto"><td align="center" ><br><input type="button" value="IMPRIMIR" onclick="imprimir()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="SALIR" onclick="window.close()"></td></tr>
		</tbody>
		</table>
FIRMA;

$arreg= array();
echo "<script language=javascript>
		var tab_raz=document.getElementById('razon');
		var tab_int=document.getElementById('int'); ";
			
for($j=0; $j<5 ; $j++)
	{
		$arreg=explode('-',$razonam[$j]);
		for($i=0; $i<3; $i++)
			{
				
				echo "tab_raz.tBodies[0].rows[$j].cells[$i+1].childNodes[0].nodeValue= \"$arreg[$i]\";";
			}
	}
$arreglo= array();
for($j=0; $j<10 ; $j++)
	{
		$arreglo=explode('-',$inter[$j]);
		for($i=0; $i<3; $i++)
			{
				echo "tab_int.tBodies[0].rows[$j].cells[$i+1].childNodes[0].nodeValue= \"$arreglo[$i]\";";
			}
	}
	
echo "</script>"; 
	}
else
	{
		echo "NO SE CARGARON LOS DATOS O NO SE ENCONTRO LA SOLICITUD";
	}
}

else
{
$mSQL  = "SELECT * FROM space_inf_urdbe WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;

if($filas==1)
	{
		$fecha_inf=implode("/",array_reverse(explode("-",$result[0][1])));				// cambia de formato la fecha de YYYY-mm-dd a dd/mm/YYYY
		$plant=$result[0][2];
		$resul=$result[0][3];
		$anali=$result[0][4];
		$recom=$result[0][5];		
		
		//____________________________FIRMA JEFE URDBEPO___________________________
		$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo IN ('81','82') ORDER BY cargo ASC";
		$conex->ExecSQL($fSQL,__LINE__,true);
		$result = $conex->result;
		if($result[0][0]=="") $i=1;
		else $i=0;
		$firma1= ucwords(strtolower($result[$i][0]));
		$prof=ucwords(strtolower($result[$i][1]));
		$cargo_d1=$result[$i][3];
		//_________________________________________________________________________
		
		print<<<CUERPO
		<tr><td align="center"><br><br>INFORME<br><b>Solicitud $solicitud</b></td></tr>
		<tr><td align="left"><br><blockquote>
		<b>DATOS DE IDENTIFICACI&Oacute;N</b><br><blockquote>
		Estudiante: <b>$nom_alum $ape_alum</b><br>
		EXPEDIENTE: <b>$exp_e</b><br>
		Especialidad: <b>$esp_actual</b><br>
		Fecha: <b>$fecha_inf</b></blockquote></blockquote>
		</td></tr>
		<tr><td align="justify">		
		<blockquote><b>PLANTEAMIENTO DEL PROBLEMA</b><br>		
		<blockquote>$plant</blockquote></blockquote>
		</tr></td>
		
		<tr><td align="justify">		
		<blockquote><b>RESULTADOS DE LA INVESTIGACI&Oacute;N</b><br>		
		<blockquote>$resul</blockquote></blockquote>
		</tr></td>
		
		<tr><td align="justify">		
		<blockquote><b>AN&Aacute;LISIS ACAD&Eacute;MICO</b><br>		
		<blockquote>$anali</blockquote></blockquote>
		</tr></td>
		
		<tr><td align="justify">		
		<blockquote><b>CONCLUSIONES Y RECOMENDACIONES</b><br>		
		<blockquote>$recom</blockquote></blockquote>
		</tr></td>
		
		<tr><td align="center">
		<br><br><br><br>
		<table>
		<tr>
			<td>__________________________________<br>
				<b>Lic. Luisa Sanchez<br>
				Trabajador Social CTS:810062</b><br></td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>
				__________________________________<br>
				<b>$prof $firma1<br>
				$cargo_d1</b><br>
			</td>

		</tr>
		</table>
		
		</td></tr>
		<tr id="oculto"><td align="center" ><br><input type="button" value="IMPRIMIR" onclick="imprimir()">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="SALIR" onclick="window.close()"></td></tr>
		</tbody>
		</table>
CUERPO;
		
	}
else
	{
		echo "NO SE CARGARON LOS DATOS";
	}
}

?>

</body>
</html>