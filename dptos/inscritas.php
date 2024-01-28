<?php
require_once("../odbc/config.php");
require_once("../odbc/odbcss_c.php");

$exp_e = $_GET['e'];
$c_uni_ca = $_GET['c'];
$pensum = $_GET['p'];


?>

<TABLE align="center" border="1" cellpadding="3" cellspacing="1" width="550"
				style="border-collapse: collapse;">
		<tr>
			<td style="width: 500px;" nowrap="nowrap" bgcolor="#FFFFFF" colspan="5">
				<div class="matB">ASIGNATURAS INSCRITAS</div></td>
            </tr>
        <TR><TD>
        <table align="center" border="0" cellpadding="0" cellspacing="1" width="550">
            <tr>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">C&Oacute;DIGO</div></td>
                <td style="width: 300px;" bgcolor="#FFFFFF">

                    <div class="matB">ASIGNATURA</div></td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">U.C.</div></td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">SECCI&Oacute;N</div></td>
                <td style="text-align:center; width: 70px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">ESTATUS</div></td>

            </tr>
            
			<?php
			//print_r($datosp);
				$Cmat = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,'consulta_datos.log');
				$mSQL = "select distinct a.c_asigna,b.asignatura,c.u_creditos,";
				$mSQL.= "a.seccion,a.status ";
				$mSQL.= "from dace006 a, tblaca008 b, tblaca009 c ";
				$mSQL.= "where a.lapso='".$lapsoProceso."' and b.c_asigna=c.c_asigna and ";
				$mSQL.= "a.c_asigna=b.c_asigna and exp_e='".$exp_e."' ";
				$mSQL.= "and status  in(7,'A',2,'P','R','T') and a.c_asigna=c.c_asigna ";
				$mSQL.= "and c.pensum='".$pensum."' and c.c_uni_ca='".$c_uni_ca."'";

				$Cmat->ExecSQL($mSQL,__LINE__,true);
				$datosm = $Cmat->result;

				if($Cmat->filas == '0'){
						print "<tr>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" colspan='6'>";
						print "<div class=\"mat2\">NO TIENE ASIGNATURAS INSCRITAS.</div></td>";
						print "</tr>";
					}
				
				$mins=0;
				$ucins=0;
				$mret=0;
				$ucret=0;
				foreach ($datosm as $dm){
					
					
				
					if($dm[4]=='7'){
						$estatus='INSCRITA';
						$mins++;
						$ucins+=$dm[2];
					}elseif($dm[4]=='A') {
						$mins++;
						$ucins+=$dm[2];
						$estatus='AGREGADA';
					}elseif($dm[4]=='2') {
						$mret++;
						$ucret+=$dm[2];
						$estatus='RETIRADA';
					}elseif($dm[4]=='R') {
						$mret++;
						$ucret+=$dm[2];
						$estatus='RETIRADA';
						$estatus='RET.REGL';
					}elseif($dm[4]=='P') {
						//$mins++;
						//$ucins+=$dm[2];
						$estatus='PREINSCR';
					}elseif($dm[4]=='T') {
						//$mins++;
						//$ucins+=$dm[2];
						$estatus='RET. TEMP.';
					}

					print "<tr>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[0]</div></td>";
					print "<td bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">".utf8_encode($dm[1])."</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[2]</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[3]</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$estatus</div></td>";
					print "</tr>";
				}


				if ($mins>0){
print <<<TOT001

		<tr>
			<td nowrap="nowrap" bgcolor="#FFFFFF" class="tot" colspan="5">
				<div ><HR>
					<TABLE align="center">
						<TR>
							<TD class="tot">- Total Asignaturas Inscritas:</TD>
							<TD class="tot">$mins</TD>
						</TR>
						<TR>
							<TD class="tot">- Total Cr&eacute;ditos Inscritos:</TD>
							<TD class="tot">$ucins</TD>
						</TR>
					</TABLE>	
				
				</div>
			</td>
		</tr>


TOT001
;
}
if ($mret>0){
print <<<TOT0011

		<tr>
			<td nowrap="nowrap" bgcolor="#FFFFFF" class="tot" colspan="5">
				<div >
					<TABLE align="center">
						<TR>
							<TD class="tot">- Total Asignaturas Retiradas:</TD>
							<TD class="tot">$mret</TD>
						</TR>
						<TR>
							<TD class="tot">- Total Cr&eacute;ditos Retirados:</TD>
							<TD class="tot">$ucret</TD>
						</TR>
					</TABLE>	
				
				</div>
			</td>
		</tr>


TOT0011
;
}
?>
</table>
        </TR></TD></TABLE></td>
<tr><td>&nbsp;</td>
    </tr>

       <tr><td width="750">
        <TABLE align="center" border="1" cellpadding="3" cellspacing="1" width="550"
				style="border-collapse: collapse;">
		<tr>
			<td style="width: 500px;" nowrap="nowrap" bgcolor="#FFFFFF" colspan="5">
				<div class="matB">ASIGNATURAS EN COLA</div></td>
            </tr>
        <TR><TD>
        <table align="center" border="0" cellpadding="0" cellspacing="1" width="550">
            <tr>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">C&Oacute;DIGO</div></td>
                <td style="width: 300px;" bgcolor="#FFFFFF">

                    <div class="matB">ASIGNATURA</div></td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">U.C.</div></td>
                <td style="width: 60px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">SECCI&Oacute;N</div></td>
                <td style="text-align:center; width: 70px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">ESTATUS</div></td>

            </tr>
            
			<?php
				$Cmat = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,TRUE,'consulta_datos.log');
				$mSQL = "select a.c_asigna,b.asignatura,b.unid_credito,a.seccion,a.status ";
				$mSQL = $mSQL."from dace006 a, tblaca008 b ";
				$mSQL = $mSQL."where lapso='".$lapsoProceso."' and ";
				$mSQL = $mSQL."a.c_asigna=b.c_asigna and exp_e='".$exp_e."' and status='Y'";
				$Cmat->ExecSQL($mSQL,__LINE__,true);
				$datosm = $Cmat->result;

				if($Cmat->filas == '0'){
						print "<tr>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" colspan='6'>";
						print "<div class=\"mat2\">NO TIENE ASIGNATURAS EN COLA.</div></td>";
						print "</tr>";
					}
				
				$mcola=0;
				$uccola=0;
				foreach ($datosm as $dm){
					if($dm[4]=='Y'){
						$estatus='EN COLA';
						$mcola++;
						$uccola+=$dm[2];
					}
					print "<tr>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[0]</div></td>";
					print "<td bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">".utf8_encode($dm[1])."</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[2]</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$dm[3]</div></td>";
					print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\">";
					print "<div class=\"mat\">$estatus</div></td>";
					print "</tr>";
				}


				if ($mcola>0){
print <<<TOT001

		<tr>
			<td nowrap="nowrap" bgcolor="#FFFFFF" class="tot" colspan="5">
				<div ><HR>
					<TABLE align="center">
						<TR>
							<TD class="tot">- Total Asignaturas en Cola:</TD>
							<TD class="tot">$mcola</TD>
						</TR>
						<TR>
							<TD class="tot">- Total Cr&eacute;ditos en Cola:</TD>
							<TD class="tot">$uccola</TD>
						</TR>
					</TABLE>	
				
				</div>
			</td>
		</tr>


TOT001
;
}
            ?>
			
        </table>
        </TR></TD></TABLE>