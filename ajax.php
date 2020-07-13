<?php 
include("Conectar.inc");

switch ($parametro) {
	
	//Funciones de pedidos

	case 'nuevo_pedido':
		
		$insert = "INSERT INTO pedido(fecha,estado) VALUES (CURDATE(),'abierto') ";
		mysql_query($insert);
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
	
	case 'cambiar_estado':
		
		$update_estado = "UPDATE pedido SET estado='cerrado' WHERE id = $id_pedido ";

		mysql_query($update_estado) or die(mysql_error()."<br>".$update_estado);

		echo "ok";

		break;

	case 'select_articulos':

		$art = "SELECT id,CONCAT(modelo,' - ',color,' | $',precio_venta) AS modelos,precio_venta
					FROM articulo
					WHERE estado='alta'	";

		$result=mysql_query($art) or die(mysql_error()."<br>".$art);

		$json = array();

		while ($row = mysql_fetch_assoc($result)) {
			
		    $json[] = array(
					'id' => $row['id'],	
					'modelos' => $row['modelos'],						        		
					'precio_venta' => $row['precio_venta']
					       
		      );
		}

		echo json_encode($json);

		break;

	case 'grabar_item_pedido':
		
		$insert = "INSERT INTO pedido_item(id_pedido, id_articulo,cantidad,precio,cliente,observacion)
						VALUES ($id_pedido,$id_articulo,$cantidad,'$precio','$cliente','$observacion')";

		mysql_query($insert) or die(mysql_error()."<br> \n ".$insert);

		echo "ok";

		break;

	//Funciones de articulos

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