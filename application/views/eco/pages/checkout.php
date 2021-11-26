<?php

$stripeKeys = STRIPE_KEYS; //llaves de Stripe

?>

<script>
    function markPlan(selectedPlanIdx) {
        $('.alert.alert-danger').addClass("hidden");
        document.selectedPlan = selectedPlanIdx;
        $('.cta-msi').removeClass('selected');
        $('.cta-msi[data-idx="' + selectedPlanIdx + '"]').addClass('selected');
    }


    function buyNow() {
        $('.alert.alert-danger').addClass("hidden");
        if (document.selectedPlan !== false && document.selectedPlan !== undefined && document.selectedPlan !== null) {
            $('.waiting-screen small span').html('Un momento, el pago está siendo procesado.');
            $('.waiting-screen').removeClass('hidden');

            const selectedPlan = document.availablePlans[document.selectedPlan];
            const intentId = document.getElementById('payment-intent-id').value;

            fetch('<?= base_url() ?>confirmarPago', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_intent_id: intentId,
                        selected_plan: selectedPlan,
                    }),
                }).then(r => r.json())
                .then(responseJson => {
                    var success;
                    var plan = "";




                    if (responseJson.status === "succeeded" && selectedPlan !== undefined) {
                        $('.waiting-screen small span').html(
                            '¡Gracias! Tu pago fue diferido a: ${ selectedPlan.count } MSI');
                        plan = "plan=" + selectedPlan.count;
                    } else if (responseJson.status === "succeeded") {
                        $('.waiting-screen small span').html('¡Gracias! Tu pago se realizó a una sola excibición!');
                    } else {
                        $('.waiting-screen').addClass('hidden');
                        $('.alert.alert-danger').html(
                            "Lo sentimos, el banco emisor ha rechazado la operación con el siguiente mensaje:<br/><b>" +
                            responseJson.error_message +
                            "</b><br/><br/>El sitio redireccionará en 5 segundos para permitirle reintentar.");
                        $('.alert.alert-danger').removeClass("hidden");
                        /*
                        setTimeout(() => {
                            location.reload();
                        }, 8000);
                        */
                    }

                    if (responseJson.status === "succeeded") {
                        location.href = "<?= base_url() ?>exito/" + responseJson.idPedido + "?" + plan;
                    }
                });
        } else {
            $('.waiting-screen').addClass('hidden');
            $('.alert.alert-danger').html("Es necesario seleccionar un plan de pago.");
            $('.alert.alert-danger').removeClass("hidden");
        }
    }
</script>
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

<!-- Steps -->
<?php $this->load->view("eco/pages/cart-steps", ["step" => 3]); ?>

<div class="page-content cart-checkout">
    <div class="waiting-screen hidden">
        <small>
            <i class="fa fa-circle-notch fa-spin"></i>
            <span></span>
        </small>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="<?= base_url() ?>datos_cliente">&laquo; Regresar a resumen</a>
                        <h1>MÉTODO DE PAGO</h1>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form id="payment-form">
                            <div class="form-group">
                                <label>Nombre del Titular:</label>
                                <input type="text" id="cardholder-name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Datos de Tarjeta:</label>
                                <div id="card-element"></div>
                            </div>
                            <button id="card-button">APLICAR TARJETA Y VERIFICAR MENSUALIDADES</button>
                        </form>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form id="installment-plan-form" class="hidden">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label style="text-transform: unset; margin-bottom:2px;"><i class="fas fa-check" style="color: #159b7e;"></i> Selecciona la modalidad de pago que
                                        prefieras</label>
                                    <label style="text-transform: unset;"><i class="fas fa-check" style="color: transparent;"></i>(Opciones disponibles para la tarjeta
                                        presentada):</label>
                                </div>
                            </div>
                            <div id="load-msi">
                                <label class="cta-msi" data-idx="-1" onclick="markPlan(-1)">
                                    <div class="row">
                                        <div class="col-xs-6" style="display:flex; align-items: center; min-height:60px; flex-direction: column;">
                                            <div class="plan">1 PAGO</div>
                                        </div>
                                        <div class="col-xs-6">
                                            <b>Pago único:</b>
                                            <big>$<?php echo number_format($cuenta['total'], 2); ?></big>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <input id="payment-intent-id" type="hidden" />
                        </form>
                        <div class="alert alert-danger hidden" style="margin-top:20px;" role="alert"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <?php $this->load->view("eco/pages/cart-summary", $cuenta); ?>
                <button type="button" class="buy-now" onclick="buyNow()"><i class="fas fa-clipboard-check"></i>
                    COMPRAR</button>
            </div>
        </div>
    </div>

</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('<?php echo $stripeKeys['clientside'][STRIPE_MODE]; ?>');
    var elements = stripe.elements();
    var cardElement = elements.create('card', {});
    cardElement.mount('#card-element');
    var cardholderName = document.getElementById('cardholder-name');
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(ev) {
        ev.preventDefault();

        $('.waiting-screen small span').html('Verificando mensualidades disponibles');
        $('.waiting-screen').removeClass('hidden');

        $('.alert.alert-danger').addClass("hidden");

        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: cardholderName.value
            }
        }).then(function(result) {
            if (result.error) {
                $('.alert.alert-danger').html(result.error.message);
                $('.alert.alert-danger').removeClass("hidden");
            } else {

                fetch('<?= base_url() ?>revisaDatos', {
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

            $('.waiting-screen').addClass('hidden');
        });
    });
    const selectPlanForm = document.getElementById('installment-plan-form');
    document.availablePlans = [];

    // Aquí se manejan los plazos disponibles para la tarjeta que se presentó:
    const handleInstallmentPlans = async (response) => {
        if (response.error) {
            $('.alert.alert-danger').html(result.error.message);
            $('.alert.alert-danger').removeClass("hidden");
        } else {
            // Store the payment intent ID.
            document.getElementById('payment-intent-id').value = response.intent_id;
            document.availablePlans = response.available_plans;

            var formatter = new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN',
            });

            // Show available installment options
            document.availablePlans.forEach((plan, idx) => {
                if (idx < 2) {
                    $('#load-msi').append(`
                        <label class="cta-msi" data-idx="${idx}" onclick="markPlan(${idx})">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="plan">${plan.count} ${(plan.count > 1) ? 'MESES' : 'PAGO'} </div>
                                    <div class="msi">sin intereses</div>
                                </div>
                                <div class="col-xs-6">
                                    <b>Mensualidad:</b>
                                    <big>${formatter.format(<?php echo $cuenta['total'] ?> / plan.count)}</big>
                                </div>
                            </div>
                        </label>
                    `);
                }
            });

            $('#installment-plan-form').removeClass("hidden");
        }
    };
</script>