<!--
    Notas de Desarrollo:
    El nuevo diseño fusiona los campos nombre, apellido paterno y materno en un mismo campo, considerarlos l enviar correo y guardar los datos.
-->
<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>CARRITO DE COMPRAS</h1>
    </div>
</section>

<section>
    <div class="secure-100">COMPRA 100% SEGURA</div>
    <div class="container-fluid warranty-logos-holder">
        <div class="container">
            <?php $this->load->view("eco/warranty-logos"); ?>
        </div>
    </div>
</section>


<pre class="hidden"><?php print_r($usuario); ?></pre>

<!-- Steps -->
<?php $this->load->view("eco/pages/cart-steps", ["step" => 2]); ?>


<div class="page-content cart-info">
    <form action="<?= base_url() ?>guardar_datos" method="POST" class="container" id="cartCustomerDataForm">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="<?= base_url() ?>carrito">&laquo; Regresar a resumen</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h1>DATOS PERSONALES Y ENVÍO</h1>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-8 col-md-8">
                        <div class="form-group">
                            <label>Nombre completo:</label>
                            <input type="text" name="nombre" value="<?php echo ($usuario) ? $usuario->nombre : ""; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <input type="text" name="correo" value="<?php echo ($usuario) ? $usuario->correo : ""; ?>" class="form-control">
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Calle:</label>
                            <input type="text" name="Calle" class="form-control" value="<?php echo ($usuario) ? $usuario->calle : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <label>No. Exterior:</label>
                            <input type="text" name="NumExterno" class="form-control" value="<?php echo ($usuario) ? $usuario->numExterno : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <label>No. Interior:</label>
                            <input type="text" name="NumInterno" class="form-control" value="<?php echo ($usuario) ? $usuario->numInterno : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>Teléfono o celular:</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo ($usuario) ? $usuario->telefono : ""; ?>">
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-2">
                        <div class="form-group">
                            <label>C.P:</label>
                            <input type="text" name="cp" class="form-control" value="<?php echo ($usuario) ? $usuario->cp : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>Estado:</label>
                            <select id="estados" name="estado" class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>Municipio:</label>
                            <input type="text" name="ciudad" class="form-control" value="<?php echo ($usuario) ? $usuario->ciudad : ""; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>Colonia:</label>
                            <input type="text" name="colonia" class="form-control" value="<?php echo ($usuario) ? $usuario->colonia : ""; ?>">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-9">
                        <div class="form-group">
                            <label>Referencias:</label>
                            <input type="text" name="referencias" class="form-control" value="<?php echo ($usuario) ? $usuario->referencias : ""; ?>">
                        </div>
                    </div>
                </div>


                <!-- Requiero Factura -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="cupon-area">
                            <label><input type="checkbox" <?php if ($factura["facturar"] && $factura["facturar"] == true) { ?>checked<?php } ?> name="facturar" /> ¿REQUIERE FACTURA?</label>
                        </div>
                        <br />
                    </div>
                </div>
                <div class="row <?php if (!$factura["facturar"] && $factura["facturar"] == false) { ?>hidden<?php } ?>" id="datos-factura">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nombre Fiscal:</label>
                            <input type="text" class="form-control" name="fiscal-name" value="<?php echo $factura["nombre"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>RFC:</label>
                            <input type="text" class="form-control" name="fiscal-rfc" value="<?php echo $factura["rfc"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Correo:</label>
                            <input type="email" class="form-control" name="fiscal-email" value="<?php echo $factura["correo"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Dirección de Facturación:</label>
                            <input type="text" class="form-control" name="fiscal-address" value="<?php echo $factura["direccion"]; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Uso de la Factura:</label>
                            <select class="form-control" name="fiscal-usage">
                                <option <?php if ($factura["uso"] && $factura["uso"] == "Gastos en General") { ?>selected<?php } ?>>Gastos en General</option>
                                <option <?php if ($factura["uso"] && $factura["uso"] == "Por definir") { ?>selected<?php } ?>>Por definir</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Error? -->
                <div class="alert alert-danger hidden" role="alert"></div>
            </div>
            <div class="col-lg-3 col-md-4">
                <!-- Resúmen -->
                <?php $this->load->view("eco/pages/cart-summary", $cuenta); ?>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {

        // Yay! Estudio: Valida el formulario antes de enviarlo:
        $('#cartCustomerDataForm').submit((e) => {
            e.preventDefault();
            $('.alert.alert-danger').addClass("hidden");

            $.post($('#cartCustomerDataForm').attr("action"), $('#cartCustomerDataForm').serialize(), function(res) {
                if (res.error) {
                    $('.alert.alert-danger').removeClass("hidden");
                    $('.alert.alert-danger').html(res.error);
                } else {
                    location.href = '<?php echo base_url() ?>checkout';
                }
            });
        });



        // Yay! Estudio: Requerimiento de Factura
        $('[name="facturar"]').change((e) => {
            if ($('[name="facturar"]').prop("checked") === true) {
                $('#datos-factura').removeClass("hidden");
            } else {
                $('#datos-factura').addClass("hidden");
            }
        });



        // Obtiene los estados para popular el selector:
        var estados = $("#estados");
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '<?= base_url() ?>src/estados.json',
            beforeSend: function() {
                //estados.prop('disabled', true);
            },
            success: function(r) {
                estados.find('option').remove();

                $(r).each(function(i, v) { // indice, valor
                    var selected = "";
                    <?php if ($usuario) { ?>
                        if (v.nombre === '<?php echo $usuario->estado; ?>')
                            selected = "selected";
                    <?php } ?>
                    estados.append('<option ' + selected + ' value="' + v.nombre + '">' + v.nombre + '</option>');
                })
            },
            error: function() {
                console.log("Hubo un problema al obtener los estados del selector.");
            }
        });
    })
</script>