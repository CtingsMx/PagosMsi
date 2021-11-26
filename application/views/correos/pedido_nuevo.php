<?
$total = round(number_format($pedido->cuenta, 2, '.', ''));;
?>

<!DOCTYPE html>
<html>

<head>
	<title>Usuario Registrado</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
	<div>
		<table style="max-width: 90%; padding: 10px; margin:0 auto; border-collapse: collapse;">
			<tr>
				<td style=" text-align: center; padding: 0" align="center" width="33%">
					<img style="padding-top: 50px" width="90%" src="https://plados.mx/src/images/logo.png">
				</td>
				<td style=" text-align: center; padding: 0" align="center" width="33%">

				</td>
				<td style=" text-align: center; padding: 0" align="center" width="33%">

				</td>
			</tr>
			<tr>
				<td colspan="3" style=" text-align: left; padding-top: 100px" align="left" width="33%">
					<h2><b>Hola  <?= $pedido->nombre ?></b></h2>
					<h3>Gracias por realizar tu pedido en <b> PLADOS </b>, tu numero de pedido es el <b><span style="color: red;">#<?=$pedido->id_pedido?>. </span></b> En breve recibiras la confirmación de tu pago y el seguimiento al mismo</h3>
				</td>
			</tr>
			<tr>
				<td VALIGN="TOP" height="800px" colspan="3">
					<table border=".5" class="table table-bordered">
						<tr>
							<th colspan="6" style="background-color: #d6d6d6;">Datos del cliente</th>
						</tr>
						<tr>
							<th> Cliente: </th>
							<td colspan="5"> <?= $pedido->nombre ?> </td>
						</tr>
						<tr>
							<th> Correo Electrónico: </th>
							<td colspan="2"> <?= $pedido->correo ?> </td>
							<th>Teléfono</th>
							<td colspan="2"> <?= $pedido->telefono ?> </td>							
						</tr>
						<tr>
							<th> Dirección: </th>
							<td> 
								<?= $pedido->calle ?>
								<? if (isset($pedido->numExterno)) { ?> Ext. <?= $pedido->numExterno ?><? } ?>
								<? if (isset($pedido->numInterno)) { ?> Int. <?= $pedido->numInterno ?><? } ?>
								<? if (isset($pedido->edificio)) { ?> Edificio <?= $pedido->edificio ?><? } ?>
							</td>
							<th>Colonia:</th>
							<td> <?= $pedido->colonia ?> </td>
							<th>Ciudad:</th>
							<td> <?= $pedido->ciudad ?> </td>
						</tr>
						<tr>
							<th> Estado: </th>
							<td> <?= $pedido->estado ?></td>
							<th> Código Postal: </th>
							<td> <?= $pedido->cp ?></td>
							<th> Referencias: </th>
							<td> <?= $pedido->referencias ?></td>
						</tr>
						<tr></tr>
					</table>


					<table border="0" class="table">
						<tr>
							<th colspan="2" style="background-color: #d6d6d6;">Resumen de Compra</th>
						</tr>
						<tr>
							<td>Cantidad de productos:</td>
							<td align="center" width="50%"><b><?= $pedido->cantArticulos ?></b></td>
						</tr>

						<tr>
							<td>Fecha del Pedido:</td>
							<td align="center"> <?= $this->m_plados->fecha_text($pedido->fecha_pedido) ?> </td>
						</tr>
						<tr>
							<td> ID de Pago </td>
							<td align="center"> ************<?= substr($pedido->idPago, -6) ?> </td>
						</tr>
						<tr>
							<td>Total:</td>
							<td align="center"> <h2 style="color: red;">$ <b><?= number_format($total / 100, '2', ',', ' ') ?></b></h2></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
			<td colspan="3">
	
				</td>
			</tr>
		</table>


	</div>
</body>

</html>