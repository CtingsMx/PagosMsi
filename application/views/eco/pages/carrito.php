<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Carrito de compras</h1>
    </div>
</section>

<section>
    <div class="secure-100">COMPRA 100% SEGURA</div>
    <div class="container-fluid warranty-logos-holder">
        <div class="container">
            <?php $this->load->view("eco/warranty-logos"); ?>
        </div>
    </div>
</section>

<!-- Steps -->
<?php if ($carrito) {
    $this->load->view("eco/pages/cart-steps", ["step" => 1]);
} ?>

<section id="content" class="cart-resume">
    <div class="container clearfix">
        <?php if ($carrito) { ?>
            <div class="row">
                <div class="col-md-9">
                    <table class="table cart">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3>RESUMEN DE PEDIDO</h3>
                                </th>
                                <th class="cart-product-price">Precio unitario</th>
                                <th class="cart-product-subtotal">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 0;
                            $total = 0;
                            $sub = 0;
                            foreach ($carrito as $key) {
                                $subtotal = $key['cantidad'] * $key['precio'];
                                $sub = $sub + $subtotal;
                            ?>
                                <tr class="cart_item">
                                    <td width="15%" class="cart-product-thumbnail">
                                        <a style="background-image: url('<?php echo base_url() ?>src/images/shop/<?php echo $key['foto'] ?>')" />
                                    </td>
                                    <td width="55%" class="cart-product-name" style="vertical-align:top;">
                                        <label><?php echo $key['descripcion'] ?></label>
                                        <small>Color: <b><?php echo $key['color']; ?></b></small>
                                        <div class="quantity">
                                            <input type="button" value="-" class="minus" onclick="menos(<?php echo $x ?>);">
                                            <input type="text" readonly id="qty<?php echo $x ?>" name="qty" value="<?php echo $key['cantidad'] ?>" class="qty" />
                                            <input type="button" value="+" class="plus" onclick="mas(<?php echo $x ?>);">
                                        </div>
                                        <a href="<?php echo base_url() ?>eliminar_art/?articulo=<?php echo $x ?>" class="remove" title="Remove this item"><i class="icon-trash2"></i> Eliminar</a>
                                    </td>
                                    <td width="15%" class="cart-product-price">
                                        <span class="amount">$<?php echo number_format($key['precio'], '2', ',', ' ') ?></span>
                                    </td>
                                    <td width="15%" class="cart-product-subtotal">
                                        <span class="amount">$<?php echo number_format($subtotal, '2', ',', ' ') ?></span>
                                    </td>
                                </tr>
                            <?php $x++;
                            } ?>
                        </tbody>
                    </table>
                    <div class="cupon-area">
                        <label>¿TIENE UN CUPÓN DE DESCUENTO?</label>
                        <input type="text" id="txtCupon" value="" class="sm-form-control cupon" placeholder="ingresar cupón:" />
                        <a href="javascript:;" class="apply-coupon" onclick="validarCupon();">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            APLICAR CUPÓN
                        </a>
                    </div>
                    <div class="col-md-12">
                        <span class=" text-danger pull-right hidden " id="errorCupon">
                            <i class="icon icon-warning-sign "></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php $this->load->view("eco/pages/cart-summary", $cuenta); ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-xs-12 text-center" style="padding: 70px 0px">
                    <div class="alert alert-warning" role="alert">
                        El carrito está vacío.
                    </div>
                    <a class="button button-3d button-black" href="/productos">Ir a Productos</a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script>
    const validarCupon = () => {

        const cupon = $("#txtCupon").val();

        data = {
            cupon
        }

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '<?php echo base_url() ?>stripe/validaCupon',
            data,
            beforeSend: () => {
                console.log("Validando...");

            },
            success: (resp) => {
                if (resp.error) {

                    Swal.fire(
                        'Atención!',
                        resp.mensaje,
                        'warning'
                    );


                    $("#errorCupon").html(resp.mensaje);
                    $("#errorCupon").removeClass('hidden');
                    setTimeout("$('#errorCupon').addClass('hidden')", 3000);
                    return 0;
                }

                actualizaCuenta(resp.cuenta);
            },
            error: (e) => {
                console.log(e);
            }
        });
    }

    const actualizaCuenta = (cuenta) => {
        const descuento = numeral(cuenta.puntos)
        const subtotal = numeral(cuenta.subtotal);
        const envio = numeral(cuenta.envio);
        const total = numeral(cuenta.total);

        Swal.fire(
            'Codigo Canjeado!',
            'Su codigo de promocion ha sido redimido!',
            'success'
        )

        $("#cupones").html(descuento.format('$0,0.00'));
        $("#total").html(total.format('$0,0.00'));
    }
</script>

<script>
    function mas(x) {
        bloqueaBtn();
        cantidad = parseInt($("#qty" + x).val());
        cantidad = cantidad + 1;
        $("#qty" + x).val(cantidad);
        cambiarCantidad(x, cantidad).then(() => {
            location.reload();
        });
    }

    function menos(x) {
        bloqueaBtn();
        cantidad = parseInt($("#qty" + x).val());
        if (cantidad > 1) {
            cantidad = cantidad - 1;
            $("#qty" + x).val(cantidad);
            cambiarCantidad(x, cantidad).then(() => {
                location.reload();
            });
        }
    }

    function cambiarCantidad(x, cantidad) {
        return new Promise((resolve, reject) => {
            data = {
                x,
                cantidad
            }
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '<?php echo base_url() ?>editarCantidad',
                data,
            }).done(function(respuesta) {
                console.log(respuesta);
                resolve(respuesta);
            })
        });

    }

    function bloqueaBtn() {
        $("#btnContinuar").addClass('hide');
        $("#btnRecargar").removeClass('hide');
    }
</script>