<?php 
include("Conectar.inc");

switch ($parametro) {
	case 'grabar_articulo':

		$insert = "INSERT INTO articulo(modelo,color,precio_mayo)
						VALUES (UPPER('$modelo'),UPPER('$color'),'$precio')";

		mysql_query($insert) or die(mysql_error()."<br>".$insert);

		echo "ok";
		
		break;
	
	default:
		# code...
		break;
}

?>