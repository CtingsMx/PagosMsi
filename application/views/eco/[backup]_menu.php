<body class="stretched">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZXBTMW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Document Wrapper
============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Header
    ============================================= -->
        <header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

            <div id="header-wrap">

                <div class="container-fluid clearfix">

                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                    <!-- Logo
                ============================================= -->
                    <div id="logo">
                        <!--a href="<?= base_url() ?>" class="standard-logo" data-dark-logo="<?= base_url() ?>src/images/logob.png"><img src="<?= base_url() ?>src/images/logo.png" alt="Plados Logo"></a-->
                        <a href="<?= base_url() ?>" class="retina-logo" data-dark-logo="<?= base_url() ?>src/images/logob.png"><img src="<?= base_url() ?>src/images/logo.png" alt="Plados Logo"></a>
                    </div><!-- #logo end -->

                    <!-- Primary Navigation
                ============================================= -->
                    <nav id="primary-menu" class="dark">

                        <ul>
                        <li class=""><a href="<?= base_url() ?>">
                                    <div>INICIO</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>nosotros">
                                    <div>NOSOTROS</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>soporte">
                                    <div>SOPORTE</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>tecnologia">
                                    <div>TECNOLOGÍA</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>productos">
                                    <div>PRODUCTOS</div>
                                </a></li>
                            <li class=""><a href="/puntos-de-venta">
                                    <div>PUNTOS DE VENTA</div>
                                </a></li>                                
                            <!--
                            <li class=""><a href="#" data-toggle="modal" data-target=".bs-example-modal-lg">
                                    <div>PUNTOS DE VENTA</div>
                                </a></li>
                            -->
                            <li class="buy-btn">
                                <a href="<?= base_url() ?>productos">
                                    COMPRAR
                                </a>
                            </li>


                            <li class="image-labels">
                                <img src="<?= base_url() ?>src/images/compra-segura.svg"/>
                                <img src="<?= base_url() ?>src/images/meses-sin-intereses.svg"/>
                            </li>
                        </ul>

                        <!-- Top Cart
                    ============================================= -->
                        <div id="top-cart">                       
                            <a href="/carrito" id="top-cart-trigger"><i class="icon-shopping-cart"></i>
                            <?if (isset($_SESSION['cart'])) {?>
                                <span>                                   
                                    <?= count($_SESSION['cart']); ?>
                                </span></a>
                            <div class="top-cart-content">
                                <div class="top-cart-title">
                                    <h4>Carrito</h4>
                                </div>
                                <div class="top-cart-items">
                                    <?
                                    $cantProductos = 0;
                                    $sub = 0; //die(var_dump($carrito)); 
                                    $total = 0; 
                                    foreach($_SESSION['cart'] as $cart)
                                    {
                                        $subtotal = $cart['cantidad'] * $cart['precio'];
    						            $cantProductos = $cantProductos + $cart['cantidad'];
    						            $sub = $sub + $subtotal; ?>
                                    <div class="top-cart-item clearfix">
                                        <div class="top-cart-item-image">
                                            <a href="#"><img src="<?= base_url() ?>src/images/shop/<?= $cart['foto'] ?>" alt="<?= $cart['descripcion'] ?>" /></a>
                                        </div>
                                        <div class="top-cart-item-desc">
                                            <a href="#"><?= $cart['descripcion'] ?></a>
                                            <span class="top-cart-item-price"> $<?= number_format($subtotal, '2', ',', ' ') ?></span>
                                            <!--<span class="top-cart-item-quantity">x 1</span>-->
                                        </div>
                                    </div>
                                    <?}?>
                                </div>

                                <div class="top-cart-action clearfix">
                                    <span class="fleft top-checkout-price">$<?= number_format($sub, '2', ',', ' ') ?></span>
                                    <button onclick="carrito();" class="button button-3d button-small nomargin fright">Ver Carrito</button>
                                </div>
                            </div>
                            <?}
                            else {?>
                            </span></a>
                            <?}?>
                        </div><!-- #top-cart end -->

                        <!-- Top Search
                    ============================================= --
                        <div id="top-search">
                            <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                            <form action="search.html" method="get">
                                <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Buscar...">
                            </form>
                        </div>   #top-search end -->

                    </nav><!-- #primary-menu end -->

                </div>

            </div>

        </header><!-- #header end -->