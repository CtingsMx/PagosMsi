const stripe = Stripe('pk_test_51JPs4jHcWweoTFXWWWHI2yR5TU9qi4OApPXuhS3OrpddoVaKq4WgoObJfM3Gav7iyMucu5RhfA1hRwwvCd5bojxY00lKYkK3L6');
const pedido = document.getElementById("pedido").value;

const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount('#card-element');


const cardholderName = document.getElementById('cardholder-name');
const form = document.getElementById('payment-form');

form.addEventListener('submit', async (ev) => {
  ev.preventDefault();
  const {paymentMethod, error} = await stripe.createPaymentMethod(
    'card',
    cardElement,
    {billing_details: {name: cardholderName.value}},
  );
  if (error) {
    // Show error in payment form
  } else {
    // Send paymentMethod.id to your server (see Step 2)
    const response = await fetch('./stripe/revisaDatos', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({payment_method_id: paymentMethod.id}),
    });

    const json = await response.json();

    // Handle server response (see Step 3)
    handleInstallmentPlans(json);
  }
});

const selectPlanForm = document.getElementById('installment-plan-form');
let availablePlans = [];

const handleInstallmentPlans = async (response) => {
  if (response.error) {
    // Show error from server on payment form
  } else {
    // Store the payment intent ID.
    document.getElementById('payment-intent-id').value = response.intent_id;
    availablePlans = response.available_plans;

    var formatter = new Intl.NumberFormat('es-MX', {
      style: 'currency',
      currency: 'MXN',
  });

    // Show available installment options
    availablePlans.forEach((plan, idx) => {
      if (idx < 2) {
        $('#load-msi').append(`
            <label class="cta-msi" data-idx="${idx}" onclick="markPlan(${idx})">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="plan">${plan.count} ${(plan.count > 1) ? 'MESES' : 'PAGO'} </div>
                        <div class="msi">sin intereses</div>
                    </div>
                    <div class="col-xs-6">
                        <b>Mensualidad:</b>
                        <big>${formatter.format(500 / plan.count)}</big>
                    </div>
                </div>
            </label>
        `);
    }
    });

    document.getElementById('details').hidden = true;
    document.getElementById('plans').hidden = false;
  }
};



const confirmButton = document.getElementById('confirm-button');

confirmButton.addEventListener('click', async (ev) => {
  const selectedPlanIdx = selectPlanForm.installment_plan.value;
  const selectedPlan = availablePlans[selectedPlanIdx];
  const intentId = document.getElementById('payment-intent-id').value;
  const response = await fetch('./stripe/confirmarPago', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      payment_intent_id: intentId,
      selected_plan: selectedPlan,
      pedido
    }),
  });

  const responseJson = await response.json();

  console.log(response);

  // Show success / error response.
  document.getElementById('plans').hidden = true;
  document.getElementById('result').hidden = false;

  var message;
  if (responseJson.status === "succeeded" && selectedPlan !== undefined) {
    message = `Success! You made a charge with this plan:${
      selectedPlan.count
    } ${selectedPlan.interval}`;
  } else if (responseJson.status === "succeeded") {
    message = "Success! You paid immediately!";
  } else {
    message = "Uh oh! Something went wrong";
  }

  document.getElementById("status-message").innerText = message;
});

