<?php
header("Content-Type: text/html;charset=utf-8");
$codigo = $this->session->userdata("id");
$usuario = $this->m_usuario->obt_usuario($codigo);

?>

<!DOCTYPE html>
<html dir="ltr" lang="es-MX">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Ctings" />

    <!-- Stylesheets
	============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/swiper.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/dark.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/assets/icon54-v4/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>src/assets/icon54-v2/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>src/assets/icon54/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>src/assets/icons-mind/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>src/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>src/css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="<?= base_url() ?>src/css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script type="text/javascript" src="<?= base_url() ?>src/js/jquery.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>src/css/components/bs-datatable.css" type="text/css" />



    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <!-- Document Title
	============================================= -->
    <title>Plados - <?= $title ?></title>

    <style>
        body:not(.no-transition) #wrapper, .animsition-overlay{
            opacity:1;
        }
    </style>
</head>

<?php
$controlador = $this->uri->segment(1);
$funcion = $this->uri->segment(2);
$objeto  = $this->uri->segment(3);

$this->m_seguridad->log_general($controlador, $funcion, $objeto);

if ($this->session->userdata("id") == null) {
    redirect('/acceso/logout');
}
if ($this->m_seguridad->acceso_sistema() == 0) {

    redirect('/Inicio/noaccess');
}
?>