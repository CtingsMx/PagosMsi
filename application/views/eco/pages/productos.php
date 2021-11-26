<?php $this->load->view("eco/pages/home-sliders"); ?>

<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Productos</h1>
    </div>
</section>

<section id="content" style="margin-bottom: 0px;">
    <div id="loading-products"></div>
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="postcontent nobottommargin col_last">
                <div id="shop" class="shop product-3 grid-container clearfix"
                    style="position: relative; height: 2018.37px;">
                    <?php
                        $tmpProducto = '';
                    foreach ($productos as $producto) {
                        $color = $this->m_plados->color($producto->idColor);
                        //if ($tmpProducto != $producto->modelo){ //codigo para juntar los productos con el mismo codigo ?>

                    <div class="product sf-<?php echo $producto->producto ?> clearfix"
                        style="position: absolute; left: 0px; top: 0px;">
                        <div class="product-image">
                            <a href="<?php echo base_url() ?>detalle_articulo/<?php echo $producto->id_catProducto ?>"
                                style="background-image: url('<?php echo base_url() ?>src/images/shop/<?php echo $producto->foto ?>')">
                                <!--img src="<?php echo base_url() ?>src/images/shop/<?php echo $producto->foto ?>" alt="<?php echo $producto->producto ?> <?php echo $producto->linea ?> MODELO <?php echo $producto->modelo ?>"-->
                            </a>
                            <!--<a href="#"><img src="images/shop/dress/1-1.jpg" alt="Checked Short Dress"></a>-->
                            <?php if ($producto->modelo=='ON4110' || $producto->modelo=='ON5610' || $producto->modelo=='ON7610' || $producto->modelo=='LX8410N' || $producto->modelo=='LX8410B' || $producto->modelo=='ON8410' || $producto->modelo=='AM9910' || $producto->modelo=='ON8420' || $producto->modelo=='PL8610' || $producto->modelo=='PL8620') { ?>
                            <div class="sale-flash">*Accesorio de regalo</div><?php 
                            } ?>
                            <div class="product-overlay">
                                <a href="<?php echo base_url() ?>plados/agregar_carritoP/<?php echo $producto->id_catProducto ?>"
                                    class="add-to-cart"><i class="icon-shopping-cart"></i><span> Añadir al
                                        Carrito</span></a>
                                <a href="<?php echo base_url() ?>detalle_articulo/<?php echo $producto->id_catProducto ?>"
                                    class="item-quick-view"><i class="icon-zoom-in2"></i><span> Más
                                        información</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title">
                                <h3><a
                                        href="<?php echo base_url() ?>detalle_articulo/<?php echo $producto->id_catProducto ?>"><?php echo $producto->producto ?>
                                        <?php echo $producto->linea ?> MODELO <?php echo $producto->modelo ?></a></h3>
                            </div>
                            <a href="<?php echo base_url() ?>detalle_articulo/<?php echo $producto->id_catProducto ?>"
                                class="product-price">
                                <!-- Yay! Estudio: Se muestra cuando hay promo activa -->
                                <?php if ($producto->precio < $producto->_precio) { ?>
                                <sup class="promo-price">$<?php echo number_format($producto->_precio, 2); ?></sup>
                                <?php } ?>
                                <ins>$<?php echo number_format($producto->precio, '2', ',', ' ') ?></ins>
                            </a>
                        </div>
                    </div>
                        <?php
                        $tmpProducto = $producto->modelo;
                    }
                    ?>
                </div>
            </div>
            <div class="sidebar nobottommargin">
                <div class="sidebar-widgets-wrap">
                    <div class="widget widget-filter-links clearfix">
                        <h4>Categoría</h4>
                        <ul class="custom-filter" data-container="#shop" data-active-class="active-filter">
                            <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
                            <li><a href="#" data-filter=".sf-TARJA">TARJAS</a><span>3</span></li>
                            <li><a href="#" data-filter=".sf-MEZCLADORAS">MEZCLADORAS</a><span>2</span></li>
                            <li><a href="#" data-filter=".sf-ACCESORIOS">ACCESORIOS</a><span>3</span></li>
                        </ul>

                    </div>

                    <div class="widget widget-filter-links clearfix">

                        <h4>Ordenar por:</h4>
                        <ul class="shop-sorting">
                            <li class="widget-filter-reset active-filter"><a href="#"
                                    data-sort-by="original-order">Clear</a></li>
                            <li><a href="#" data-sort-by="name">Nombre</a></li>
                            <li><a href="#" data-sort-by="price_lh">Precio: Más bajo a mas alto</a></li>
                            <li><a href="#" data-sort-by="price_hl">Precio: Más alto a mas bajo</a></li>
                        </ul>

                    </div>

                </div>
            </div><!-- .sidebar end -->

        </div>

    </div>

</section>


<script>
$(function() {
    console.log('Hide it');
    $('#loading-products').addClass('hide');
});
</script>
