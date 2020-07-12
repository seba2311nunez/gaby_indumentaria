<?php 
include("Conectar.inc");

?>


<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		
		<!-- Jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		
		<!-- Iconos -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		
		<!-- Databatables -->
		<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
		<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		
		<!-- Estilos propios -->
		<link href="http://93.188.164.97/framework/bootstrap/css/estilo_estandar.css" rel="stylesheet">
		<script src="http://93.188.164.97/framework/bootstrap/css/estilo_estandar.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
				<!-- Brand/logo -->
				<a class="navbar-brand" href="#">
				<img src="img/gatilla.jpeg" alt="logo" style="width:40px;">
				</a>

				<!-- Links -->
				<ul class="navbar-nav">
				<li class="nav-item">
				  <a class="nav-link" href="index.php">Pedidos</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="articulos.php">Articulos</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="precios.php">Precios</a>
				</li>
				</ul>
			</nav>

			<div class="row">
				<div class="col-md-5 col-lg-5">
					<div class="x_panel">
						<div class="tituloDiv">
							Listado de pedidos
						</div>
						<div class="row">
							<hr>
							<table id="tabPedido" class="table" style="margin: 10px;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Estado</th>
										<th>Fecha</th>
										<th>Cantidad de pedidos</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT p.id,p.estado,DATE_FORMAT(p.fecha,'%d-%m-%Y') AS fecha,
														MID(GROUP_CONCAT(DISTINCT a.modelo,'-',a.color),100) AS articulos,
														GROUP_CONCAT(DISTINCT pt.cliente) AS clientes,
														COUNT(*) AS q
													FROM pedido p
													JOIN pedido_item pt ON p.id=pt.id_pedido 
													JOIN articulo a ON pt.id_articulo=a.id 
													GROUP BY p.id";

										$rs = mysql_query($sql) or die(mysql_error());

										while($d = mysql_fetch_object($rs)){

											echo "<tr>
													<td>$d->id</td>
													<td>$d->estado</td>
													<td>$d->fecha</td>
													<td style='text-align: center;'>$d->q</td>
													<td>
														<a class='btn btn-xs btn-info btn-verPedido' data-id_pedido='$d->id' >Ver</a>
													</td>
												</tr>";

										}

									?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 ">
					<div class="x_panel">
						<div class="tituloDiv">
							Detalle del pedido
						</div>
						<div class="row">
							<table class="table table-dark" id="tabPedidoItems" style="margin: 10px;">
								<thead>
									<tr>
										<th>#</th>
										<th>Modelo</th>
										<th>Color</th>
										<th>Fecha</th>
										<th>Cliente</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Pagado</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			

		</div>
		<script>
			$(function(){
				
				$('#tabPedido').on('click','.btn-verPedido',function(){

					$("#tabPedidoItems tbody").html(""); 
					$("#tabPedidoItems tbody").html("<i class='fas fa-spinner fa-spin fa-2x'></i>");

					console.log( $(this).data('id_pedido') )

					$.getJSON('ajax.php',
								{ parametro: "ver_pedido", id_pedido: $(this).data('id_pedido') },						       				
								function(data){ 
									
									$("#tabPedidoItems tbody").html(""); 

									for(var i=0; i<=data.length-1 ;i++){
									
										$("#tabPedidoItems tbody").append("<tr>"																							+"<td>"+(i+1)+"</td>"
																			+"<td>"+data[i]['modelo']+"</td>"
																			+"<td>"+data[i]['color']+"</td>"
																			+"<td>"+data[i]['fec_pedido']+"</td>"
																			+"<td>"+data[i]['cliente']+"</td>"
																			+"<td>"+data[i]['cantidad']+"</td>"
																			+"<td>"+data[i]['precio']+"</td>"
																			+"<td>"+data[i]['pagado']+"</td>"																      				
																		+"</tr>") ;		
									}	
								}//fin function data

					);//fin getjson
					
				})

			})
		</script>
	</body>
</html>