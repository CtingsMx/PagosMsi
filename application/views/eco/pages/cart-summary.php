<div class="cart-summary">
    <div class="cart-summary-block">
        <?php if (in_array($this->uri->segment(1), ['datos_cliente', 'checkout'])) { ?>
            <section>
                <label>Resumen del pedido:</label>
                <div class="items-holder">
                    <?php foreach ($_SESSION['cart'] as $pid => $item) { ?>
                        <div class="row">
                            <div class="col-md-3">
                                <a class="img-holder" style="background-image: url('/src/images/shop/<?php echo $item['foto']; ?>')"></a>
                            </div>
                            <div class="col-md-9">
                                <b><?php echo $item['descripcion']; ?></b>
                                <label>Color:</label><span><?php echo $item['color']; ?></span>
                                <div class="qty-and-subtotal"><?php echo $item['cantidad']; ?> x $<?php echo number_format($item['precio'], 2); ?></div>
                                <a href="/eliminar_art/?articulo=<?php echo $pid; ?>" class="delete-item"><i class="icon-trash2"></i> Eliminar</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>

        <section>
            <label>Subtotal (<?php echo $cuenta['cantProductos']; ?> productos):</label>
            <span>$<?php echo number_format($subtotal, 2); ?></span>
        </section>

        <section>
            <label>Cupones aplicados:</label>
            <span id="cupones">$<?php echo number_format($puntos, 2); ?></span>
        </section>

        <section>
            <label>Costo de envío:</label>
            <span>$<?php echo number_format($envio, 2); ?></span>
        </section>

        <hr />

        <section>
            <label>Total (IVA incluido):</label>
            <span id="total">$<?php echo number_format($total, 2); ?></span>
        </section>
    </div>


    <?php if ($this->uri->segment(1) == 'carrito') { ?>
        <a class="summary-cta" href="<?= base_url() ?>datos_cliente"><i class="fas fa-truck"></i> CONTINUAR CON EL ENVÍO</a>
    <?php } ?>

    <?php if ($this->uri->segment(1) == 'datos_cliente') { ?>
        <button class="summary-cta" type="submit"><i class="far fa-credit-card"></i> CONTINUAR AL PAGO</button>
    <?php } ?>
</div>