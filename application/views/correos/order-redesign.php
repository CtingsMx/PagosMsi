<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido en Plados.mx</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>

<body>
    <div style="width: 680px; margin: 0 auto; font-family: 'Lato', sans-serif; background-color: #fff;">
        <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td colspan="100%" style="padding:0px 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td><img width="174" src="https://plados.mx/src/images/logo.png" /> </td>
                        </tr>
                        <tr>
                            <td valign="top" width="60%">
                                <p style="margin:0px; font-size: 40px; font-weight: 400;color: #333; text-transform: uppercase;">
                                    <?php echo $saludo; ?></p>
                            </td>
                            <td valign="top" width="40%">
                                <p style="margin: 0px; color: #333; text-align: right; font-size: 20px;">No. de
                                    seguimiento</p>
                                <p style="margin: 0px; color: red; text-align: right; font-size: 40px; font-weight: 700;">
                                    #
                                    <?PHP echo $id; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="100%">
                                <p style="margin:0px; padding-top:10px; padding-bottom: 10px;  color: #333; font-size: 16px;">
                                    Felicidades <b>tu compra ha sido confirmada</b>, en 2 días hábiles recibirás un
                                    nuevo correo con tu numero de guía de FEDEX.</p>
                                <b style="display:block; font-size: 14px;  color: #333; padding-bottom: 20px;">¡Por
                                    favor recuerda revisar tu bandeja de correos no deseados!</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="100%" style="background-color: #159b7e; color: #fff; padding: 10px 20px;">RESUMEN DE LA
                    COMPRA</td>
            </tr>
            <tr>
                <td colspan="100%" style="background-color: #fff; color: #fff; padding: 30px 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td width="33%" valign="top">
                                <p style="font-size: 14px; margin:0px; color: #848383;">Subtotal (<?php echo $items; ?>
                                    productos):</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    $<?php echo number_format($total, 2); ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Fecha de la compra:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $fecha_compra; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Fecha estimada de envío (2 días
                                    hábiles):</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $fecha_envio; ?></p>
                            </td>
                            <td width="33%" valign="top">
                                <p style="font-size: 14px; margin:0px; color: #848383;">Costo de envío:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">$0</p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">ID de pago:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;"><sup>****
                                    </sup><?= substr($pedido->idPago, -6) ?></p>
                            </td>
                            <td width="33%" valign="top">
                                <p style="margin: 0px; font-size: 18px; font-weight:700; color: #848383;">Total (IVA
                                    incluido):</p>
                                <p style="margin: 0px; font-size: 35px; font-weight: 700; color: #159b7e; margin-bottom: 30px;">
                                    $<?php echo number_format($total, 2); ?></p>
                                <!--
                                <p style="margin: 0px; font-size: 18px; font-weight:700; color: #848383;">Modalidad de pago:</p>
                                <p style="margin: 0px; font-size: 35px; font-weight: 700; color: #159b7e; margin-bottom: 30px;">XXXXX</p>
                                -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="100%" style="background-color: #159b7e; color: #fff; padding: 10px 20px;">DATOS DEL CLIENTE
                </td>
            </tr>
            <tr>
                <td colspan="100%" style="background-color: #fff; color: #fff; padding: 30px 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td width="33%" valign="top">
                                <p style="font-size: 14px; margin:0px; color: #848383;">Nombre:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->nombre; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Correo electrónico:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->correo; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Teléfono:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->telefono; ?></p>
                            </td>
                            <td width="33%" valign="top">
                                <p style="font-size: 14px; margin:0px; color: #848383;">Dirección:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->calle; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Colonia:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->colonia; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Estado:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->estado; ?></p>
                            </td>
                            <td width="33%" valign="top">
                                <p style="font-size: 14px; margin:0px; color: #848383;">Ciudad:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->ciudad; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Código Postal:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->cp; ?></p>
                                <p style="font-size: 14px; margin:0px; color: #848383;">Referencia:</p>
                                <p style="font-size: 18px; margin:0px; color: #159b7e; margin-bottom: 30px;">
                                    <?php echo $pedido->referencias; ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="100%" style="background-color: #159b7e; color: #fff; padding: 10px 20px;">DETALLES DE
                    PEDIDO</td>
            </tr>
            <tr>
                <td colspan="100%" style="background-color: #fff; color: #fff; padding: 30px 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <?php
                        foreach ($carrito as $item) {
                        ?>
                            <tr>
                                <td width="20%" style="color:#000; position:relative;">
                                    <p style="position: absolute; width: 32px; height:32px; border-radius: 100px; top:-30px; left:-15px; color: #fff; text-align: center;font-size: 23px; background-color: #159b7e;">
                                        <?php echo $item->cantidad; ?></p>
                                    <img width="100" style="border:1px solid #b8b8b8;" src="<?php echo base_url(); ?>/src/images/shop/<?php echo $item->foto; ?>" />
                                </td>
                                <td width="80%">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td style="padding-bottom:20px;" colspan="100%">
                                                <p style="margin:0px; font-size: 22px; font-weight: bold;color: #707070;">
                                                    <?php echo $item->descripcion; ?></p>
                                                <p style="margin:0px; font-size: 15px; color: #848383;">Color: <span style="color: #000;"><?php echo $item->color; ?></span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:20px;">
                                                <p style="margin:0px; font-size: 15px; color: #707070;">Precio unitario:</p>
                                                <p style="margin:0px; font-size: 15px; color: #000;">
                                                    $<?php echo number_format($item->precio, 2); ?></p>
                                            </td>
                                            <td style="padding-bottom:20px;">
                                                <p style="margin:0px; font-size: 15px; color: #707070;">Subtotal:</p>
                                                <p style="margin:0px; font-size: 15px; color: #000;">
                                                    <?php echo number_format(($item->precio * $item->cantidad), 2); ?></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="100%" style="border-top: 2px solid #F2F2F2; padding-top:10px; padding-bottom:30px; color: #b8b8b8;font-size: 14px;">
                                *Si usted no hizo esta compra, por favor ignore este mensaje</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="100%" style="background-color: #159b7e; color: #fff; padding: 25px 20px;">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td colpsan="100%">
                                <p style="margin:0px; margin-bottom:10px; font-size: 16px; color: #fff; text-transform: uppercase;">
                                    Plados 2021. Todos los derechos reservados.</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="70%">
                                <a style="dispaly:inline-block; font-size: 16px; color:#fff; font-weight: 700; text-decoration:none; margin-right: 10px;" href="https://plados.mx" target="_blank">plados.mx</a>
                                <a style="dispaly:inline-block; font-size: 16px; color:#fff; font-weight: 700; text-decoration:none; margin-right: 10px;" href="mailto: vflores@kober.com.mx" target="_blank">vflores@kober.com.mx</a>
                                <a style="dispaly:inline-block; font-size: 16px; color:#fff; font-weight: 700; text-decoration:none; margin-right: 10px;" href="https://wa.me/5213335873900" target="_blank">33 3587 3900</a>
                            </td>
                            <td width="30%">
                                <!--
                                <a href="https://plados.mx" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                <a href="https://plados.mx" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                <a href="https://plados.mx" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="https://plados.mx" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                                -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>