<script>
    function modalFactura(id) {
        $.getJSON("/admin/modalFactura/" + id, function(res) {
            $('[data-rsocial]').text(res.nombre);
            $('[data-rfc]').text(res.rfc);
            $('[data-correo]').text(res.correo);
            $('[data-direccion]').text(res.direccion);
            $('[data-uso]').text(res.uso);
            $('#factura-id').val(res.id);
            $('#modalFactura').modal('show');
        });



        $('#modalFactura').submit((e) => {
            e.preventDefault();

            $('.alert.alert-danger').addClass("hidden");

            var formData = new FormData(document.getElementById('modalFactura'));

            $.ajax({
                url: '/admin/enviarFactura/' + id,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(res) {
                    if (res.errors) {
                        $('.alert.alert-danger').html(res.errors);
                        $('.alert.alert-danger').removeClass("hidden");
                    }
                    if (res.success) {
                        $('.alert.alert-success').text(res.success);
                        $('.alert.alert-success').removeClass("hidden");
                        document.getElementById("modalFactura").reset();
                    }
                }
            });

        });
    }
</script>
<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Inicio Administrador</h1>
    </div>
</section>

<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="table-responsive">
                <h3>Pedidos Abiertos </h3>
                <table id="datatable1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th># Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha Pedido</th>
                            <th width="10px">Articulos</th>
                            <th>Cuenta</th>
                            <th>Id de Pago</th>
                            <th>Estatus</th>
                            <th>¿Facturar?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th># Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha Pedido</th>
                            <th width="10px">Articulos</th>
                            <th>Cuenta</th>
                            <th>Id de Pago</th>
                            <th>Estatus</th>
                            <th>¿Facturar?</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <? foreach ($pedidos as $p) {
                            $fecha = $this->m_admin->fecha_text($p->fecha_pedido);
                        ?>
                            <tr>
                                <td><?= $p->id_pedido ?></td>
                                <td><?= $p->nombre ?></td>
                                <td><?= $fecha ?></td>
                                <td align="center"><?= $p->cantArticulos ?></td>
                                <td><b>$<?= number_format($p->cuenta, '2', ',', ' ') ?></b></td>
                                <td><?= $p->idPago ?></td>
                                <td align="center"><?= $p->etiqueta ?></td>
                                <td>
                                    <?php if (isset($p->fnombre) && !empty($p->fnombre)) { ?>
                                        <button class="btn btn-sm btn-default" onclick="modalFactura(<?php echo $p->fid; ?>)"><i class="icon icon-files"></i> Enviar Factura</button>
                                        <?php if (isset($p->fenviada)) { ?>
                                            <br />
                                            <em class="text-success" style="display:block; font-size:11px; text-align:center;">✓ La factura ya ha sido enviada</em>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <em>Sin factura</em>
                                    <?php } ?>
                                </td>
                                <td align="center"><a href="<?= base_url() ?>index.php/admin/seguimiento/<?= $p->id_pedido ?>" target="_blank" class="btn btn-info btn-sm"><i class="icon icon-search"></i></a></td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Envío de Factura -->
<form method="POST" class="modal" tabindex="-1" role="dialog" id="modalFactura" enctype="multipart/form-data">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar Factura al Cliente</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Adjuntar factura (.pdf y .xml)</label>
                    <input type="file" name="archivos[]" multiple class="form-control" placeholder="Seleccionar archivo">
                    <input type="hidden" name="id" id="factura-id" />
                    <small class="form-text text-muted">Seleccione ambos archivos .pdf y .xml para adjuntarlos al correo que será enviado al cliente.</small>
                </div>

                <div class="alert alert-danger hidden" role="alert"></div>
                <div class="alert alert-success hidden" role="alert"></div>
                <hr />

                <table class="table">
                    <thead>
                        <th colspan="100%" bgcolor="#EDEDED">Datos de facturación proporcionados por el cliente</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th width="30%">Razón Social</th>
                            <td align="right" data-rsocial width="70%">Razón Social</td>
                        </tr>
                        <tr>
                            <th>RFC</th>
                            <td align="right" data-rfc>RFC</td>
                        </tr>
                        <tr>
                            <th>Correo</th>
                            <td align="right" data-correo>Correo</td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td align="right" data-direccion>Dirección</td>
                        </tr>
                        <tr>
                            <th>Uso del CFDI</th>
                            <td align="right" data-uso>Uso del CFDI</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar Factura</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</form>