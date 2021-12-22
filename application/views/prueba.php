<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"
        integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous">
    </script>

    <link href="<?=base_url()?>src/vendors/stripe/stripe.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./src/js/jquery.js"></script>


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
                            <div id="plans" class="form-group">

                                <h4>Planes Disponibles con esta tarjeta</h4>
                                <br />
                                <form id="installment-plan-form">
                                    <label for="inmediate-plan">
                                        Seleccione las Parcialidades de pago
                                    </label>
                                    <select id="immediate-plan" name="installment_plan"
                                        class="form-control input-large">
                                        <option value="-1">Una Sola Excibición</option>
                                    </select>

                                    <div class="col-md-12 center" align="center" style="margin-top: 30px;">

                                        <button class=" form-control btn btn-outline-primary btn-lg btn-block col-md-12"
                                            id="confirm-button" align="center">
                                            Confirmar Pago
                                        </button>
                                    </div>


                                </form>
                                <br />


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
<!--
<script src="<?=base_url()?>src/vendors/stripe/stripe.js"></script>

-->

<script>
const selectPlanForm = document.getElementById("installment-plan-form");
const select = document.getElementById("immediate-plan");

let idx = 0;

(() => {
    do {
        const option = document.createElement('option');
        const valor = idx;
        option.value = valor;
        option.text = `${valor} Meses`;
        select.appendChild(option);
        idx++;
    } while (idx < 2);
})();
</script>

</html>