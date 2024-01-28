<?php
require_once("../odbc/config.php");
if($_SERVER['HTTP_REFERER']!=$raiz.'dptos/dptos.php') die ("ACCESO PROHIBIDO!");
$solicitud=$_POST['sol'];
$co_asig= array();
$nom_asig= array();
$num_caso=substr($solicitud,0,2);

//$nota_p = "0";



require_once("../odbc/odbcss_c.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT * FROM space_casos WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$exp_e = $result[0][1];
$f=implode("/",array_reverse(explode("-",$result[0][3])));
$sesion=$result[0][4];
$resol=$result[0][5];
$estado=$result[0][6];


if(substr($estado,0,1)=="2" || substr($estado,0,1)=="4"){
	$desicion="aprobar";
	
	if($num_caso==02 || $num_caso==03 || $num_caso==04 || $num_caso==05 || $num_caso==11 || $num_caso==12){
		$nota_planilla = "El estudiante debe consignar en Control de Estudios la planilla de agregado firmada por el docente.";
		//$nota_p = "1";
	}

}else { 
	$desicion="rechazar";

}



$mSQL  = "SELECT com_adm FROM space_comen WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);	
$result = $conex->result;
$filas = $conex->filas;
$com_adm=$result[0][0];
$depart=substr($com_adm,0,strpos($com_adm,"-"));
$com_adm=substr($com_adm,strpos($com_adm,"-")+1);

if($num_caso!="06" && $num_caso!="07" && $num_caso!="09" && $num_caso!="14")
{
$mSQL  = "SELECT * FROM space_materias WHERE solicitud='$solicitud'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;
$c_asigna=$result[0][1];
$c_asigna_prel=$result[0][2];
$lapso=$result[0][3];
$lapso_fin=$result[0][4];
$nota_act=$result[0][5];
$nota_fin=$result[0][6];
$exc=$result[0][7];
$traslado=$result[0][8];

$co_asig=explode('/',$c_asigna);

}

$mSQL  = "SELECT tipo_caso FROM space_num_casos WHERE numero='$num_caso'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$filas = $conex->filas;
$nomb_caso=$result[0][0];

$mSQL  = "SELECT nombres,apellidos,c_uni_ca FROM dace002 where exp_e='$exp_e'";		// Extrae los datos del alumno a partir de su cedula
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$nom_alum=$result[0][0];
$ape_alum=$result[0][1];

//______________________________________NOMBRE DEL DEPARTAMENTO Y FIRMAS DE LAS CARTAS___________________________________________________

if($depart>8)
	{
		if($depart==9)
			{
				$nomb_depart="CONSEJO DIRECTIVO";
				$cargo1_1=7;
				$cargo1_2=15;
				$cargo1_1E=8;
				$cargo1_2E=16;
				$cargo2_1=17;
				$cargo2_2=18;
				$cargo2_1E="";
				$cargo2_2E="";
			}
		elseif($depart==10)
			{
				$nomb_depart="CONSEJO UNIVERSITARIO";
				$cargo1_1=5;
				$cargo1_2=13;
				$cargo1_1E=6;
				$cargo1_2E=14;
				$cargo2_1=3;
				$cargo2_2=11;
				$cargo2_1E=4;
				$cargo2_2E=12;
			}
		elseif($depart==11)
			{
				$nomb_depart="CONSEJO ACAD&Eacute;MICO";
				$cargo1_1=17;
				$cargo1_2=18;
				$cargo1_1E="";
				$cargo1_2E="";
				$cargo2_1=81;
				$cargo2_2="";
				$cargo2_1E="";
				$cargo2_2E="";
			}
		$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo IN ('$cargo1_1','$cargo1_2','$cargo1_1E','$cargo1_2E','$cargo2_1','$cargo2_2','$cargo2_1E','$cargo2_2E') ORDER BY cargo ASC";
		$conex->ExecSQL($fSQL,__LINE__,true);
		$result = $conex->result;
		for($i=0;$i<($conex->filas);$i++)
			{
				if(($result[$i][2]==$cargo1_1 || $result[$i][2]==$cargo1_2) && $result[$i][0]!="" && !isset($firma1))		//---Carga el nombre del Vice rector si no esta vacio
					{
						$firma1=$result[$i][0];
						$cargo_d1=$result[$i][3];
					}
				elseif(($result[$i][2]==$cargo1_1E || $result[$i][2]==$cargo1_2E) && $result[$i][0]!="" && !isset($firma1))	//---Si no hay Vicerrector o Vicerrectora, Carga el nombre del encargado si no esta vacio
					{
						$firma1=$result[$i][0];
						$cargo_d1=$result[$i][3];
					}
				if(($result[$i][2]==$cargo2_1 || $result[$i][2]==$cargo2_2) && $result[$i][0]!="" && !isset($firma2))		//--Carga el nombre del Director academico o encargado
					{
						$firma2=$result[$i][0];
						$cargo_d2=$result[$i][3];
					}
				elseif(($result[$i][2]==$cargo2_1E || $result[$i][2]==$cargo2_2E) && $result[$i][0]!="" && !isset($firma1))	//---Si no hay Vicerrector o Vicerrectora, Carga el nombre del encargado si no esta vacio
					{
						$firma1=$result[$i][0];
						$cargo_d1=$result[$i][3];
					}
			}
	}
else
	{
		if($depart=="1") $depart=7;
		$cargo_dep=$depart."0";
		$cargo1=$depart."1";
		$cargo1E=$depart."2";
		$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo IN ('$cargo_dep','$cargo1','$cargo1E') ORDER BY cargo ASC";
		$conex->ExecSQL($fSQL,__LINE__,true);
		$result = $conex->result;
		$nomb_depart=$result[0][3];
		if($result[1][0]!="")
			{
				$firma1=$result[1][0];
				$cargo_d1=$result[1][3];
			}
		else
			{
				$firma1=$result[2][0];
				$cargo_d1=$result[2][3];
			}
	}

$fSQL = "SELECT nombre,profesion,cargo,cargo_d FROM autoridades WHERE cargo IN ('1','2') ORDER BY cargo ASC";
$conex->ExecSQL($fSQL,__LINE__,true);
$result = $conex->result;
if($result[0][0]!="") $jefe_dace=$result[0][0];
else $jefe_dace=$result[1][0];

$jefe_dace=ucwords(strtolower($jefe_dace));
$firma1=ucwords(strtolower($firma1));
$firma2=ucwords(strtolower($firma2));
$cargo_d1=ucwords(strtolower($cargo_d1));
$cargo_d2=ucwords(strtolower($cargo_d2));
//_______________________________________________________________________________________________


if($num_caso=="01" || $num_caso=="15" || $num_caso=="02" || $num_caso=="03" || $num_caso=="04" || $num_caso=="11" || $num_caso=="12" || $num_caso=="13")
	{
//----------------Solicitamos los nombres de Todos las materias cuyos codigos introdujo el estudiante ------------
			$mSQL  = "SELECT asignatura FROM tblaca008 where c_asigna='$co_asig[0]'";
			
			for($i=1; $i< count($co_asig); $i++)
				{
					$mSQL.="OR c_asigna='$co_asig[$i]'";
				}
			if($num_caso=='4')
				{
					$mSQL.="OR c_asigna='$c_asigna_prel'";
				}
				
			$conex->ExecSQL($mSQL,__LINE__,true);
			$result = $conex->result;
			for($i=0; $i< count($co_asig); $i++)
				{
					$nom_asig[$i]=$result[$i][0];
				}
			if($num_caso=='4')
				{
					$nom_asig[1]=$result[1][0];
				}
	}
	
//-------------solicitar Nueva especialidad------------
$mSQL  = "SELECT a.carrera1 FROM tblaca010 a,space_prueba_apt b WHERE b.solicitud='$solicitud' AND a.c_uni_ca=b.nueva_esp";
$conex->ExecSQL($mSQL,__LINE__,true);	
$result = $conex->result;
$filas = $conex->filas;
$nueva_esp=$result[0][0];

include("carta.php");

?>