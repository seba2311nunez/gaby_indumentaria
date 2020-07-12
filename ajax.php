<?php 
include("Conectar.inc");

switch ($parametro) {
	case 'grabar_articulo':

		$insert = "INSERT INTO articulo(modelo,color,precio_mayo)
						VALUES (UPPER('$modelo'),UPPER('$color'),'$precio')";

		mysql_query($insert) or die(mysql_error()."<br>".$insert);

		echo "ok";
		
		break;

	case 'ver_pedido':
			
			$sql = "SELECT pt.id,modelo,color,DATE_FORMAT(pt.fechador,'%d/%m %H:%i') AS fec_pedido,
							cliente,cantidad,precio,pagado,observacion
						FROM pedido_item pt
						JOIN articulo a ON pt.id_articulo=a.id  
						WHERE pt.id_pedido=$id_pedido
						ORDER BY cliente,pt.fechador";

			$result=mysql_query($sql) or die(mysql_error()."<br>".$sql);

			$json = array();

			while ($row = mysql_fetch_assoc($result)) {
				
			    $json[] = array(
						'id' => $row['id'],
						'modelo' => $row['modelo'],
						'color' => $row['color'],
						'fec_pedido' => $row['fec_pedido'],
						'cliente' => $row['cliente'],
						'cantidad' => $row['cantidad'],
						'precio' => $row['precio'],
						'pagado' => $row['pagado'],
						'observacion' => $row['observacion']
						       
			      );
			}

			echo json_encode($json);

			break;	
	
	default:
		# code...
		break;
}

?>