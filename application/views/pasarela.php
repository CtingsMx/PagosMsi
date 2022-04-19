<div class="container">
    <div class="row justify-content-md-center mt-3">
        <div class="col-md-6">
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

                            <input type="hidden" value="" id="pk" name="pk">

                            <div id="table-responsive">
                                <table class="table cart" id='resumenCompra'>
                                </table>

                                <div class="row">
                                    <a class="btn btn-outline-info" onclick="ingresaVenta()">
                                    Reingresar Venta
                                </a>
                                    <button id="btn-validar-pago" hidden
                                        class="btn btn-outline-danger btn-block text-center mt-3 " type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne" onclick="getPasarela()">
                                        Validar Datos y proceder con el Pago
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-md-center mt-3" id="pasarela" hidden>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Pagar a Meses sin Intereses
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card-expl">
                            <div class="debit">
                            </div>
                        </div>
                    </div>

                    <form action="./validaFormulario" method="POST" id="payment-form">
                        <input type="hidden" name="token_id" id="token_id">
                        <input type="hidden" name="idPedido" id="idPedido">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Como aparece en la tarjeta" autocomplete="off"
                                data-openpay-card="holder_name">

                            <label for="name">Nombre del titular</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="cardNumber" autocomplete="off"
                                data-openpay-card="card_number" placeholder="16 digitos">
                            <label for="cardNumber">Número de tarjeta</label>
                        </div>

                        <div class="row">

                            <div class="form-floating mb-3 col-sm-6">
                                <input type="text" class="form-control" placeholder="Mes"
                                    data-openpay-card="expiration_month" placeholder="" id="month">
                                <label for="month">&nbsp; Mes de expiración</label>

                            </div>


                            <div class="form-floating mb-3 col-sm-6">
                                <input id="year" class="form-control" type="text" placeholder="Año"
                                    data-openpay-card="expiration_year">
                                <label for="year"> &nbsp; Año de Expiración</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-floating mb-3 col-sm-5">
                                <input type="text" placeholder="3 dígitos" class="form-control" id="ccv"
                                    autocomplete="off" data-openpay-card="cvv2">
                                <label>&nbsp; Código de seguridad</label>
                            </div>

                            <div class="form-floating col-sm-7 mb-5">
                                <select class="form-select" id="msi" name="msi"
                                    aria-label="Floating label select example">

                                    <option selected value="1">Una Sola Excibición</option>
                                    <option value="3">3 Meses Sin Intereses</option>
                                    <option value="6">6 Meses Sin Intereses</option>
                                </select>
                                <label for="msi">&nbsp; Parcialidades de Pago (MSI)</label>
                            </div>
                        </div>




                        <div class="d-grid gap-2 col-6 mx-auto mt-6">
                            <a class="btn btn-outline-danger btn-lg  " id="pay-button">Pagar </a>

                        </div>

                        <div class=" row mt-4">
                            <div class=" col openpay-logo pull-right">Transacciones realizadas vía: <img
                                    src="./src/images/openpay/openpay.png">
                            </div>
                            <div class="col openpay-shield">Tus pagos se realizan de forma segura con encriptación
                                de 256 bits

                            </div>
                        </div>

                </div>
            </div>
        </div>
        </form>

    </div>
</div>




<script src="./src/js/imask.js"></script>
<script src="./src/js/functions.js?v=3.2"></script>
<script src="./src/vendors/openpay/openpay.js"></script>