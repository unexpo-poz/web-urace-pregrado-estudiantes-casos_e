<?php

$conex = new ODBC_Conn("$ODBC","$user","$pass",$esc_bit,$nom_bit);
$mSQL  = "select * from table where condicion="1" ";
$mSQL .= "order by 1 desc ";
$conex->ExecSQL($mSQL,__LINE__,true);

$result = $conex->result;
$filas = $conex->filas;
$modif = $conex->fmodif;

/*

Donde:

$conex - Almacena los datos de la conexion a la base de datos.
new ODBC_Conn - Funcion que conecta al origen de datos utilizando los datos respectivos.
$ODBC - Nombre del origen de datos (ODBC) a utilizar.
$user - Nombre de usuario de la base de datos a utilizar.
$pass - Contraseña del usuario de la base de datos.
$esc_bit - Valor para escribir la bitacora de transacciones ('true' escribe/'false' no escribe).
$nom_bit - Nombre del archivo donde se escribe la bitacora (ej: 'bitacora.log').
$mSQL - Variable donde se almacena la sentencia SQL a ejecutar.
ExecSQL - Funcion que ejecuta la sentencia SQL.
__LINE__,true - Parametros adicionales para escribir la bitacora.
$conex->result - contiene el resultado en una variable tipo Array, los indices corresponden a cada campo incluido en la sentencia.
$conex->filas - contiene el numero de filas que genera la consulta (en caso de select).
$conex->fmodif - contiene el numero de filas modificadas en la consulta (en caso de insert/update/delete).

*/
?>