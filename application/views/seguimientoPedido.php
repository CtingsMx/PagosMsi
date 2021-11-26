<?
$sub = 0;
?>
<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Seguimiento del Pedido #<?= $folio ?></h1>
    </div>
</section>

<br /><br /><br />

<div class="page-content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-bordered">
                <tr>
                    <th colspan="6" style="background-color: #d6d6d6;">Datos del cliente</th>
                </tr>
                <tr>
                    <th> Cliente: </th>
                    <td colspan="5"><?= $pedido->nombre ?> </td>
                </tr>
                <tr>
                    <th> Correo Electrónico: </th>
                    <td colspan="5"> <?= $pedido->correo ?> </td>
                </tr>
                <tr>
                    <th> Dirección: </th>
                    <td> <?= $pedido->calle ?> #<?= $pedido->numExterno ?>
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
        </div>
    </div>
    <div class="clear"></div>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <table class="table">
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
                    <td>Subtotal:</td>
                    <td align="center">$ <b><?= number_format($pedido->subtotal, '2', ',', ' ') ?></b></td>
                </tr>
                <tr>
                    <td>Promociones y descuentos:</td>
                    <td align="center">$ <b><?= number_format($pedido->descuento, '2', ',', ' ') ?></b></td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td align="center">$ <b><?= number_format($pedido->cuenta, '2', ',', ' ') ?></b></td>
                </tr>
            </table>
        </div>
        <div class="col-md-5">
            <table class="table">
                <tr>
                    <th colspan="100" style="background-color: #d6d6d6;">Datos de Facturación</th>
                </tr>
                <?php if (isset($factura) && is_object($factura)) { ?>
                    <tr>
                        <td>Razón Social:</td>
                        <td align="right" width="50%"><b><?= $factura->nombre ?></b></td>
                    </tr>

                    <tr>
                        <td>RFC:</td>
                        <td align="right"> <?php echo $factura->rfc; ?> </td>
                    </tr>
                    <tr>
                        <td> Correo:</td>
                        <td align="right"><?php echo $factura->correo; ?></td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td align="right"><?php echo $factura->direccion; ?></td>
                    </tr>
                    <tr>
                        <td>Uso del CFDI:</td>
                        <td align="right"><?php echo $factura->uso; ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="100%">
                            <em>No require factura.</em>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>



    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-bordered">
                <tr>
                    <th colspan="3" style="background-color: #008040; color: #fff;">Acciones</th>
                </tr>
                <tr>
                    <td>Estatus:</td>
                    <td><span id="lblEstatus"><?= $pedido->etiqueta ?></span></td>
                    <td>
                        <select class="form-control" id="estatus" name="estatus">
                            <option value="<?= $pedido->estatus ?>"><?= $pedido->nombre_estatus ?></option>
                            <? foreach ($estatus as $s) {
                                if ($s->id > $pedido->estatus) { ?>
                                    <option value="<?= $s->id ?>"><?= $s->nombre_estatus ?></option>
                            <? }
                            } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>


    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h3>Detalles del pedido</h3>

            <div class="ibox">
                <div class="ibox-body">
                    <div class="row">
                        <? if ($carrito != 0) { ?>
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
                                            $sub = $sub + $subtotal;
                                        ?>
                                            <tr>
                                                <td><img class="img-rounded" src="<?= base_url() ?>src/images/shop/<?= $key->foto ?>" alt="image" width="80px" /></td>
                                                <td><?= $key->descripcion ?></td>
                                                <td><?= $key->color ?></td>
                                                <td>$ <?= number_format($key->precio, '2', ',', ' ') ?></td>
                                                <td align="center"><?= $key->cantidad ?></td>
                                                <td>$ <?= number_format($subtotal, '2', ',', ' ') ?></td>
                                            </tr>
                                        <? }
                                        $total = ($sub * 1.16);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $("#estatus").change(function() {
        estado = $("#estatus").val();
        console.log(estado);
        if (estado == 2) {
            alertify.confirm("Validar pago del pedido", "¿Está seguro de validar el pago de este pedido?",
                function() {
                    cambiarStatus(estado);
                    alertify.success('Validado');
                },
                function() {
                    alertify.error('Cancelar');
                });
        }
    });

    function cambiarStatus(estado) {
        pedido = <?= $folio ?>;
        data = {
            estado,
            pedido
        };

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?= base_url() ?>index.php/admin/cambiar_estatus',
            data,
        }).done(function(respuesta) {
            console.log(respuesta);
            $("#lblEstatus").html(respuesta.etiqueta);
        })
    }
</script>