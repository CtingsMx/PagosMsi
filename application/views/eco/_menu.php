<?php
    $itemsInCart = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $itemsInCart += $item['cantidad'];
    }
}
?>
<body class="stretched" <?php if(isset($_SESSION['alertaNuevoProducto']) && $_SESSION['alertaNuevoProducto'] == 1) { ?>style="overflow:hidden;"<?php 
                        } ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZXBTMW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="wrapper" class="clearfix">

        <nav id="plados-header">
            <!-- Desktop -->
            <div class="container-fluid">
                <div class="row desktop">
                    <div class="col-logo col-md-2">
                        <a class="img-logo" style="background-image:url(<?php echo base_url() ?>src/images/logo.png)" href="<?php echo base_url() ?>"></a>
                    </div>
                    <div class="col-md-10">
                        <ul>
                            <li><a href="<?php echo base_url()?>">INICIO</a></li>
                            <li><a href="<?php echo base_url()?>nosotros">NOSOTROS</a></li>
                            <li><a href="<?php echo base_url()?>soporte">SOPORTE</a></li>
                            <li><a href="<?php echo base_url()?>tecnologia">TECNOLOGÍA</a></li>
                            <li><a href="<?php echo base_url()?>productos">PRODUCTOS</a></li>
                            <li><a href="<?php echo base_url()?>puntos-de-venta">PUNTOS DE VENTA</a></li>
                            <li><a href="<?php echo base_url()?>productos" class="buy">COMPRAR</a></li>
                            <li>
                                <img src="<?php echo base_url() ?>src/images/compra-segura.svg"/>
                                <img src="<?php echo base_url() ?>src/images/meses-sin-intereses.svg"/>
                            </li>
                            <li>
                                <a href="/carrito" class="cart-helper">
                                    <i class="icon-shopping-cart"></i>
                                    <?php if(isset($_SESSION['cart'])) { ?>
                                        <b class="cart-count"><?php echo $itemsInCart; ?></b>
                                    <?php } ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="row mobile">
                    <div class="col-logo col-md-1 col-sm-2 col-xs-2">
                        <a href="javascript:void(0);" class="mobile-menu">
                            <i class="icon-reorder"></i>
                        </a>
                    </div>
                    <div class="col-logo col-md-2 col-sm-3 col-xs-3">
                        <a class="img-logo" style="background-image:url(<?php echo base_url() ?>src/images/logo.png)" href="<?php echo base_url() ?>"></a>
                    </div>
                    <div class="col-md-9 col-sm-7 col-xs-7">
                        <ul>
                            <li>
                                <img src="<?php echo base_url() ?>src/images/compra-segura.svg"/>
                                <img src="<?php echo base_url() ?>src/images/meses-sin-intereses.svg"/>
                            </li>
                            <li>
                                <a href="/carrito" class="cart-helper">
                                    <i class="icon-shopping-cart"></i>
                                    <?php if(isset($_SESSION['cart'])) { ?>
                                        <b class="cart-count"><?php echo count($_SESSION['cart']); ?></b>
                                    <?php } ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <ul class="toggle-menu">
                        <li><a href="/">INICIO</a></li>
                        <li><a href="/nosotros">NOSOTROS</a></li>
                        <li><a href="/soporte">SOPORTE</a></li>
                        <li><a href="/tecnologia">TECNOLOGÍA</a></li>
                        <li><a href="/productos">PRODUCTOS</a></li>
                        <li><a href="/puntos-de-venta">PUNTOS DE VENTA</a></li>
                        <li><a href="/productos" class="buy">COMPRAR</a></li>
                    </ul>

                </div>
            </div>
        </div>

    <?php if(isset($_SESSION['alertaNuevoProducto']) && $_SESSION['alertaNuevoProducto'] == 1) { ?>
        <script>
            $(function() {
                $('#cart-side-holder').removeClass('hidden');
            });
        </script>
        <?php $_SESSION['alertaNuevoProducto'] = 0; 
    }?>

    <!-- Yay! Oct, 2021 - Carrito panel lateral -->
    <div id="cart-side-holder" class="hidden" onclick="closeSideCart();">
        <div class="cart-side-panel">
            <img src="<?php echo base_url()?>src/images/cart-redesign/close.png" class="close-side-cart"/>
            <img src="<?php echo base_url()?>src/images/cart-redesign/your-cart.png" alt="Tu carrito" class="your-cart"/>
            <div class="items-holder">

            </div>

            <div class="cart-side-bottom">
                <div class="cart-side-subtotal"></div>
                <a href="<?php echo base_url()?>productos" class="cart-side-cta">CONTINUAR COMPRANDO</a>
                <a href="<?php echo base_url()?>carrito" class="cart-side-cta primary">FINALIZAR COMPRA</a>
            </div>
        </div>
    </div>
