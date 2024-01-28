<?php
require_once("../odbc/config.php");
require_once("../odbc/odbcss_c.php");

$title="CASOS ESTUDIANTILES";
$raiz="../";
$poz="Vicerrectorado Puerto Ordaz";
$version="Version 1.0";
$copy="© 2011 - UNEXPO - Vicerrectorado Puerto Ordaz. Oficina Regional de Tecnología y Servicios de Información";

//
$conect = $_GET['c'];
//$exp_e = '02-16395008';
$exp_e = $_GET['e'];
include("../encabezado.php");

print<<<TABLA

<input type="hidden" id="depart" value="$depart">
<table id="cuerpo" align="center" width="720px"><tbody>
<tr><td class="datos">Sesion: <b>$conect</b></td></tr>
</tbody></table>
TABLA;

$conex = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,'consulta_datos_'.date('d-m-Y').'.log');

$dSQL = "SELECT exp_e, apellidos||' '||apellidos2, nombres||' '||nombres2, carrera, a.c_uni_ca, pensum ";
$dSQL.= "FROM dace002 a, tblaca010 b ";
$dSQL.= "WHERE a.exp_e='".$exp_e."' AND a.c_uni_ca=b.c_uni_ca ";
$conex->ExecSQL($dSQL,__LINE__,true);
$datos_e = $conex->result;

$c_uni_ca	= $datos_e[0][4];
$pensum		= $datos_e[0][5];

//
print <<<DATOSP
		<br>
		<table align="center" width="720px" class="datos">
			<tr>
				<td><b>Expediente:</b> {$datos_e[0][0]} </td>
				<td><b>Nombres:</b> {$datos_e[0][2]}</td>
				<td><b>Apellidos:</b> {$datos_e[0][1]}</td>
			</tr>
			<tr>
				<td colspan="3"><b>Especialidad:</b> {$datos_e[0][3]}</td>
			</tr>
			<tr>
				<td colspan="3" ><br>
					<ul id="countrytabs" class="shadetabs">
						<li><a href="#" rel="#default" class="selected">R&eacute;cord Acad&eacute;mico</a></li>
						<li><a href="inscritas.php?e=$exp_e&c=$c_uni_ca&p=$pensum" rel="countrycontainer">Materias Inscritas $tLapso</a></li>
						<li><a href="faltantes.php?e=$exp_e&c=$c_uni_ca&p=$pensum" rel="countrycontainer">Materias por Cursar/Aprobar</a></li>
					</ul>
					<div id="countrydivcontainer" style="border:1px solid gray; width:700px; margin-bottom: 1em; padding: 10px"><p>
						<table align="center" border="0" cellpadding="0" cellspacing="1" width="650" style="border-collapse: collapse; border-color: black;">
							<tr>
								<td style="width: 50px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">LAPSO</div></td>
								<td style="width: 5px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">*</div></td>
								 <td style="width: 50px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">C&Oacute;DIGO</div></td>
								<td style="width: 320px;" bgcolor="#FFFFFF">
									<div class="matB">ASIGNATURA</div></td>
								<td style="width: 40px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">U.C.</div></td>
								<td style="width: 71px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">NOTA</div></td>
								<td style="text-align:center; width: 80px;" nowrap="nowrap" bgcolor="#FFFFFF">
									<div class="matB">ESTATUS</div></td>

							</tr>
						</table>
