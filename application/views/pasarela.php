<!doctype html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link href="<?=base_url('src/vendors/openpay/style.css')?>" rel="stylesheet" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <script type="text/javascript">
    

    /*
    $(document).ready(function() {

        OpenPay.setId('mex0qnhtpq3m0yvkl3sa');
        OpenPay.setApiKey('pk_1b9a4ef755b8431c91824246ae34f55b');
        OpenPay.setSandboxMode(true);
        //Se genera el id de dispositivo
        var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

        $('#pay-button').on('click', function(event) {
            event.preventDefault();
            $("#pay-button").prop("disabled", true);
            OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
        });

        var sucess_callbak = function(response) {
            var token_id = response.data.id;
            console.log("Su token es " + token_id);
            $('#token_id').val(token_id);
            // $('#payment-form').submit();

            var data = $("#payment-form").serializeArray();



            $.ajax({
                type: 'POST', //aqui puede ser igual get
                url: './datosPagos', //aqui va tu direccion donde esta tu funcion php
                data: data, //aqui tus datos
            });
        }

        var error_callbak = function(response) {
            var desc = response.data.description != undefined ? response.data.description : response
                .message;
            alert("ERROR [" + response.status + "] " + desc);
            $("#pay-button").prop("disabled", false);
        };

    });
    */
    </script>


</head>

<body>
    <div class="bkng-tb-cntnt">
        <div class="pymnts">
            <form action="./datosPagos" method="POST" id="payment-form">
                <input type="hidden" name="token_id" id="token_id">
                <div class="pymnt-itm card active">
                    <h2>Tarjeta de crédito o débito</h2>
                    <div class="pymnt-cntnt">
                        <div class="card-expl">
                            <div class="credit">
                                <h4>Tarjetas de crédito</h4>
                            </div>
                            <div class="debit">
                                <h4>Tarjetas de débito</h4>
                            </div>
                        </div>
                        <div class="sctn-row">
                            <div class="sctn-col l">
                                <label>Nombre del titular</label><input type="text"
                                    placeholder="Como aparece en la tarjeta" autocomplete="off"
                                    data-openpay-card="holder_name">
                            </div>
                            <div class="sctn-col">
                                <label>Número de tarjeta</label><input type="text" autocomplete="off"
                                    data-openpay-card="card_number">
                            </div>
                        </div>
                        <div class="sctn-row">
                            <div class="sctn-col l">
                                <label>Fecha de expiración</label>
                                <div class="sctn-col half l"><input type="text" placeholder="Mes"
                                        data-openpay-card="expiration_month"></div>
                                <div class="sctn-col half l"><input type="text" placeholder="Año"
                                        data-openpay-card="expiration_year"></div>
                            </div>
                            <div class="sctn-col cvv"><label>Código de seguridad</label>
                                <div class="sctn-col half l"><input type="text" placeholder="3 dígitos"
                                        autocomplete="off" data-openpay-card="cvv2"></div>
                            </div>
                        </div>
                        <div class="openpay">
                            <div class="logo">Transacciones realizadas vía:</div>
                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                        </div>
                        <div class="sctn-row">

                            <div class="alert alert-danger" role="alert"
                                style="<?php echo (!isset($_GET['error'])) ? "display:none" : "" ?>" id="errorOpenpay">
                                <?php if (isset($_GET['error'])) {
    echo "Su tarjeta fue declinada y no se pudo procesar el pago.";
}
?>
                            </div>


                            <a class="button rght" id="pay-button">Pagar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>