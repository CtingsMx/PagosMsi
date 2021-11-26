<?
$cantProductos = 0;

$sub = 0; //die(var_dump($carrito));
$total = round(number_format($pedido->cuenta, 2, '.', ''));

function addBizDays($start, $add)
{
    $start = strtotime($start);
    $d = min(date('N', $start), 5);
    $start -= date('N', $start) * 24 * 60 * 60;
    $w = (floor($add / 5) * 2);
    $r = $add + $w + $d;
    return date('Y-m-d', strtotime(date("Y-m-d", $start) . " +$r day"));
}
?>


<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>CARRITO DE COMPRAS</h1>
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


<div id="cart-success">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-8">
                    <h1>¡GRACIAS POR SU COMPRA!</h1>
                    <p style="margin-bottom:10px">Felicidades <b>tu compra ha sido confirmada</b>, en 2 días hábiles recibirás un nuevo correo con tu numero de guía de FEDEX.</p>
                    <b style="display:block; margin-bottom: 40px">¡Por favor recuerda revisar tu bandeja de correos no deseados!</b>
                </div>
                <div class="col-md-4"></div>
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <a class="cta-continue-shopping" href="/productos">Seguir comprando</a>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <h3>DETALLES DEL PEDIDO</h3>
                <div class="cart-success-contents">
                    <?php
                    $x = 0;
                    foreach ($pedido->items as $item) {
                        $subtotal = $item->cantidad * $item->precio;
                        $cantProductos = $cantProductos + $item->cantidad;
                        $sub = $sub + $subtotal;
                    ?>
                        <div class="row cart-success-item">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <a class="img-holder" style="background-image: url('<?= base_url() ?>src/images/shop/<?= $item->foto ?>')"></a>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <big><?= $item->descripcion ?></big>
                                        <label>Color: <span><?php echo $item->color; ?></span></label>
                                        <br />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Precio unitario:</label>
                                        <span>$<?= number_format($item->precio, '2', ',', ' ') ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Subtotal:</label>
                                        <span>$<?= number_format($subtotal, '2', ',', ' ') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? $x++;
                    } ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="cart-summary">
                            <div class="cart-summary-block">
                                <section>
                                    <label>Subtotal :</label>
                                    <span> $ <?= number_format($pedido->subtotal, '2'); ?></span>
                                </section>
                                <section>
                                    <label>Promociones :</label>
                                    <span> $ <?= number_format($pedido->descuento, '2'); ?></span>
                                </section>
                                <section>
                                    <label>Costo de envío</label>
                                    <span>$<?= number_format(0, '2'); ?></span>
                                </section>
                                <hr />
                                <section>
                                    <label>Cantidad de productos:</label>
                                    <span><?= $cantProductos; ?></span>
                                </section>
                                <section>
                                    <label>Fecha de compra:</label>
                                    <span><?= date_format(date_create($pedido->fecha_pedido), 'd M Y | H:i'); ?></span>
                                </section>
                                <section>
                                    <label>Fecha estimada de envío (2 días hábiles):</label>
                                    <span><?= date_format(date_create(addBizDays($pedido->fecha_pedido, 3)), 'd M Y'); ?></span>
                                </section>
                                <section>
                                    <label>ID de pago:</label>
                                    <span><sup>**** **** **** </sup><?= substr($pedido->idPago, -6) ?></span>
                                </section>
                                <hr>
                                <section>
                                    <label><b>Total (IVA incluido):</b></label>
                                    <span>$ <b><?= number_format($total, '2'); ?></b></span>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="cart-summary green">
                            <div class="cart-summary-block">
                                <section>
                                    <label>Nombre del comprador:</label>
                                    <span><?php echo $pedido->nombre; ?></span>
                                </section>
                                <section>
                                    <label>Correo electrónico:</label>
                                    <span><?php echo $pedido->correo; ?></span>
                                </section>
                                <section>
                                    <label>Teléfono:</label>
                                    <span><?php echo $pedido->telefono; ?></span>
                                </section>
                                <hr />
                                <section>
                                    <label>Dirección:</label>
                                    <span><?php echo $pedido->calle; ?> <?php echo ($pedido->numExterno) ? 'Ext. ' . $pedido->numExterno : ''; ?> <?php echo ($pedido->numInterno) ? 'Int. ' . $pedido->numInterno : ''; ?> C.P. <?php echo $pedido->cp; ?></span>
                                </section>
                                <section>
                                    <label>Colonia:</label>
                                    <span><?php echo $pedido->colonia; ?></span>
                                </section>
                                <section>
                                    <label>Municipio y estado:</label>
                                    <span><?php echo $pedido->ciudad; ?>, <?php echo $pedido->estado; ?></span>
                                </section>
                                <hr />
                                <section>
                                    <label><b>Modalidad de pago:</b></label>
                                    <div class="row">
                                        <div class="col-xs-5"><span><?php echo (isset($_GET["plan"]) && $_GET["plan"] >= 1) ? $_GET["plan"] . " MESES SIN INTERESES" : "PAGO"; ?></span></div>
                                        <div class="col-xs-7"><span><?php echo (isset($_GET["plan"]) && $_GET["plan"] >= 1) ? $_GET["plan"] . " MESES SIN INTERESES" : '$' . number_format(($total), 2); ?></span></div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row footer-area">
            <div class="col-lg-5 col-md-6">
                <h4>EN 2 DÍAS HÁBILES</h4>
                <p>Se le mandará su guía de envío al correo:</p>
                <div class="mail-holder"><?php echo $pedido->correo; ?></div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h5>CONTÁCTENOS</h5>
                        <p>ante cualquier duda o aclaración.</p>
                        <a href="mailto:vflores@kober.com.mx">
                            <i class="fa fa-envelope" aria-hidden="true"></i> vflores@kober.com.mx
                        </a>
                        <a href="tel:33 3587 3900">
                            <i class="fa fa-phone" aria-hidden="true"></i> 33 3587 3900
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Same height containers:
        var l = $($('.cart-summary-block')[0]).height();
        var r = $($('.cart-summary-block')[1]).height();
        var higher = Math.max(l, r);
        $('.cart-summary-block').css('height', (higher + 30) + 'px');
    });
</script>