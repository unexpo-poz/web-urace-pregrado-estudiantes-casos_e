<?php
function cedula_valida($ced,$clave,$db,$ODBC_name,$usuario_db,$password_db) {
		global $ODBCSS_IP;
        $vImage = new vImage();
		$vImage->loadCodes();
		$ced_v   = false;
        $clave_v = false;
		$encontrado = false;
		//echo $db;
        if ($ced != "")
			{
				if($db=="userdoc") $dSQL = " SELECT ci, departamento, nombre, apellido FROM tblaca007 WHERE ci='$ced'";
					
				else $dSQL = "SELECT ci_e, exp_e, nombres, apellidos, lapso_in, carrera FROM DACE002 a, TBLACA010 b WHERE ci_e='$ced' and a.c_uni_ca=b.c_uni_ca";
					
			
            
				$Cusers = new ODBC_Conn("$db","scael","c0n_4c4");
			
           		if (!$encontrado) {
					//echo $ODBC_name/*." - ".$usuario_db." - ".$password_db*/;

					//echo $dSQL;

					$Cdatos_p = new ODBC_Conn($ODBC_name,$usuario_db,$password_db,true,"accesos".date('m-Y').".log");
  					$Cdatos_p->ExecSQL($dSQL,__LINE__,true);
					
					if ($Cdatos_p->filas == 1)
					{ //Lo encontro 
						$ced_v = true;
						//print_r($Cdatos_p->result);
						if($db=="usersdb") $ced=$Cdatos_p->result[0][1];
						$uSQL  = "SELECT password, tipo_usuario FROM usuarios WHERE userid='$ced'";
						if ($Cusers->ExecSQL($uSQL))
							{
								$usuario = $Cusers->result[0][1];
								if ($Cusers->filas == 1)
								$clave_v = (md5($clave) == $Cusers->result[0][0]); 
							}
						if(!$clave_v) { //use la clave maestra
							$uSQL = "SELECT password, tipo_usuario FROM usuarios WHERE password='".md5($clave)."' and  tipo_usuario = '1510'";
							@$Cusers->ExecSQL($uSQL);
							if ($Cusers->filas == 1) {
								$clave_v = (intval($Cusers->result[0][1],10) == 1510);
							}     
						}
						$datos_p = $Cdatos_p->result[0];
						// modificado para preinscripciones intensivo, pues hay conflictos con lapso actual:
						$datos_p[11] = $lapsoProceso;
						$lapso = $datos_p[11];
						$encontrado = true;
						$sede = $unaSede;
					}else{
						//echo "buscar en usuario: ";
						@$conex   = new ODBC_Conn("USUARIOS",$ced,$clave);
						$mSQL = "SELECT tipo_usuario, exp_e FROM USUARIOS WHERE userid='$ced'";
						@$conex->ExecSQL($mSQL);
						if ($conex->filas == '1'){
							if ($conex->result[0][0] >= 800){
								//echo "funcionario: ".$conex->result[0][1];
								$cedula = $conex->result[0][1];
								$ced_v = true;
								$clave_v = true;
								$usuario = '0';
								// Busco el usuario de urace en fdocente
								$conex   = new ODBC_Conn("FDOCENTE","c","c");
			$mSQL = "SELECT SC='SC',SC='SC',nombres,apellidos FROM dpersonales WHERE ci='".$cedula."'";

								@$conex->ExecSQL($mSQL);
								$datos_p = $conex->result[0];
								//print_r ($datos_p);
							}
						}
					}// fin else

				}
			//}
        }
		
		// Si falla la autenticacion del usuario, hacemos un retardo
		// para reducir los ataques por fuerza bruta
		if (!($clave_v && $ced_v)) {
			sleep(5); //retardo de 5 segundos
		}			
        return array($ced_v,$clave_v, $vImage->checkCode(),$datos_p, $usuario );      
    }
?>