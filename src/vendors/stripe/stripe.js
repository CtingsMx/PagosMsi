const pk = document.getElementById('pk').value;
console.log(pk);
const stripe = Stripe(pk);
const pedido = document.getElementById("pedido").value;

const elements = stripe.elements();
const cardElement = elements.create("card");
cardElement.mount("#card-element");

const cardholderName = document.getElementById("cardholder-name");
const form = document.getElementById("payment-form");

form.addEventListener("submit", async (ev) => {
  ev.preventDefault();
  const { paymentMethod, error } = await stripe.createPaymentMethod(
    "card",
    cardElement,
    { billing_details: { name: cardholderName.value } }
  );
  if (error) {
    // Show error in payment form
  } else {
    // Send paymentMethod.id to your server (see Step 2)
    const response = await fetch("./stripe/revisaDatos", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ payment_method_id: paymentMethod.id }),
    });

    const json = await response.json();

    // Handle server response (see Step 3)
    handleInstallmentPlans(json);
  }
});

const selectPlanForm = document.getElementById("installment-plan-form");
const select = document.getElementById("immediate-plan");
let availablePlans = [];

const handleInstallmentPlans = async (response) => {
  if (response.error) {
    // Show error from server on payment form
  } else {
    // Store the payment intent ID.
    document.getElementById("payment-intent-id").value = response.intent_id;
    availablePlans = response.available_plans;

    var formatter = new Intl.NumberFormat("es-MX", {
      style: "currency",
      currency: "MXN",
    });

    // Show available installment options
    availablePlans.forEach((plan, idx) => {
      if (idx < 2) {

        const option = document.createElement('option');
        const valor = idx;
        option.value = valor;
        option.text = `${plan.count} Meses`;
        select.appendChild(option);
      
        /*ANTERIOR FORMA
        const newInput = document.getElementById("immediate-plan").cloneNode();
        newInput.setAttribute("value", idx);
        newInput.setAttribute("id", "");
        const label = document.createElement("label");
        label.appendChild(newInput);
        label.appendChild(
          document.createTextNode(`${plan.count} ${plan.interval}s`)
        );

        selectPlanForm.appendChild(label);
        */
      }
    });

    document.getElementById("details").hidden = true;
    document.getElementById("plans").hidden = false;
  }
};

const confirmButton = document.getElementById("confirm-button");

confirmButton.addEventListener("click", async (ev) => {
  const selectedPlanIdx = select.value;
  console.log(selectedPlanIdx);
  const selectedPlan = availablePlans[selectedPlanIdx];
  const intentId = document.getElementById("payment-intent-id").value;
  const response = await fetch("./stripe/confirmarPago", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      payment_intent_id: intentId,
      selected_plan: selectedPlan,
      pedido,
    }),
  });

  const responseJson = await response.json();

  console.log(response);

  // Show success / error response.
  document.getElementById("plans").hidden = true;
  document.getElementById("result").hidden = false;

  var message;
  if (responseJson.status === "succeeded" && selectedPlan !== undefined) {
    message = `Pago Realizado! Se realizo el pago a :${selectedPlan.count} ${selectedPlan.interval}`;
  } else if (responseJson.status === "succeeded") {
    message = "Pago Realizado! Tu pago se realizó en una sola excibición!";
  } else {
    message = "Uh oh! Algo salio mal.";
  }

  document.getElementById("status-message").innerText = message;
});
