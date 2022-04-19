<div class="container mt-5">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 ">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?=base_url('enviarMensaje')?>">
                        <h2 class="text-center">Contactanos</h2>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" required name="nombre" id="nombre" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" required class="form-control" id="email"
                                placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" name="celular" id="celular" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="ciudad"  class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" required id="mensaje" name="mensaje" rows="3"></textarea>
                        </div>


                        <button type="submit" class="btn btn-blue btn-outline-primary pull-right">Enviar
                            Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-3 mt-3">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="row">
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">CENTRO DE DISTRIBUCION KOBER® CIUDAD DE
                            MÉXICO</strong> <br>
                        Abundio Martínez 221 <br>
                        Tel: <a href="tel:3323122971" class="color-black">
                            3323122971
                        </a> <br>
                        CDMX
                    </p>
                </div>
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">MUNDO KOBER® LEÓN</strong> <br>
                        Av. Guanajuato # 837 <br>
                        Tel: <a href="tel:4778592276" class="color-black">
                            4778592276
                        </a> <br>
                        Guanajuato
                    </p>
                </div>
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">MUNDO KOBER® GUADALAJARA</strong> <br>
                        Federalismo Sur No. 369 <br>
                        Tel: <a href="tel:3335873900" class="color-black">
                            3335873900
                        </a> <br>
                        Jalisco
                    </p>
                </div>
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">MUNDO KOBER® MONTERREY</strong> <br>
                        Moctezuma No. 1616 <br>
                        Tel: <a href="tel:8115115031" class="color-black">
                            8115115031
                        </a> <br>
                        Nuevo León
                    </p>
                </div>
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">PLANTA GDL</strong> <br>
                        Paseo del Norte 5605 <br>
                        Tel: <a href="tel:3323489329" class="color-black">
                            3323489329
                        </a> <br>
                        Jalisco
                    </p>
                </div>
                <div class="col">
                    <p class="color-black"><strong class="text-uppercase">MUNDO KOBER QUERETARO</strong> <br>
                        PROL. Corregidora sur #61 <br>
                        Tel: <a href="tel:014422120143" class="color-black">
                            01 (442) 212-01-43
                        </a> <br>
                        Querétaro
                    </p>
                </div>
            </div>
        </div>
    </div>


</div>