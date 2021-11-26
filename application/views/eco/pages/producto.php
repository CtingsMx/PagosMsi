<?
    $color = $this->m_plados->color($producto->idColor);
    $carrusel = sizeof($galeria);
    $titulo = $producto->titulo;
    if($producto->titulo == ''){
        $titulo =  $producto->producto .' '. $producto->linea .' MODELO '. $producto->modelo;
    }
?>

<section id="page-title">
    <div class="container clearfix" align="center">
        <h1><?= $titulo ?></h1>
    </div>
</section>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="single-product">

                <div class="product">

                    <div class="col_two_fifth">
                        <!-- Product Single - Gallery
                    ============================================= -->
                        <div class="product-image">
                            <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                <div class="flexslider">
                                    <div class="slider-wrap" data-lightbox="gallery">
                                        <div class="slide" data-thumb="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>"><a href="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>" title="" data-lightbox="gallery-item"><img src="<?= base_url() ?>src/images/shop/<?= $producto->foto ?>" alt=""></a></div>
                                        <?foreach($galeria as $g)
                                        {
                                            if($g->activa == 1){
                                                ?>
                                        <div class="slide" data-thumb="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>"><a href="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>" title="" data-lightbox="gallery-item"><img src="<?= base_url() ?>src/images/shop/productos/<?= $g->ruta ?>" alt=""></a></div>
                                        <?}
                                    }?>

                                    </div>
                                </div>
                            </div>
                            <!--<div class="sale-flash">Sale!</div>-->
                        </div><!-- Product Single - Gallery End -->
                    </div>

                    <div class="col_two_fifth product-desc">

                        <!-- Product Single - Price
                    ============================================= -->
                        <div class="product-price">
                            <!-- Yay! Estudio: Se muestra cuando hay promo activa -->
                            <?php if ($producto->precio < $producto->_precio){ ?>
                                <sup class="promo-price">$<?php echo number_format($producto->_precio,2); ?></sup>
                            <?php } ?>
                            <ins>$<?= number_format($producto->precio, '2', ',', ' ') ?></ins>
                        </div>

                        <!-- Yay Estudio! Promo buen fin 2021 -->
                        <?php if(in_array($producto->modelo, array('ON8420', 'PL0862')) && $producto->color == 'NEGRO METÁLICO') { ?>
                            <div class="clear"></div>
                            <div class="availability-warning"><b><i class="fas fa-truck"></i> Disponibilidad de entrega</b>: primera semana de Diciembre, 2021</div>
                        <?php } ?>

                        <!-- Product Single - Rating
                    ============================================= -->
                        <div class="clear"></div>
                        <div class="line"></div>

                        <!-- Product Single - Quantity & Cart Button
                    ============================================= -->
                        <div class="quantity clearfix">
                            <input type="button" value="-" class="minus" onclick="menos();">
                            <input type="text" step="1" min="1" name="cantidad" id="qty" value="1" title="Qty" class="qty" size="4" />
                            <input type="button" value="+" class="plus" onclick="mas();">
                        </div>

                        <a href="<?php echo base_url()?>plados/agregar_carritoP/<?php echo $producto->id_catProducto; ?>" id="add-to-cart" class="add-to-cart button nomargin">Añadir al carrito</a>


                        <div class="clear"></div>
                        <div class="line"></div>

                        <!-- Product Single - Short Description
                    ============================================= -->
                        <p><?php echo $producto->producto ?> <?php echo $producto->linea ?> modelo <?php echo $producto->modelo ?> <br>
                            Color: <b><?php echo $producto->color ?> <?php echo $color ?></b></p>
                        <p></p>
                        <ul class="iconlist">
                            <?php foreach( $bullets as $b)
                            {?>
                            <li><i class="icon-caret-right"></i> <?php echo $b->bullet ?></li>
                            <?php }?>

                        </ul><!-- Product Single - Short Description End -->

                        <!-- Product Single - Meta
                    ============================================= -->
                        <div class="panel panel-default product-meta">
                            <div class="panel-body">
                                <span itemprop="productID" class="sku_wrapper">SKU: <span class="sku"><?php echo $producto->sku ?></span></span>
                                <span class="posted_in">Categoría: <a href="#" rel="tag"><?php echo $producto->producto ?>S</a>.</span>
                            </div>
                        </div><!-- Product Single - Meta End -->

                        <!-- Product Single - Share
                    ============================================= -->
                        <div class="si-share noborder clearfix">
                            <span>Compartir en:</span>
                            <div>
                                <a href="http://www.facebook.com/sharer.php?u=http://www.plados.mx/index.php/plados/detalle_articulo/<?php echo $producto->id_catProducto ?>" class="social-icon si-borderless si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=Mira%20este%20precioso%20articulo%20http://www.plados.mx/index.php/plados/detalle_articulo/<?php echo $producto->id_catProducto ?>" class="social-icon si-borderless si-twitter">
                                    <i class="icon-twitter"></i>
                                    <i class="icon-twitter"></i>
                                </a>
                            </div>
                        </div><!-- Product Single - Share End -->

                    </div>

                    <div class="col_one_fifth col_last">
                        <div class="side-product-logos">
                            <div class="img-holder" style="background-image:url('<?php echo base_url() ?>src/images/tarjas-italianas.svg')"></div>
                            <div class="img-holder" style="background-image:url('<?php echo base_url() ?>src/images/envio-todo-mexico.svg')"></div>
                            <div class="img-holder" style="background-image:url('<?php echo base_url() ?>src/images/compra-segura.svg')"></div>
                            <div class="img-holder" style="background-image:url('<?php echo base_url() ?>src/images/meses-sin-intereses.svg')"></div>
                            <div class="img-holder" style="background-image:url('<?php echo base_url() ?>src/images/garantia-tarjas.svg')"></div>
                        </div>
                        <!--
                        <a href="#" title="Brand Logo" class="hidden-xs"><img class="image_fade" src="<?php echo base_url() ?>src/images/logo.png" alt="PLADOS Logo"></a>
                        <div class="divider divider-center"><i class="icon-circle-blank"></i></div>
                        <div class="feature-box fbox-plain fbox-dark fbox-small">
                            <div class="fbox-icon">
                                <i class="icon-thumbs-up2"></i>
                            </div>
                            <h3>100% Italiano</h3>
                            <p class="notopmargin">Desarrollada desde Italia para tí</p>
                        </div>

                        <div class="feature-box fbox-plain fbox-dark fbox-small">
                            <div class="fbox-icon">
                                <i class="icon-credit-cards"></i>
                            </div>
                            <h3>Opciones de pago</h3>
                            <p class="notopmargin">3 y 6 meses ¡sin intereses! pagando con Visa y MasterdCard </p>
                        </div>

                        <div class="feature-box fbox-plain fbox-dark fbox-small">
                            <div class="fbox-icon">
                                <i class="icon-truck2"></i>
                            </div>
                            <h3>Envío Gratuito</h3>
                            <p class="notopmargin">Envío Gratuito en todo México</p>
                        </div>

                        <div class="feature-box fbox-plain fbox-dark fbox-small">
                            <div class="fbox-icon">
                                <i class="icon-undo"></i>
                            </div>
                            <h3>10 Años de Garantía</h3>
                            <p class="notopmargin"> garantía de <b>10 años</b> contra choque termico y nuestras llaves mezcladoras una garantía de <b>2 años</p>
                        </div>
                        -->
                    </div>

                    <div class="col_full nobottommargin">

                        <div class="tabs clearfix nobottommargin" id="tab-1">

                            <ul class="tab-nav clearfix">
                                <li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="hidden-xs"> Descripción</span></a></li>
                                <!-- <li><a href="#tabs-2"><i class="icon-info-sign"></i><span class="hidden-xs"> Additional Information</span></a></li>
                                <li><a href="#tabs-3"><i class="icon-star3"></i><span class="hidden-xs"> Reviews (2)</span></a></li>-->
                            </ul>

                            <div class="tab-container">

                                <div class="tab-content clearfix" id="tabs-1">
                                    <?php echo $producto->descripcion ?>
                                </div>
                                <!--
                                <div class="tab-content clearfix" id="tabs-2">

                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Size</td>
                                                <td>Small, Medium &amp; Large</td>
                                            </tr>
                                            <tr>
                                                <td>Color</td>
                                                <td>Pink &amp; White</td>
                                            </tr>
                                            <tr>
                                                <td>Waist</td>
                                                <td>26 cm</td>
                                            </tr>
                                            <tr>
                                                <td>Length</td>
                                                <td>40 cm</td>
                                            </tr>
                                            <tr>
                                                <td>Chest</td>
                                                <td>33 inches</td>
                                            </tr>
                                            <tr>
                                                <td>Fabric</td>
                                                <td>Cotton, Silk &amp; Synthetic</td>
                                            </tr>
                                            <tr>
                                                <td>Warranty</td>
                                                <td>3 Months</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-content clearfix" id="tabs-3">

                                    <div id="reviews" class="clearfix">

                                        <ol class="commentlist clearfix">

                                            <li class="comment even thread-even depth-1" id="li-comment-1">
                                                <div id="comment-1" class="comment-wrap clearfix">

                                                    <div class="comment-meta">
                                                        <div class="comment-author vcard">
                                                            <span class="comment-avatar clearfix">
                                                                <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='60' width='60' /></span>
                                                        </div>
                                                    </div>

                                                    <div class="comment-content clearfix">
                                                        <div class="comment-author">John Doe<span><a href="#" title="Permalink to this comment">April 24, 2014 at 10:46AM</a></span></div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo perferendis aliquid tenetur. Aliquid, tempora, sit aliquam officiis nihil autem eum at repellendus facilis quaerat consequatur commodi laborum saepe non nemo nam maxime quis error tempore possimus est quasi reprehenderit fuga!</p>
                                                        <div class="review-comment-ratings">
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star-half-full"></i>
                                                        </div>
                                                    </div>

                                                    <div class="clear"></div>

                                                </div>
                                            </li>

                                            <li class="comment even thread-even depth-1" id="li-comment-1">
                                                <div id="comment-1" class="comment-wrap clearfix">

                                                    <div class="comment-meta">
                                                        <div class="comment-author vcard">
                                                            <span class="comment-avatar clearfix">
                                                                <img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='60' width='60' /></span>
                                                        </div>
                                                    </div>

                                                    <div class="comment-content clearfix">
                                                        <div class="comment-author">Mary Jane<span><a href="#" title="Permalink to this comment">June 16, 2014 at 6:00PM</a></span></div>
                                                        <p>Quasi, blanditiis, neque ipsum numquam odit asperiores hic dolor necessitatibus libero sequi amet voluptatibus ipsam velit qui harum temporibus cum nemo iste aperiam explicabo fuga odio ratione sint fugiat consequuntur vitae adipisci delectus eum incidunt possimus tenetur excepturi at accusantium quod doloremque reprehenderit aut expedita labore error atque?</p>
                                                        <div class="review-comment-ratings">
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star3"></i>
                                                            <i class="icon-star-empty"></i>
                                                            <i class="icon-star-empty"></i>
                                                        </div>
                                                    </div>

                                                    <div class="clear"></div>

                                                </div>
                                            </li>

                                        </ol>

                                        <!-- Modal Reviews
                                    ============================================= --
                                        <a href="#" data-toggle="modal" data-target="#reviewFormModal" class="button button-3d nomargin fright">Add a Review</a>

                                        <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="reviewFormModalLabel">Submit a Review</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="nobottommargin" id="template-reviewform" name="template-reviewform" action="#" method="post">

                                                            <div class="col_half">
                                                                <label for="template-reviewform-name">Name <small>*</small></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                                                    <input type="text" id="template-reviewform-name" name="template-reviewform-name" value="" class="form-control required" />
                                                                </div>
                                                            </div>

                                                            <div class="col_half col_last">
                                                                <label for="template-reviewform-email">Email <small>*</small></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">@</span>
                                                                    <input type="email" id="template-reviewform-email" name="template-reviewform-email" value="" class="required email form-control" />
                                                                </div>
                                                            </div>

                                                            <div class="clear"></div>

                                                            <div class="col_full col_last">
                                                                <label for="template-reviewform-rating">Rating</label>
                                                                <select id="template-reviewform-rating" name="template-reviewform-rating" class="form-control">
                                                                    <option value="">-- Select One --</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </div>

                                                            <div class="clear"></div>

                                                            <div class="col_full">
                                                                <label for="template-reviewform-comment">Comment <small>*</small></label>
                                                                <textarea class="required form-control" id="template-reviewform-comment" name="template-reviewform-comment" rows="6" cols="30"></textarea>
                                                            </div>

                                                            <div class="col_full nobottommargin">
                                                                <button class="button button-3d nomargin" type="submit" id="template-reviewform-submit" name="template-reviewform-submit" value="submit">Submit Review</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div><!-- /.modal-content --
                                            </div><!-- /.modal-dialog --
                                        </div><!-- /.modal -->
                                <!-- Modal Reviews End -

                                    </div>

                                </div>-->

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="clear"></div>
            <div class="line"></div>
            <!--
            <div class="col_full nobottommargin">

                <h4>Productos Relacionados</h4>

                <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">

                    <div class="oc-item">
                        <div class="product iproduct clearfix">
                            <div class="product-image">
                                <a href="#"><img src="images/shop/dress/1.jpg" alt="Checked Short Dress"></a>
                                <a href="#"><img src="images/shop/dress/1-1.jpg" alt="Checked Short Dress"></a>
                                <div class="sale-flash">50% Off*</div>
                                <div class="product-overlay">
                                    <a href="#" class="add-to-cart"><i class="icon-shopping-cart"></i><span> Add to Cart</span></a>
                                    <a href="include/ajax/shop-item.html" class="item-quick-view" data-lightbox="ajax"><i class="icon-zoom-in2"></i><span> Quick View</span></a>
                                </div>
                            </div>
                            <div class="product-desc center">
                                <div class="product-title">
                                    <h3><a href="#">Checked Short Dress</a></h3>
                                </div>
                                <div class="product-price"><del>$24.99</del> <ins>$12.49</ins></div>
                                <div class="product-rating">
                                    <i class="icon-star3"></i>
                                    <i class="icon-star3"></i>
                                    <i class="icon-star3"></i>
                                    <i class="icon-star3"></i>
                                    <i class="icon-star-half-full"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>

    </div>

</section>




<script>
function mas()
{
    cantidad = parseInt($("#qty").val());
    var qty = (cantidad+1);
    $("#qty").val(qty);

    $('#add-to-cart').attr('href', '/plados/agregar_carritoP/<?php echo $producto->id_catProducto; ?>/'+qty);
}
function menos()
{
    cantidad = parseInt($("#qty").val());
    if( cantidad > 1){
        var qty = (cantidad-1);
        $("#qty").val(qty);

        $('#add-to-cart').attr('href', '/plados/agregar_carritoP/<?php echo $producto->id_catProducto; ?>/'+qty);
    }
}
</script>