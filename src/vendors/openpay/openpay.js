$(document).ready(function() {

    var deviceSessionId;


   $('#btn-validar-pago').on('click',
       () => {

        const pk = $('#token_id').val();
        const merchant = $('#opMerchant').val();

           OpenPay.setId(merchant);
           OpenPay.setApiKey(pk);
           OpenPay.setSandboxMode(true);
           //Se genera el id de dispositivo
           deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

       });


    $('#pay-button').on('click', function(event) {
        event.preventDefault();
        cargandoModal();
        $("#errorOpenpay").hide().html('');
        $("#pay-button").prop("disabled", true);
        OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
    });

    var sucess_callbak = function(response) {
        var token_id = response.data.id;
        $('#token_id').val(token_id);
        $('#payment-form').submit();
    };

    var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response
        .message;
        if (response.status >= 2004 && response.status <= 3205) {
            $("#errorOpenpay").show().html(
                `<div class="alert alert-warning">
                    Datos incompletos: por favor ingresa los 16 digítos de tu tarjeta de crédito, la fecha de expiración y código de seguridad.
                </div>`
                );
        } else if (response.status >= 1000 && esponse.status <= 1025) {
            $("#errorOpenpay").show().html('Hubo un problema al intentar procesar tu pago.');
        } else {
            $("#errorOpenpay").show().html(
                `<div class="alert alert-warning">
                    ${desc}
                </div>`
                );
        }
        $("#pay-button").prop("disabled", false);
    };

});