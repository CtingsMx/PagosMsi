<div class="row">

    <div class="col-md-4" style="margin-top: 50px;">
        <div class="row" style="background-color: #fff; border-radius:15px;">
            <div class="table-responsive">
                <h4 class="text-center" style="margin-top: 15px;">Resumen de Compra</h4>
                <input Type="hidden" value="<?=$venta[0]->ID?>" name="pedido" id="pedido">
                <hr />
                <table class="table cart">
                    <tbody>
                        <tr>
                            <td># Pedido:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->ID?></b></td>
                        </tr>
                        <tr>
                            <td>Sucursal:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->Sucursal?></b></td>
                        </tr>
                        <tr>
                            <td>Cliente:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->Nombre?></b></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->eMail1?></b></td>
                        </tr>
                        <tr>
                            <td>Telefonos:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->Telefonos?></b></td>
                        </tr>
                        <tr>
                            <td>RFC:</td>
                            <td align="center" width="50%"><b><?=$venta[0]->RFC?></b></td>
                        </tr>
                        <tr>
                            <td>Total a cobrar:</td>
                            <td align="center" width="50%"><b style="color:red;">
                                    <?=number_format($venta[0]->VentaTotal,2,'.',",")?> (<?=$venta[0]->MonedaV33?>)</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-1">
    </div>

    <div class="col-md-7 pull-right" style="margin-top: 50px;">
        <div class="row" style="background-color: #fff; border-radius:15px;">
            <div class="table-responsive">
                <h4 class="text-center" style="margin-top: 15px;">Pasarela de Pagos</h4>
                <hr />

                <div class="row">
                    <div id="details" class="form-group">
                        <input id="cardholder-name" type="text" placeholder="NOMBRE DE TITULAR DE TARJETA"
                            class="form-control">
                        <br />
                        <!-- placeholder for Elements -->
                        <form id="payment-form" class="mt-4">
                            <div class="col-md-12">
                                <div id="card-element"></div>
                            </div>
                            <br />

                            <button class="btn btn-outline-primary btn-lg btn-block col-md-12" id="card-button">
                                Realizar Pago
                            </button>
                        </form>
                    </div>


                    <div id="plans" class="form-group" hidden>
                        <h4>Planes Disponibles con esta tarjeta</h4>
                        <br />
                        <form id="installment-plan-form">
                            <label for="inmediate-plan">
                                Seleccione las Parcialidades de pago
                            </label>
                            <select id="immediate-plan" name="installment_plan" class="form-control input-large">
                                <option value="-1">Una Sola Excibición</option>
                            </select>

                            <input id="payment-intent-id" type="hidden" />

                            <div class="col-md-12 center" align="center" style="margin-top: 30px;">

                                <button class=" form-control btn btn-outline-primary btn-lg btn-block col-md-12"
                                    id="confirm-button" align="center">
                                    Confirmar Pago
                                </button>
                            </div>


                        </form>
                        <br />

                        <button class="btn btn-outline-primary btn-lg btn-block col-md-12" id="confirm-button">
                            Confirmar Pago </button>
                    </div>
                    <div id="result" hidden>
                        <h3 class="text-center" id="status-message"></h3>
                    </div>
                </div>

            </div>

        </div>
        <br /><br />
    </div>

</div>



</div>
</body>
<script src="<?=base_url()?>src/vendors/stripe/stripe.js"></script>

</html>