DATOSP;

						$mSQL = "SELECT distinct a.lapso,@DECODE(a.sta_indice,1,'*'),a.c_asigna,";
						$mSQL.= "b.asignatura,c.u_creditos,a.calificacion,a.status,";
						$mSQL.= "u_cred_insc,u_cred_aprob_t,c_aprob_equiv_t,u_cred_pen_t,";
						$mSQL.= "u_c_p_indic_t,ind_acad_t ";
						$mSQL.= "FROM dace004 a, tblaca008 b, tblaca009 c, dace002 d ";
						$mSQL.= "WHERE a.c_asigna=c.c_asigna AND ";
						$mSQL.= "a.c_asigna=b.c_asigna AND a.exp_e='".$exp_e."' AND d.exp_e='".$exp_e."' ";
						$conex->ExecSQL($mSQL,__LINE__,true);
						$datosm = $conex->result;

						if($conex->filas == '0'){
							print "<tr>";
							print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" colspan='6'>";
							print "<div class=\"mat2\">Ocurrio un error en durante la consulta de datos.</div></td>";
							print "</tr>";
							$tcc=0;
							$tca=0;
							$tceq=0;
							$tcap=0;
							$tcpi=0;
							$ia=0;
						}

						$mat=$conex->filas;
						$lapso='';
						
						foreach ($datosm as $dm){
							$aux=$lapso;
							
							$lapso=$dm[0];	
							if (($dm[6]!='6') xor ($dm[6]!='2') xor ($dm[6]!='R')){
								switch($dm[6])
									{
										case "0":
											$estatus=' ';
											break;
										case "1":
											$estatus='APLAZADA';
											break;
										case "I":
											$estatus='INASISTENTE';
											break;
										case "3":
											$estatus='APROB. EQUIV';
											break;
										case "B":
											$estatus='CONV. BLOQUE';
											$dm[5]="APROBADA";
											break;
										case "R":
											$estatus='RET. REGLAMENTO';
											break;
										case "6":
											$estatus='ELIMINADA';
											break;
										case "2":
											$estatus='RETIRADA';
											break;
										case "T":
											$estatus='TEMPORAL';
											break;
										case "C":
											$estatus='CONV. NUEVO PENSUM';
											$dm[5]="APROBADA";
											break;
										case "5":
											$estatus='REVALIDA';
											$dm[5]="APROBADA";
											break;
									}

								if($aux!=$lapso){
									/*print "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"600\" style=\"border-collapse: collapse;\">";
									print "<tr><td>&nbsp;</td></tr></table>";*/
									print "<BR>";
								}
								
								print "<table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"1\" width=\"650\" style=\"border-collapse: collapse; border-color: #8A8A8A;\">";
								print "<tr>";
								print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 55px;\">";
								print "<div class=\"mat\">$dm[0]</div></td>";
								print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 5px;\">";
								print "<div class=\"mat\">$dm[1]</div></td>";
								print "<td bgcolor=\"#FFFFFF\" style=\"width: 55px;\">";
								print "<div class=\"mat\">$dm[2]</div></td>";
								print "<td style=\"padding-left:5px;padding-top:1px;padding-bottom:1px;\" nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 250px;\">";
								print "<div class=\"mat2\">$dm[3]</div></td>";
								print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 40px;\">";
								print "<div class=\"mat\">$dm[4]</div></td>";
								print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 70px;\">";
								print "<div class=\"mat\">$dm[5]</div></td>";
								print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 80px;\">";
								print "<div class=\"mat\">$estatus</div></td>";
								print "</tr>";
								print "</table>";
												
								$tcc=$dm[7];
								$tca=$dm[8];
								$tceq=$dm[9];
								$tcap=$dm[10];
								$tcpi=$dm[11];
								$ia=$dm[12];
							}

						}// fin foreach

					
print <<<DATOSP
			<br>
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="550" style="border-collapse: collapse;" class="mat2"><tr><td>(*) - Asignaturas que van para c&aacute;lculo de indice acad&eacute;mico</td></tr></table>
			<br>
			<table align="center" border="1" cellpadding="3" cellspacing="0" width="400" style="border-collapse: collapse; border-color: black;" class="mat2">
			<tr>
				<td class="mat2" width="350px">
					Total Cr&eacute;ditos Cursados:
				</td>
				<td class="mat2">
					$tcc
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Aprobados:
				</td>
				<td class="mat2">
					$tca
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Equivalencias:
				</td>
				<td class="mat2">
					$tceq
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Aprobados del Pensum:
				</td>
				<td class="mat2">
					$tcap
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total de Cr&eacute;ditos para el Indice:
				</td>
				<td class="mat2">
					$tcpi
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Indice Acad&eacute;mico:
				</td>
				<td class="mat2">
					$ia
				</td>
			</tr>
			<tr>
                <td colspan="2" class="nota"><B>Nota</B>: Es posible que el total de unidades de cr&eacute;dito y el &iacute;ndice acad&eacute;mico no hayan sido actualizados
                
                </td>

          </tr>
		</table>
					
					</p></div>
				</td>
			</tr>
		</table>

		<script type="text/javascript">

var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>
DATOSP;

/*print <<<RECORD
		<table>
			<tr>
				<td>RECORD ACADEMICO</td>
				
			</tr>
		</table>
RECORD;*/
?>