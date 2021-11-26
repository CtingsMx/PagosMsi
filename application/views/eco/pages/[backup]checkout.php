<?
$cantProductos = 0;

$sub = 0; //die(var_dump($carrito)); 
$total = round(number_format($carrito[0]['precio'] * 1.16, 2, '.', ''));;
?>
<section id="page-title">
    <div class="container clearfix" align="center">
        <h1>Checkout</h1>
        <p class="mbr-section-subtitle lead">Verifique los datos y proceda al pago</p>
    </div>
</section>

<!-- Steps -->
<?php $this->load->view("eco/pages/cart-steps", ["step" => 3]); ?>

<div class="page-content cart-checkout">
    <div class="container">

        <!-- Datos de Cliente -->
        <div class="row">
            <div class="col-xs-12">
                <br/><br/>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="6" style="background-color: #d6d6d6;">Datos del cliente</th>
                        </tr>
                        <tr>
                            <th> Cliente: </th>
                            <td> <?= $usuario->aPaterno ?> <?= $usuario->aMaterno ?> <?= $usuario->nombre ?> </td>
                            <th> Teléfono Personal: </th>
                            <td><?= $usuario->celular ?></td>
                            <th> Teléfono Particular: </th>
                            <td><?= $usuario->telefono ?></td>
                        </tr>
                        <tr>
                            <th> Correo Electrónico: </th>
                            <td colspan="5"> <?= $usuario->correo ?> </td>
                        </tr>
                        <tr>
                            <th> Dirección: </th>
                            <td> <?= $usuario->calle ?> #<?= $usuario->numExterno ?>
                            <? if (isset($usuario->numInterno)) { ?> Int. <?= $usuario->numInterno ?>
                            <? } ?>
                            <? if (isset($usuario->edificio)) { ?> Edificio <?= $usuario->edificio ?>
                            <? } ?>
                            </td>
                            <th>Colonia:</th>
                            <td> <?= $usuario->colonia ?> </td>
                            <th>Ciudad:</th>
                            <td> <?= $usuario->ciudad ?> </td>
                        </tr>
                        <tr>
                            <th> Estado: </th>
                            <td> <?= $usuario->estado ?></td>
                            <th> Código Postal: </th>
                            <td> <?= $usuario->cp ?></td>
                            <th> Referencias: </th>
                            <td> <?= $usuario->referencias ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detalle de Pedido -->
        <? if ($carrito != 0) { ?>
            <div class="row">
                <div class="col-xs-12">
                    <br/><br/>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="100%" style="background-color: #d6d6d6;">Detalle de Pedido</th>
                                </tr>
                                <tr>
                                    <th>IMAGEN</th>
                                    <th>CONCEPTO</th>
                                    <th>COLOR</th>
                                    <th>PRECIO UNITARIO</th>
                                    <th>CANTIDAD</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($carrito as $key) {
                                    $subtotal = $key['cantidad'] * $key['precio'];
                                    $cantProductos = $cantProductos + $key['cantidad'];
                                    $sub = $sub + $subtotal;
                                    $total = ($sub * 1.16);
                                ?>
                                    <tr>
                                        <td><img class="img-rounded" src="<?= base_url() ?>src/images/shop/<?= $key['foto'] ?>" alt="image" width="80" /></td>
                                        <td><?= $key['descripcion'] ?></td>
                                        <td><?= $key['color'] ?></td>
                                        <td>$ <?= number_format($key['precio'], '2', ',', ' ') ?></td>
                                        <td><?= $key['cantidad'] ?></td>
                                        <td>$ <?= number_format($subtotal, '2', ',', ' ') ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>


        <!-- Resumen de Compra -->
        <div class="row">
            <div class="col-xs-12">
                <br/><br/>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" style="background-color: #d6d6d6;">Resumen de Compra</th>
                    </tr>
                    <tr>
                        <td>Cantidad de productos:</td>
                        <td align="right" width="50%"><b><?= $cantProductos ?></b></td>
                    </tr>
                    <tr>
                        <td>Subtotal:</td>
                        <td align="right">$ <?= number_format($sub, '2', ',', ' ') ?></td>
                    </tr>
                    <tr>
                        <td>Envío </td>
                        <td align="right"> Envío gratuito (MEX) </td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td align="right">$ <b><?= number_format($sub, '2', ',', ' ') ?></b></td>
                    </tr>
                </table> 
            </div>
        </div>


        <!-- Requiero Factura -->
        <div class="row">
            <div class="col-xs-12">
                <div class="form-check">
                    <label class="form-check-label" for="factura"><input type="checkbox" name="factura" id="factura"> Requiero factura</label>
                </div>      
            </div>
        </div>    
        <div class="row" id="datos">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" required name="nombre" id="nombre" value=" <?= $usuario->nombre ?> <?= $usuario->aPaterno ?> <?= $usuario->aMaterno ?>" placeholder="Nombre:">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control required" required name="rfc" id="rfc" placeholder="RFC:">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" class="form-control" value="<?= $usuario->correo ?>" required name="correo" id="correo" placeholder="Correo:">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" required name="direccion" id="direccion" value="" placeholder="Dirección de Facturación:">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button style="margin:-2px 0px 0px 0px;" id="btnGuardar" onclick="guardarDatos();" class="button button-3d button-light"> Guardar</button>
                </div>
            </div>                                                
        </div>    

        <!-- Botones de Pago -->
        <div class="row bottommargin">
            <div class="col-xs-6">
                <a href="<?= base_url() ?>carrito" class="button button-3d button-black"> Regresar </a>
            </div>
            <div class="col-xs-6">
                <input type="button" class="button button-3d" data-toggle="modal" data-target="#exampleModal" value="Pagar">
            </div>
        </div>

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="background-color: #f7f8f9;">
                <div class="row">
                    <div align="center" class="col-md-12">
                        <img src="<?= base_url() ?>src/images/logo.png" width="50%">
                    </div>


                    <div class="col-md-2"></div>

                    <div id="details" align="center" class="col-md-8">
                        <p><b>Pago con tarjeta de crédito o debito.</b></p>

                        <div id="lblMessage" hidden>
                            <div class="alert alert-warning">
                                <i class="icon-warning-sign"></i><strong>Atención!</strong> <span id="message"></span>
                            </div>
                        </div>

                        <input id="cardholder-name" type="text" class="form-control" placeholder="Nombre del Titular">
                        <br>
                        <!-- placeholder for Elements -->
                        <form id="payment-form">
                            <div id="card-element"></div>
                            <br><br>

                            <button id="card-button" class="btn btn-success btn-block">Pagar $<?= number_format($sub, '2', ',', ' ') ?> MNX</button>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>

                    <div id="plans" align="center" class="col-md-8" hidden>
                        <p><b>Seleccionar parcilidades de pago</b></p>

                        <div id="lblMessage1" hidden>
                            <div class="alert alert-warning">
                                <i class="icon-warning-sign"></i><strong>Atención!</strong> <span id="message1"></span>
                            </div>
                        </div>


                        <form id="installment-plan-form">
                            <label><input id="immediate-plan" class="form-control" type="radio" name="installment_plan" value="-1" /> 1 Pago </label>
                            <input id="payment-intent-id" type="hidden" />
                        </form>
                        <button id="confirm-button" class="btn btn-success btn-block">Confirmar Parcialidades</button>
                    </div>

                    <div id="result" align="center" class="col-md-8" hidden>
                        <p id="status-message"></p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="location.reload();" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>




<script src="https://js.stripe.com/v3/"></script>
<!--
<script type="text/javascript">
    function pay() {

        var stripe = Stripe('pk_live_tIWbfEk2yLICEnkKUmDC8oRD007x05PnTK');


        stripe.redirectToCheckout({

            sessionId: '<?= $sesion ?>'
        }).then(function(result) {

        });
    }
</script>
-->


<script>
    var stripe = Stripe('pk_live_tIWbfEk2yLICEnkKUmDC8oRD007x05PnTK');

    var elements = stripe.elements();
    var style = {
        base: {
            border: "thick solid #0000FF",
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var cardElement = elements.create('card', {
        style: style
    });
    cardElement.mount('#card-element');
    var cardholderName = document.getElementById('cardholder-name');
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(ev) {
        ev.preventDefault();
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: cardholderName.value
            }
        }).then(function(result) {
            if (result.error) {
                // Show error in payment form
                document.getElementById('lblMessage').hidden = false;
                document.getElementById('message').innerHTML = result.error.message;
                setTimeout(function() {
                    document.getElementById('lblMessage').hidden = true;
                }, 3000);

            } else {
                // Otherwise send paymentMethod.id to your server (see Step 2)
                fetch('<?= base_url() ?>collect_details', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method_id: result.paymentMethod.id,
                    })
                }).then(function(result) {
                    // Handle server response (see Step 3)
                    result.json().then(function(json) {
                        handleInstallmentPlans(json);
                    })
                });
            }
        });
    });
    const selectPlanForm = document.getElementById('installment-plan-form');
    let availablePlans = [];

    const handleInstallmentPlans = async (response) => {
        if (response.error) {
            // Show error from server on payment form
            document.getElementById('lblMessage1').hidden = false;
            document.getElementById('message1').innerHTML = result.error.message;
            setTimeout(function() {
                document.getElementById('lblMessage1').hidden = true;
            }, 3000);
        } else {

            // Store the payment intent ID.
            document.getElementById('payment-intent-id').value = response.intent_id;
            availablePlans = response.available_plans;
            // Show available installment options
            availablePlans.forEach((plan, idx) => {
                if (idx < 2) {

                    const newInput = document.getElementById('immediate-plan').cloneNode();
                    newInput.setAttribute('value', idx);
                    newInput.setAttribute('id', '');
                    newInput.setAttribute('class', 'form-control')
                    const label = document.createElement('label');
                    label.appendChild(newInput);
                    label.appendChild(
                        document.createTextNode(`${plan.count} meses `),
                    );
                    selectPlanForm.appendChild(label);
                }

            });

            document.getElementById('details').hidden = true;
            document.getElementById('plans').hidden = false;
        }
    };
    const confirmButton = document.getElementById('confirm-button');

    confirmButton.addEventListener('click', async (ev) => {
        const selectedPlanIdx = selectPlanForm.installment_plan.value;
        const selectedPlan = availablePlans[selectedPlanIdx];
        const intentId = document.getElementById('payment-intent-id').value;
        const response = await fetch('<?= base_url() ?>confirmarPago', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                payment_intent_id: intentId,
                selected_plan: selectedPlan,
            }),
        });

        const responseJson = await response.json();

        // Show success / error response.
        document.getElementById('plans').hidden = true;
        document.getElementById('result').hidden = false;

        var message;
        if (responseJson.status === "succeeded" && selectedPlan !== undefined) {
            message = `Exito, tu pago se difirió a :${ selectedPlan.count } ${ selectedPlan.interval }`;
        } else if (responseJson.status === "succeeded") {
            message = "Exito! tu pago se realizó a una sola excibición!";
        } else {
            message = "Uh oh! Algo salio mal: " + responseJson.error_message;
        }

        if (responseJson.status === "succeeded")
        {
            setTimeout(function() {
                location.href ="<?=base_url()?>exito/"+responseJson.idPedido;
                }, 3000);
            
        }

        document.getElementById("status-message").innerText = message;
    });

</script>

<script>
    function guardarDatos() {
        form = $("#facturacion").serializeArray();


        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?= base_url() ?>datos_factura",
            data: form,
        }).done(function(respuesta) {
            console.log(respuesta);
            alertify
                .alert("PLADOS", respuesta, function() {
                    alertify.message('OK');
                });
        });

    }
</script>

<script>
    $(function() {
        $("#datos").hide('fast');
    });

    function on() {
        $("#datos").show('fast');
    }

    function off() {
        $("#datos").hide('fast');
    }

    var checkbox = document.getElementById('factura');
    checkbox.addEventListener("change", comprueba, false);

    function comprueba() {
        if (checkbox.checked) {
            on();
        } else {
            off();
        }
    }
</script>