<?php 

include("Conectar.inc");

?>

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
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
				<div class="col-md-12">
					
					<div class="col-md-6">
						<div class="x_panel">
							<div class="tituloDiv">
								Articulos 
							</div>
							<div class="row">
								<br>
								<a class="btn btn-success btn-sm" style="margin-left: 15px; color: white;" data-toggle="modal" data-target="#myModal">
									Nuevo articulo
								</a>
								<br>
								<table class="table table-dark" style="width: 95%; margin-top: 10px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Modelo</th>
											<th>Color</th>
										</tr>
									</thead>
									<tbody>
										<?
											$sql = "SELECT * FROM articulo";
											$rs = mysql_query($sql);

											$n=1;

											while($d = mysql_fetch_object($rs)){

												echo "<tr>
														<td>$n</td>
														<td>$d->modelo</td>
														<td>$d->color</td>
													";

												$n++;
											}

										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-sm">
			  <div class="modal-content">
			    <div class="modal-header">
			      <button type="button" class="close" data-dismiss="modal">&times;</button>
			      <h4 class="modal-title">Cargando nuevo articulo</h4>
			    </div>
			    <div class="modal-body">
			      <table>
			      	<tr>
			      		<th>Modelo</th>
			      		<td>
			      			<input type="text" name="modelo" id="modelo">
			      		</td>
			      	</tr>
			      	<tr>
			      		<th>Color</th>
			      		<td>
			      			<input type="text" name="color" id="color">
			      		</td>
			      	</tr>
			      	<tr>
			      		<th>Precio mayorista</th>
			      		<td>
			      			<input type="text" name="precio" id="precio">
			      		</td>
			      	</tr>
			      </table>

			    </div>
			    <div class="modal-footer">
			      <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnGuardar">Guardar</button>
			      <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCerrarModal">Close</button>
			    </div>
			  </div>
			</div>
			</div>


		</div>
		<script>
			$(function(){
				
				$('#btnGuardar').on('click',function(){

					var modelo = $('#modelo').val();
					var color = $('#color').val();
					var precio = $('#precio').val();

					var datos = {
						"parametro": "grabar_articulo",
						"modelo": modelo,
						"color": color,
						"precio": precio
					};

					$.ajax({

						url: 'ajax.php',
						type: 'get',
						data: datos,
						success: function(data){						
							
							if(data=="ok"){
								console.log('Grabado con exito!');
								$('#btnCerrarModal').click();
								window.location.reload();
							}

						}
					})

				})

			})
		</script>
	</body>
</html>