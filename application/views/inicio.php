<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
  
    <link href="<?=base_url()?>src/vendors/stripe/stripe.css" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>


</head>

<body style="background-color:#e0e0e0">
    <div class=" container">


        <div class="row mt-4">
            <div class="col-md-12 text-center" style="background-color: #004072">
                <img src="https://kober.com.mx/images/logo-white.svg" width="50%" />
                <h2 id="lblTitulo" style="color:#ffffff">Portal de Pagos</h2>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4" style="margin-top: 50px;">
                <div class="row" style="background-color: #fff; border-radius:15px;">
                    <div class="table-responsive">
                        <h4 class="text-center" style="margin-top: 15px;">Resumen de Compra</h4>
                        <input Type="text" value="<?=$venta[0]->ID?>" name="pedido" id="pedido">
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
                                    <td align="center" width="50%"><b style="color:red;"><?=$venta[0]->VentaTotal?> (<?=$venta[0]->MonedaV33?>)</b></td>
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
                                <input id="cardholder-name" type="text" placeholder="NOMBRE DE TITULAR DE TARJETA" class="form-control">
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


                            <div id="plans" hidden>
                                <h4>Planes Disponibles con esta tarjeta</h4>
                                <br />

                                <form id="installment-plan-form">
                                    <label><input id="immediate-plan" type="radio" name="installment_plan" value="-1" /><br />  Una sola Excibición</label>
                                    <input id="payment-intent-id" type="hidden" />
                                </form>
                                <br />

                                <button class="btn btn-outline-primary btn-lg btn-block col-md-12" id="confirm-button"> Confirmar Pago </button>


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

    <!--
    <form action="/Payouts/CreateCheckoutSession" method="POST">
        <button type="submit">Checkout</button>
    </form>
        -->
</body>
    <script src="<?=base_url()?>src/vendors/stripe/stripe.js"></script>

</html>