<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="<?=base_url()?>src/vendors/stripe/stripe.css" rel="stylesheet" />
    <script src="https://js.stripe.com/v3/"></script>


</head>

<body>
    <div id="details">
        <input id="cardholder-name" type="text" placeholder="Cardholder name">
        <!-- placeholder for Elements -->
        <form id="payment-form">
            <div id="card-element"></div>
            <button id="card-button">Next</button>
        </form>
    </div>


    <div id="plans" hidden>
        <form id="installment-plan-form">
            <label><input id="immediate-plan" type="radio" name="installment_plan" value="-1" />Immediate</label>
            <input id="payment-intent-id" type="hidden" />
        </form>
        <button id="confirm-button">Confirm Payment</button>
    </div>

    <div id="result" hidden>
        <p id="status-message"></p>
    </div>

</body>
<script src="<?=base_url()?>src/vendors/stripe/stripe.js"></script>

</html>