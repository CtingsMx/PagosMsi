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

                        <div id="table-responsive">
                        

                        <table class="table cart" id='resumenCompra'>
                        </table>     
                        
                        </div>

                            <!--<div class="table-responsive">

                                <input Type="hidden" value="" name="pedido" id="pedido">
                                <input type="hidden" value="<?php echo $pk?> " id="pk" name="pk">
                                <hr />
                                <table class="table cart">
                                    <tbody>
                                        <tr>
                                            <td># Pedido:</td>
                                            <td align="center" width="50%"><b><span id="pedido"></span></b></td>
                                        </tr>
                                        <tr>
                                            <td>Sucursal:</td>
                                            <td align="center" width="50%"><b> <span> </b></td>
                                        </tr>
                                        <tr>
                                            <td>Cliente:</td>
                                            <td align="center" width="50%"><b></b></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td align="center" width="50%"><b></b></td>
                                        </tr>
                                        <tr>
                                            <td>Telefonos:</td>
                                            <td align="center" width="50%"><b></b></td>
                                        </tr>
                                        <tr>
                                            <td>RFC:</td>
                                            <td align="center" width="50%"><b></b></td>
                                        </tr>
                                        <tr>
                                            <td>Total a cobrar:</td>
                                            <td align="center" width="50%"><b style="color:red;">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="../src/js/functions.js"></script>
<script src="../src/vendors/openpay/openpay.js"></script>