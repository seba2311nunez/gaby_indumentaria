<?php

/* Conexion a la base de datos */
$conexion = mysql_connect("45.132.242.129", "phpmyadmin", "Seba2020");
mysql_select_db("g_indumentaria", $conexion);
if (!$conexion) {
     echo "<CENTER>
           Problemas de conexion con la base de datos...**
           </CENTER>";
     exit();
}

mysql_set_charset("utf8");
header('Content-Type: text/html; charset=utf-8');

foreach($_REQUEST as $var=>$value){
 $_GLOABLS[$var] = $value;
 $$var = mysql_real_escape_string($value);
} 


