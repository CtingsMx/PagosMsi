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
                            <input Type="hidden" value="" name="pedido" id="pedido">
                            <input type="hidden" value="<?php echo $pk ?> " id="pk" name="pk">

                            <div id="table-responsive">
                                <table class="table cart" id='resumenCompra'>
                                </table>

                                <div class="row pull-right">
                                    <button class="btn btn-outline-danger btn-block text-center mt-3 " type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
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


    <div class="row justify-content-md-center mt-3">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pasarela de Pagos</h5>


                    <form action="./datosPagos" method="POST" id="payment-form">
                        <input type="hidden" name="token_id" id="token_id">
                        <div class="form-floating mb-3">
                            <input type="text" 
                                    class="form-control" 
                                    id="name" 
                                    placeholder="Como aparece en la tarjeta"
                                    autocomplete="off" 
                                    data-openpay-card="holder_name">
                            
                                    <label for="name">Nombre del titular</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="cardNumber" autocomplete="off"
                                data-openpay-card="card_number">
                            <label for="cardNumber">Número de tarjeta</label>
                        </div>






                        <label>Fecha de expiración</label>
                        <input type="text" placeholder="Mes" data-openpay-card="expiration_month">
                        <input type="text" placeholder="Año" data-openpay-card="expiration_year">
                        <label>Código de seguridad</label>
                        <input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2">

                        <div class="openpay">
                            <div class="logo">Transacciones realizadas vía:</div>
                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256
                                bits</div>
                        </div>



                        <a class="btn btn-success" id="pay-button">Pagar</a>
                </div>
            </div>
        </div>
        </form>

    </div>
</div>



</div>
</div>

</div>
</div>

</div>


<script src="../src/js/functions.js"></script>
<script src="../src/vendors/openpay/openpay.js"></script>