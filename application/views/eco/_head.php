<!DOCTYPE html>
<html dir="ltr" lang="es-MX">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Ctings" />

    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/swiper.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/dark.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/assets/icon54-v4/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>src/assets/icon54-v2/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>src/assets/icon54/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>src/assets/icons-mind/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/responsive.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/plados-yay.css" type="text/css" />


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5ZXBTMW');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Yay! Estudio: No remover, ayuda a posicionar el chat de Facebook -->
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/facebook-chat.css" type="text/css" />
    <!-- Facebook Pixel Code -->
    <script nonce="dQzcPFtG">
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '340276603780026');
        fbq('set', 'agent', 'tmgoogletagmanager', '340276603780026');
        fbq('track', "PageView");
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=340276603780026&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo base_url() ?>src/js/jquery.js"></script>

    <!-- Slick responsive carousel -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Yay! Estudio: Custom Script functionality -->
    <script type="text/javascript" src="<?php echo base_url() ?>src/js/plados-yay.js"></script>

    <!-- Yay! Estudio Oct, 2021 - Cart Redesign -->
    <link rel="stylesheet" href="<?php echo base_url() ?>src/css/yay-cart-redesign.css" type="text/css" />

    <style>
        /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        #header {
            overflow: hidden !important;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <!--[if lt IE 9]>
        <script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title>Plados - <?php echo $title ?></title>

</head>