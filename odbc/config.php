<?php
$enProduccion		= true;
//$raizDelSitio		= 'https://podaceweb/stdinsc/';
//$urlDelSitio		= 'https://podaceweb/';
//$raizDelSitio		= 'http://www.poz.unexpo.edu.ve/web/urace/pregrado/estudiantes/stdret/';
$urlDelSitio		= 'http://www.poz.unexpo.edu.ve/web/urace/';

$lapsoProceso		= '2020-2E';
$tLapso				= ' Lapso '.$lapsoProceso;

//$laBitacora			= 'C:/AppServ/www/log/pregrado/estudiantes/retiros/retiros_cola-2009-1.log';
$inscHabilitada		= true;
$modoInscripcion	= '2'; // 1: Inscripcion, 2: Inclusion y Retiro

if ($modoInscripcion == '1'){
	$tProceso	= 'Inscripci&oacute;n de Alumnos Regulares';
}
else if ($modoInscripcion == '2'){
	$tProceso	= 'Retiros de Materias para Alumnos Regulares';
}
//----------------------------------------------------------------------------------------------------------

$ODBC_name="CENTURA-DACE";
$usuario_db="c";
$password_db="c";
$raiz="http://".$_SERVER['SERVER_NAME']."/web/urace/pregrado/estudiantes/casos_e/";
$log=$_SERVER[DOCUMENT_ROOT]."/log/pregrado/casos/casos_e_".$lapsoProceso.".log";


//-------------HABILITAR O DESHABILITAR PROCESOS CON MENSAJES-----------------------------------
//-------------EJEMPLO--------------------------------------------------------------------------
//-------------HABILITADO: $retiro="";----------------------------------------------------------
//-------------DESHABILITADO: $retiro="MENSAJE DE DESHABILITADO";-------------------------------
$retiro = "";			//---- RETIRO EXTEMPORANEO (Abrir el primer dia de clases)
$agrega = "";			//---- AGREGADO EXTEMPORANEO (Abrir la 5ta semana, despues de autorizacion de agregados)
$exon3s = "";			//---- EXONERACION DE PRE Y CO (Abrir el primer dia de clases)
$prelac = "";			//---- PRELACION DE ASIGNATURA (Abrir el primer dia de clases)
$trasla = "";			//---- TRASLADO DE LAPSO (Abierto permanentemente)
$ca_tes = "No Disponible";			//---- CARGA DE NOTA DE TESIS (Finalizando semestre)
$co_dat = "";			//---- CORRECCION DE DATOS PERSONALES (Abierto permanentemente)
$cambio = "";			//---- CAMBIO DE ESPECIALIDAD (De la 1ra a la 8va semana)
$ca_equ = "";			//---- CARGA DE MATERIAS POR EQUIVALENCIA INTERNA (Abierto permanentemente)
$reingr = "No Disponible";//---- REINGRESO (de la 8va a la 14va Semana)
$inscri = "";			//---- INSCRIPCION TARDIA (abrir la 5ta semana, despues de autorizacion de agregados)
$exc22u = "";			//---- EXCESO DE 22 UC (Abrir el primer dia de clases)
$co_not = "";			//---- CORRECCION DE NOTAS (Abierto permanentemente)
$reclam = "";			//---- RECLAMO POR OPERACIONES WEB (Abierto permanentemente)
$retire = "";			//---- RETIRO ESPECIAL (Abrir el primer dia de clases)

//----------------------------------------------------------------------------------------------------------

//Si se requiere imprimir en planilla un mensaje extra, activar esto y colocarlo
// en inc/msgExtra.php
$mensajeExtra		= false; 
//Las distintas sedes de UNEXPO - actualizar de acuerdo a la necesidad
$sedesUNEXPO = array (	'CCS' => array('BQTO','CARORA'), 
						'CCS_'  => array('DACECCS'),
						'POZ'  => array('CENTURA-DACE')
				);

//$sedeActiva = 'BQTO';
//$sedeActiva = 'CCS';
$sedeActiva = 'POZ';
$pensumPoz = '4';

$nucleos = $sedesUNEXPO[$sedeActiva];

//$vicerrectorado		= "Luis Caballero Mej&iacute;as";
//$vicerrectorado		= "Barquisimeto";
$vicerrectorado		= "Puerto Ordaz";
$nombreDependencia = 'Unidad Regional de Admisi&oacute;n y Control de Estudios';

// * * * * * OJO OJO OJO OJO * * * * * 
// Cambiar esto manualmente de acuerdo a la jornada.
// Tipo de jornada
//	0 : deshabilitado 
//	1 : solo preinscritos en las materias preinscritas.
//	2 : solo preinscritos, pero pueden cambiar las materias.
//	3 : todos preinscritos o no preinscritos
$tipoJornada = 0;
$tablaOrdenInsc = 'ORDEN_INSCRIPCION';

//Unidad Tributaria y Costo de las materias:
$unidadTributaria	= 33600;
$valorPreMateria	= 0.2*$unidadTributaria;
$valorMateria		= 89720;
// Maximo numero de depositos a presentar:
$maxDepo			= 8;

// Proteccion de las paginas contra boton derecho, no javascript y navegadores no soportados:
if ($enProduccion){
	$botonDerecho = 'oncontextmenu="return false"';
	$noJavaScript = '<noscript><meta http-equiv="REFRESH" content="0;URL=no-javascript.php"></noscript>';
	$noCache	  = "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";
	$noCache	 .= '<meta http-equiv="Expires" content="-1">';
	$noCacheFin	  = '<head><meta http-equiv="Pragma" content="no-cache"></head>';
}
else {
	$botonDerecho = '';
	$noJavaScript = '';
	$noCache	  = '';
	$noCacheFin	  = '';
}
?>