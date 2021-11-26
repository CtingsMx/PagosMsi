<?
$sub = 0;
$cantProductos = 0;
$total = round(number_format($pedido->cuenta, 2, '.', ''));
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
					<h2><b>  <?= $saludo?></b></h2>
					<h3>Se acaba de llevar acabo un nuevo pedido en el portal <b> PLADOS, </b>con el numero de seguimiento <b><span style="color: red;">#<?=$pedido->id_pedido?>. </span></b></h3>
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
							<td> <?= $pedido->calle ?> #<?= $pedido->numInterno ?>
								<? if (isset($pedido->numInterno)) { ?> Int. <?= $pedido->numInterno ?>
								<? } ?>
								<? if (isset($pedido->edificio)) { ?> Edificio <?= $pedido->edificio ?>
								<? } ?>
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

					<br>
					<div class="table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="background-color: #d6d6d6;">Detalle de Pedido</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>CONCEPTO</th>
                                        <th>COLOR</th>
                                        <th>PRECIO UNITARIO</th>
                                        <th>CANTIDAD</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?
                                        foreach ($carrito as $key) {
                                            $subtotal = $key->cantidad * $key->precio;
                                            $cantProductos = $cantProductos + $key->cantidad;
                                            $sub = $sub + $subtotal;
                                        ?>
                                    <tr>
                                        <td width="15%"><img class="img-rounded" src="http://plados.koberdesarrollo.com/src/img/<?= $key->foto ?>" alt="image" width="50%" /></td>
                                        <td><?= $key->descripcion ?>
                                        <td><?= $key->color ?></td>
                                        <td>$ <?= number_format($key->precio, '2', ',', ' ') ?></td>
                                        <td align="center"><?= $key->cantidad ?></td>
                                        <td>$ <?= number_format($subtotal, '2', ',', ' ') ?>

                                            <? }
                                            //$total = ($sub * 1.16);
                                                ?>
                                </tbody>


                                <tr>

                            </table>
                        </div>


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
					<br>
					<?if(isset($factura) && is_object($factura)) {?>
						<hr>
						<h3><b>SE SOLICITO FACTURA!</b></h3>
						

					<table border="0" class="table">
						<tr>
							<th colspan="4" style="background-color: #d6d6d6;">Datos de Facturación</th>
						</tr>
						<tr>
							<td>nombre:</td>
							<td align="center" width="50%"><b><?= $factura->nombre ?></b></td>
							<td>RFC:</td>
							<td align="center" width="50%"><b><?= $factura->rfc ?></b></td>
						</tr>
						<tr>
							<td>correo:</td>
							<td align="center" width="50%"><b><?= $factura->correo ?></b></td>
							<td>dirección:</td>
							<td align="center" width="50%"><b><?= $factura->direccion ?></b></td>
						</tr>
					</table>
					<?}?>
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