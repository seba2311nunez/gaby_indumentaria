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
							<br>
							<a class="btn btn-outline-success btn-sm" id="btnNuevoPedido" style="margin: 10px;" >
								<i class="fas fa-plus"></i> Nuevo pedido
							</a>
							<br>
							<table id="tabPedido" class="table" style="margin: 10px;">
								<thead>
									<tr>
										<th>Id</th>
										<th></th>
										<th>Estado</th>
										<th>Fecha</th>
										<th>Cantidad de pedidos</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT p.id,p.estado,DATE_FORMAT(p.fecha,'%d-%m-%Y') AS fecha,
														MID(GROUP_CONCAT(DISTINCT a.modelo,'-',a.color),100) AS articulos,
														GROUP_CONCAT(DISTINCT pt.cliente) AS clientes,
														COALESCE(SUM(IF(pt.id IS NULL,0,1)),0) AS q
													FROM pedido p
													LEFT JOIN pedido_item pt ON p.id=pt.id_pedido 
													LEFT JOIN articulo a ON pt.id_articulo=a.id 
													GROUP BY p.id 
													ORDER BY p.fecha DESC";

										$rs = mysql_query($sql) or die(mysql_error());

										while($d = mysql_fetch_object($rs)){

											echo "<tr>
													<td>$d->id</td>
													<td>														
														<div class='dropdown'>
														    <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'></button>      
														    
														    <div class='dropdown-menu'>
														      <a class='dropdown-item btn-verPedido' data-id_pedido='$d->id'>Ver</a>
														      <div class='dropdown-divider'></div>
														      <a class='dropdown-item btn-cerrarPedido' data-id_pedido='$d->id'>Cerrar pedido</a>
														    </div>
														 </div>		
													</td>
													<td>$d->estado</td>
													<td>$d->fecha</td>
													<td style='text-align: center;'>$d->q</td>													
												</tr>";

										}

									?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 ">
					<div class="x_panel" id="divFormPedido" style="display: none;">
						<div class="tituloDiv">
							Detalle del pedido
						</div>
						<div class="row">

							<a class="btn btn-outline-warning btn-sm" id="btnNuevoPedidoItem" style="margin: 10px;" data-toggle="modal" data-target="#modalPedidoItem">
								<i class="fas fa-plus"></i> Nuevo pedido para cliente
							</a>
							<br>

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
			
			<!-- Modal -->
			<div class="modal fade" id="modalPedidoItem" role="dialog">
				<div class="modal-dialog modal-lg">
				  <div class="modal-content">
				    <div class="modal-header">
				    	<h4 >Cargando nuevo pedido</h4>
				      	<button type="button" class="close " data-dismiss="modal">&times;</button>
				      
				    </div>
				    <div class="modal-body">
				    	<input type="hidden" id="id_pedido">
						<table id="tabPedidoCliente" class="table">
							<tr>
								<th>Modelo</th>
								<td>				      			
									<select name="modelo" id="modelo"></select>			  
								</td>
							</tr>
							<tr>
								<th>Precio</th>
								<td>
									<input type="number" name="precio_may" id="precio_may" step="0.01" title="Es editable por si es necesario aplicar descuento">
								</td>
							</tr>
							<tr>
								<th>Cantidad</th>
								<td>
									<input type="number" name="cantidad" id="cantidad" step="1" value="1">
								</td>
							</tr>
							<tr>
								<th>Subtotal</th>
								<td>
									<input type="number" name="subtotal" id="subtotal" step="1" value="1" disabled>
								</td>
							</tr>
							<tr>
								<th>Cliente</th>
								<td>
									<input type="text" name="cliente" id="cliente">
								</td>
							</tr>
							<tr>
								<th>Anotacion</th>
								<td>
									<textarea class="form-control" id="observacion"></textarea>
								</td>
							</tr>
						</table>
				      	<br>				      
				    </div>
				    <div class="modal-footer">
				      <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnGuardarItem">Guardar</button>
				      <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
				    </div>
				  </div>
				</div>
			</div>
			<!-- FIN Modal -->

		</div>
		<script>
			$(function(){
				
				$('#tabPedidoCliente input').addClass('input-sm');

				//select_articulos
				$.getJSON('ajax.php',
							{ parametro: "select_articulos" },						       				
							function(data){ 
								
								for(var i=0; i<=data.length-1 ;i++){
								
									$("#modelo").append("<option value="+data[i]['id']+" data-precio_may="+data[i]['precio_venta']+">"+data[i]['modelos']+"</option>") ;	

								}	

							}//fin function data

				);//fin getjson select_articulos

				$("#tabPedidoCliente").on('change blur','#modelo',function(){
					
					$('#precio_may').val( $('#modelo option:selected').data('precio_may') );
					$('#subtotal').val( $('#cantidad').val()*$('#precio_may').val() );
				})

				$("#tabPedidoCliente").on('change blur','#cantidad',function(){
					
					$('#subtotal').val( $('#cantidad').val()*$('#precio_may').val() );
				})
				//subtotal

				$('#btnNuevoPedido').on('click',function(){

					var txt;
					var r = confirm("Seguro ?");
					if (r == true) {
					  	var datos = {
							"parametro": "nuevo_pedido"
						};

						$.ajax({

							url: 'ajax.php',
							type: 'get',
							data: datos,
							success: function(data){						
								
								if(data=="ok"){
									alert('El pedido fue creado.');
									window.location.reload();
								}
								else{
									console.log(data);
								}

							}
						})
					}// FIN confirm 

				})

				$('#btnGuardarItem').on('click',function(){

					var txt;
					var r = confirm("Seguro ?");
					if (r == true) {

						if($('#subtotal').val()!=""){

							var datos = {
								"parametro": "grabar_item_pedido",
								"id_pedido": $('#id_pedido').val(),
								"id_articulo": $('#modelo option:selected').val(),
								"cantidad": $('#cantidad').val(),
								"precio": $('#subtotal').val(),
								"cliente": $('#cliente').val(),
								"observacion": $('#observacion').val()
							};

							$.ajax({

								url: 'ajax.php',
								type: 'get',
								data: datos,
								success: function(data){						
									
									if(data=="ok"){

										alert('Agregado con exito!');
										verPedidoItems($('#id_pedido').val());

									}
									else{
										console.log(data);
									}
								}
							})

						}// FIN subtotal
				  	

					}// FIN confirm 

				})


				// btn-verPedido
				$('#tabPedido').on('click','.btn-verPedido',function(){
					var id_pedido = $(this).data('id_pedido');
					$('#id_pedido').val(id_pedido);
					verPedidoItems(id_pedido);
				})// Fin verPedido

				//btn-cerrarPedido
				$('#tabPedido').on('click','.btn-cerrarPedido',function(){

					var txt;
					var r = confirm("Confirma ?");
					if (r == true) {
					  	var datos = {
							"parametro": "cambiar_estado",
							"id_pedido": $(this).data('id_pedido')
						};

						$.ajax({

							url: 'ajax.php',
							type: 'get',
							data: datos,
							success: function(data){						
								
								if(data=="ok"){
									alert('El pedido fue cerrado.');
									window.location.reload();
								}
								else{
									console.log(data);
								}

							}
						})
					}// FIN confirm 			

				})//FIN btn-cerrarPedido

			})

			function verPedidoItems(id_pedido){

				console.log('ver pedido: '+id_pedido)

				$('#divFormPedido').css('display','none');

				$("#tabPedidoItems tbody").html(""); 
				$("#tabPedidoItems tbody").html("<i class='fas fa-spinner fa-spin fa-2x'></i>");

				$.getJSON('ajax.php',
							{ parametro: "ver_pedido", id_pedido: id_pedido },						       				
							function(data){ 
								
								$('#divFormPedido').css('display','block');

								$("#tabPedidoItems tbody").html(""); 

								if(data.length==0){

									$("#tabPedidoItems tbody").append("<tr>"																			
																			+"<td colspan=8>No se encontraron resultados</td>"			
																		+"</tr>") ;	
								}
								else{

									for(var i=0; i<=data.length-1 ;i++){
								
										$("#tabPedidoItems tbody").append("<tr>"																										+"<td>"+(i+1)+"</td>"
																			+"<td>"+data[i]['modelo']+"</td>"
																			+"<td>"+data[i]['color']+"</td>"
																			+"<td>"+data[i]['fec_pedido']+"</td>"
																			+"<td>"+data[i]['cliente']+"</td>"
																			+"<td>"+data[i]['cantidad']+"</td>"
																			+"<td>"+data[i]['precio']+"</td>"
																			+"<td>"+data[i]['pagado']+"</td>"	
																		+"</tr>") ;		
									}//FIN FOR

									$('#divFormPedido').focus();	

								}

								
							}//fin function data

				);//fin getjson
			
			}

		</script>
	</body>
</html>