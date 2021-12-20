<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
  
    <link href="<?=base_url()?>src/vendors/stripe/stripe.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script>


</head>

<body style="background-color:#e0e0e0">
    <div class=" container">


        <div class="row mt-4">
            <div class="col-md-12 text-center" style="background-color: #004072">
                <img src="https://kober.com.mx/images/logo-white.svg" width="50%" />
                <h2 id="lblTitulo" style="color:#ffffff">Portal de Pagos</h2>
            </div>
        </div>

     


