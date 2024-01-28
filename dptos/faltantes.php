<?php
require_once("../odbc/config.php");
require_once("../odbc/odbcss_c.php");

$exp_e = $_GET['e'];
$c_uni_ca = $_GET['c'];


$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,'consulta_datos.log');

#para no mostrar ciudadania
$CDD = "SELECT c_asigna FROM dace004 WHERE ";
$CDD.= "(status='0' OR status='3' OR status='B') AND ";
$CDD.= "exp_e='".$exp_e."' AND c_asigna='300677'";
$conex->ExecSQL($CDD);
if ($conex->filas == '1'){
	$ciud=" AND c.c_asigna<>'300676' ";
}else $ciud=' ';

#para no mostrar venezuela
$VEN = "SELECT c_asigna FROM dace004 WHERE "; 
$VEN.= "(status='0' OR status='3' OR status='B') AND ";
$VEN.= "exp_e='".$exp_e."' AND c_asigna='300676'";
$conex->ExecSQL($VEN);
if ($conex->filas == '1'){
	$venez=" AND c.c_asigna<>'300677' ";
}else $venez=' ';

$mSQL = "SELECT b.semestre,b.c_asigna, c.asignatura, u_creditos ";
$mSQL.= "FROM dace002 a, tblaca009 b, tblaca008 c ";
$mSQL.= "WHERE exp_e='".$exp_e."' AND a.pensum=b.pensum AND a.c_uni_ca=b.c_uni_ca ";
$mSQL.= "AND b.c_asigna not in ";
$mSQL.= "(SELECT c_asigna FROM dace004 WHERE exp_e='".$exp_e."' AND status in (0,3,5,'C','B')) ";
$mSQL.= "AND b.electiva='0' AND b.c_asigna=c.c_asigna ";
$mSQL.= "AND @SUBSTRING(c.asignatura,0,8)<>'ELECTIVA' ";
$mSQL.= $ciud.$venez;
$mSQL.= "ORDER BY b.semestre ";

$conex->ExecSQL($mSQL,__LINE__,true); 
$datosm = $conex->result;

print <<<DATOSM
		<table align="center" border="1" cellpadding="0" cellspacing="1" width="550" style="border-collapse:collapse;">
            <tr>
				<td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">SEMESTRE</div>
				</td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">C&Oacute;DIGO</div>
				</td>
                <td style="width: 300px;" bgcolor="#FFFFFF">
                    <div class="matB">ASIGNATURA</div>
				</td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">U.C.</div>
				</td>
            </tr>


DATOSM;

for($i=0;$i < count($datosm);$i++){
	echo "<tr class=\"mat\">";
	echo "<td>".$datosm[$i][0]."</td>"; // Semestre
	echo "<td>".$datosm[$i][1]."</td>"; // c_asigna
	echo "<td>".utf8_encode($datosm[$i][2])."</td>"; // Nombre asignatura
	echo "<td>".$datosm[$i][3]."</td>"; // Creditos
	echo "</tr>";
}

echo "</table>";

$eSQL = "SELECT b.semestre,b.c_asigna, c.asignatura, b.u_creditos, a.c_uni_ca ";
$eSQL.= "FROM dace002 a, tblaca009 b, tblaca008 c, dace004 d ";
$eSQL.= "WHERE a.exp_e='".$exp_e."' AND a.pensum=b.pensum ";
$eSQL.= "AND a.c_uni_ca=b.c_uni_ca AND b.c_asigna=c.c_asigna ";
$eSQL.= "AND a.exp_e=d.exp_e AND b.c_asigna=d.c_asigna ";
$eSQL.= "AND b.electiva='1'  AND d.status in (0,3,5,'C','B') ";

$conex->ExecSQL($eSQL,__LINE__,true);
$cursadas = $conex->filas;

switch ($c_uni_ca){
	case 2: case 4: case 6: // Mecánica, Metalúrgica, Industrial
		$necesita = 4;
		break;
	case 3: // Eléctrica
		$necesita = 6;
		break;
	case 5: // Electrónica
		$necesita = 7;
		break;

}

if($cursadas < $necesita){
	$faltantes = $necesita -  $cursadas;
	print <<<DATOSE
		<br>
		<table align="center" border="0" cellpadding="0" cellspacing="1" width="550" style="border-collapse:collapse;">
            <tr>
				<td style="width: 200px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">Adem&aacute;s este estudiante debe cursar un total de $faltantes Electivas</div>
				</td>
            </tr>
		</table>


DATOSE;

echo "<table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"1\" width=\"550\" style=\"border-collapse:collapse;\">";

	while($cursadas < $necesita){
		$cursadas++;
		echo "<tr class=\"mat\">";
		echo "<td>ELECTIVA ".$cursadas."</td>";
		echo "</tr>";
	}
}

echo "</table>";

//print_r($datose);
?>