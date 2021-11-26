<?
$codigo = $this->session->userdata("id");
$usuario = $this->m_usuario->obt_usuario($codigo);
?>

<body class="stretched">

    <!-- Document Wrapper
============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Header
============================================= -->
        <header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

            <div id="header-wrap">

                <div class="container clearfix">

                    <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                    <!-- Logo
            ============================================= -->
                    <div id="logo">
                        <a href="<?= base_url() ?>admin" class="standard-logo" data-dark-logo="<?= base_url() ?>src/images/logob.png"><img src="<?= base_url() ?>src/images/logo.png" alt="Plados Logo"></a>
                        <a href="<?= base_url() ?>admin" class="retina-logo" data-dark-logo="<?= base_url() ?>src/images/logob.png"><img src="<?= base_url() ?>src/images/logo.png" alt="Plados Logo"></a>
                    </div><!-- #logo end -->

                    <!-- Primary Navigation
            ============================================= -->
                    <nav id="primary-menu" class="dark">

                        <ul>
                            <li class=""><a href="<?= base_url() ?>index.php/admin">
                                    <div>INICIO</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>index.php/admin/lista_productos">
                                    <div>PRODUCTOS</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>index.php/admin/banners">
                                    <div>BANNERS</div>
                                </a></li>
                            <li class=""><a href="<?= base_url() ?>index.php/admin/testimoniales">
                                    <div>TESTIMONIALES</div>
                                </a></li>
                        </ul>



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