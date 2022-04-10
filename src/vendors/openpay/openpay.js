$(document).ready(function() {

    OpenPay.setId('mex0qnhtpq3m0yvkl3sa');
    OpenPay.setApiKey('pk_1b9a4ef755b8431c91824246ae34f55b');
    OpenPay.setSandboxMode(true);
    //Se genera el id de dispositivo
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

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
                'Favor de completar tú información, recuerda que la tarjeta debe ser de 16 dígitos y sin espacios, además debes capturar la fecha de expiración y tu código de seguridad.'
                );
        } else if (response.status >= 1000 && esponse.status <= 1025) {
            $("#errorOpenpay").show().html('Hubo un problema al intentar procesar tu pago.');
        } else {
            $("#errorOpenpay").show().html(
                'Favor de completar tú información, recuerda que la tarjeta debe ser de 16 dígitos y sin espacios, además debes capturar la fecha de expiración y tu código de seguridad.'
                );
        }
        $("#pay-button").prop("disabled", false);
    };

});