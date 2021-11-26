<body class="stretched">

    <!-- Document Wrapper
============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Content
    ============================================= -->
        <section id="content">

            <div class="content-wrap nopadding">
                <div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('images/parallax/home/1.jpg') center center no-repeat; background-size: cover;"></div>
                <div class="section nobg full-screen nopadding nomargin">
                    <div class="container vertical-middle divcenter clearfix">
                        <div class="row center">
                            <a href="index.html"><img src="images/logo-dark.png" ></a>
                        </div>
                        <div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                            <div class="panel-body" style="padding: 40px;">
                                <form id="login-form" name="login-form" class="nobottommargin" action="<?php echo base_url(); ?>index.php?/acceso/login" method="post">
                                    <h3>Administrador Plados MX</h3>
                                    <div class="text-center">
                                        <? if($this->uri->segment(3) == "e")
                    {?>
                                        <div class="alert alert-danger alert-dismissible">
                                            <h4><i class="icon fa fa-remove"></i> ¡Atención!</h4>
                                            ¡El Usuario o la contraseña son Incorrectos!
                                        </div>
                                        <?}?>
                                    </div>

                                    <div class="col_full">
                                        <label for="user">Usuario:</label>
                                        <input type="text" id="user" name="user" value="" class="form-control not-dark" />
                                    </div>
                                    <div class="col_full">
                                        <label for="password">Contraseña:</label>
                                        <input type="password" id="password" name="password" value="" class="form-control not-dark" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Ingresar</button>
                                        <a href="#" class="fright">Forgot Password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row center dark"><small>Copyrights &copy; Plados MX.</small></div>

                    </div>
                </div>

            </div>

        </section><!-- #content end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- External JavaScripts
============================================= -->
    <script type="text/javascript" src="js/jquery.js"></script>

    <script type="text/javascript" src="<?= base_url() ?>src/js/plugins.js"></script>

    <!-- Footer Scripts
============================================= -->
    <script type="text/javascript" src="<?= base_url() ?>src/js/functions.js"></script>

</body>








<body class="hold-transition loading-page">

    <div class="cover"></div>
    <div class="ibox login-content">

        <form class="ibox-body" action="<?php echo base_url(); ?>index.php?/acceso/login" method="post">
            <h4 class="font-strong text-center mb-5">INGRESAR | ADMIN</h4>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="text" name="user" placeholder="Usuaio">
            </div>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="password" name="password" placeholder="contraseña">
            </div>
            <!--<div class="flexbox mb-5">
                <span>
                    <label class="ui-switch switch-icon mr-2 mb-0">
                        <input type="checkbox" checked="">
                        <span></span>
                    </label>Remember</span>
                <a class="text-primary" href="forgot_password.html">Forgot password?</a>
            </div>-->
            <div class="text-center mb-4">
                <button class="btn btn-primary btn-rounded btn-block">LOGIN</button>
            </div>
        </form>
    </div>

</body>


</html>