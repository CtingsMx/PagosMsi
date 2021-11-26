<?php
header("Content-Type: text/html;charset=utf-8");

?>
    <!--
    ###########################################
    #                                         #
    #  CARGANDO TODAS LAS LIBRERIAS CSS Y JS  #
    #       NECESARIAS PARA EL PROYECTO       #
    #                                         #
    ###########################################
-->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?=base_url()?>src/eco/assets/images/logoplados-317x79.png" type="image/x-icon">

    <title> Plados</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="<?=base_url()?>src/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />

    <link href="<?=base_url()?>src/assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/animate.css/animate.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/toastr/toastr.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?=base_url()?>src/assets/vendors/summernote/dist/summernote.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="<?=base_url()?>src/assets/vendors/dataTables/datatables.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="<?=base_url()?>src/eco/assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="<?=base_url()?>src/eco/assets/theme/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>src/eco/assets/colorm-icons/style.css">
  <link rel="stylesheet" href="<?=base_url()?>src/eco/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>


  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- THEME STYLES-->
    <link href="<?=base_url()?>src/assets/css/main.min.css" rel="stylesheet" />

    

        <script src="<?=base_url()?>src/js/jquery-2.2.3.min.js"></script>
    </head>    

    <?php /*
    $controlador = $this->uri->segment(1);
    $funcion = $this->uri->segment(2);
    $objeto  = $this->uri->segment(3);

    $this->m_seguridad->log_general($controlador, $funcion, $objeto);
    
    if($this->session->userdata("codigo") == null){
        redirect('/acceso/logout');
    }
    if($this->m_seguridad->acceso_sistema() == 0)
    {

        redirect('/Inicio/noaccess');
    }

    */
    ?>

