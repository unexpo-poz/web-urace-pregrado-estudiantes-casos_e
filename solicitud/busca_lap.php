<?php
$capa=$_POST['lap'];
$asig=$_POST['asig'];
$exp=$_POST['exp'];
/*$caso=$_POST['caso'];
$numero=$_POST['numero'];*/

//print_r($_POST);

//echo "it works!";

require_once("../odbc/odbcss_c.php");
require_once("../odbc/config.php");
$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,$log);
$mSQL  = "SELECT max(lapso) FROM dace006 where exp_e='$exp' and c_asigna='$asig' and status in (7,'A')";
@$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$lapso=$result[0][0];

$lapso = explode('-',$lapso);

if ($capa == 1){
	echo $lapso[0];
}
if ($capa == 2){
	echo $lapso[1];
}


/*$mSQL  = "SELECT c_uni_ca FROM tblaca009 where c_asigna='$asig' AND pensum='5'";
$conex->ExecSQL($mSQL,__LINE__,true);
$result = $conex->result;
$fila = $conex->filas;

if($fila==0)
	{
		$coincide=0;
	}
else
	{
		$j=0;
		while($j < $fila && $coincide!=1)
		{
			if($esp_alum== $result[$j][0])					// busca si existe algun codigo cuya especialidad coincida con la del alumno
				{
					$coincide=1;				
				}
			else
				{
					$coincide=2;
				}
			$j++;
		}
	}

if($coincide==1)
	{
		if($caso==1 || $caso==13 || $caso==2)
		{
		$mSQL  = "SELECT status FROM dace006 WHERE c_asigna='$asig' AND exp_e='$exp'";			// busca si la materia esta inscrita
		$conex->ExecSQL($mSQL,__LINE__,true);
		$result = $conex->result;
		$fila = $conex->filas;
		if($fila==0)
			{
				$mSQL  = "SELECT status FROM dace004 WHERE c_asigna='$asig' AND exp_e='$exp' AND status <> '1'";		// busca si la materia ya la curso
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result = $conex->result;
				$fila = $conex->filas;
				if($fila==0)
					{
						$insc=0;
						$cursar = 0;
					}
				else
					{
						$insc=1;
						$cursar = 1;
					}
			}
		
		else
			{
				$insc=1;
			}
		}
		else
		{
			$insc=1;
		}
		if($insc==1 || $caso==2 )
			{
				$mSQL  = "SELECT asignatura FROM tblaca008 where c_asigna='$asig'";
				$conex->ExecSQL($mSQL,__LINE__,true);
				$result = $conex->result;
				if($insc==1 && $caso==2 && $cursar=1) $eco="<b>RECURSAR: ".$result[0][0]." </b>";
				else $eco="<b>".$result[0][0]." </b>";
				
				if($numero=="") $numero="0";
				
				if(($caso==2 || $caso==3 || $caso==4 || $caso==11 || $caso==12) && $numero!="p")
					{
						
						$mSQL  = "SELECT seccion,c_uni_ca,tot_cup,inscritos FROM tblaca004 where c_asigna='$asig'";
						$conex->ExecSQL($mSQL,__LINE__,true);
						$result = $conex->result;
						$total = $conex->filas;
						$eco .= "<select name=\"seccion$numero\" class=\"datospf\">";
						for($i=0; $i<$total ; $i++)
							{
								$sec=$result[$i][0];
								if($result[$i][1]==1 || $result[$i][1]==$esp_alum)
									{
										$libre=$result[$i][2]-$result[$i][3];
										if($libre<1) $sec .= " (SIN CUPO)";										
										$eco .= "<option value=\"".$sec."\">".$sec."</option>";
									}
							}
						$eco .= "</select>";
					}
				echo $eco;
				
				
			}
		else
			{
				echo "Materia No Inscrita ni cursada";
			}
	}
elseif($coincide==0)
	{
		echo "No existe este Codigo para el pensum 5";
	}
else
	{
		echo "Codigo de pensum de otra Especialidad";
	}
*/
?>