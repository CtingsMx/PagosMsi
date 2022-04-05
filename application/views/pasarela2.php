<div class="container">

    <div class="row justify-content-md-center mt-3">

        <div class="col-md-6">
            <h1>Datos de la compra</h1>

            <div class="accordion" id="accordionExample" style="margin-top: 50px;">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Resumen de Compra
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                            <div class="table-responsive">
                                <h4 class="text-center" style="margin-top: 15px;">Resumen de Compra</h4>
                                <input Type="hidden" value="<?=$venta->movid?>" name="pedido" id="pedido">
                                <input type="hidden" value="<?=$pk?>" id="pk" name="pk">
                                <hr />
                                <table class="table cart">
                                    <tbody>
                                        <tr>
                                            <td># Pedido:</td>
                                            <td align="center" width="50%"><b><?=$venta->ID?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Sucursal:</td>
                                            <td align="center" width="50%"><b><?=$venta->Sucursal?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Cliente:</td>
                                            <td align="center" width="50%"><b><?=$venta->Nombre?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td align="center" width="50%"><b><?=$venta->eMail1?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Telefonos:</td>
                                            <td align="center" width="50%"><b><?=$venta->Telefonos?></b></td>
                                        </tr>
                                        <tr>
                                            <td>RFC:</td>
                                            <td align="center" width="50%"><b><?=$venta->RFC?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Total a cobrar:</td>
                                            <td align="center" width="50%"><b style="color:red;">
                                                    <?=number_format($venta->VentaTotal,2,'.',",")?>
                                                    (<?=$venta->MonedaV33?>)</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script src="../src/vendors/openpay/openpay.js"></script>