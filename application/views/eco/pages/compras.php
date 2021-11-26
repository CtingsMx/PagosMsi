<?
    if($this->uri->segment(3) == 'e'){
        if(isset($_SESSION['alertaNuevoProducto']) && $_SESSION['alertaNuevoProducto'] == 1){  ?>

        <div class="style-msg successmsg">
            <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>¡Éxito!</strong>Se ha añadido el articulo al carrito de compras</div>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
        <?
        $_SESSION['alertaNuevoProducto'] = 0;       
    } else{

        }
    }?>


<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Modelos y compras</h1>
    </div>
</section>
<section id="content" style="margin-bottom: 0px;">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="postcontent nobottommargin col_last">
                <div id="shop" class="shop product-3 grid-container clearfix" style="position: relative; height: 2018.37px;">
                    <?
                        $tmpProducto = '';
                        foreach ($productos as $producto) {
                            $color = $this->m_plados->color($producto->idColor);
                            //if ($tmpProducto != $producto->modelo){ //codigo para juntar los productos con el mismo codigo ?>

                    <div class="product sf-<?= $producto->producto ?> clearfix" style="position: absolute; left: 0px; top: 0px;">
                        <div class="product-image">
                            <a href="#"><img src="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>" alt="<?= $producto->producto ?> <?= $producto->linea ?> MODELO <?= $producto->modelo ?>"></a>
                            <!--<a href="#"><img src="images/shop/dress/1-1.jpg" alt="Checked Short Dress"></a>-->
                            <!--<div class="sale-flash">50% Descuento*</div>-->
                            <div class="product-overlay">
                                <a href="<?= base_url() ?>index.php/plados/agregar_carritoP/<?= $producto->id_catProducto ?>" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Añadir al Carrito</span></a>
                                <a href="<?= base_url() ?>index.php/plados/detalle_articulo/<?= $producto->id_catProducto ?>" class="item-quick-view"><i class="icon-zoom-in2"></i><span> Más información</span></a>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title">
                                <h3><a href="#"><?= $producto->producto ?> <?= $producto->linea ?> MODELO <?= $producto->modelo ?></a></h3>
                            </div>
                            <div class="product-price"> <ins>$<?= number_format($producto->precio, '2', ',', ' ') ?></ins></div>
                        </div>
                    </div>
                    <?
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
                        </ul>

                    </div>

                    <div class="widget widget-filter-links clearfix">

                        <h4>Ordenar por:</h4>
                        <ul class="shop-sorting">
                            <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
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


