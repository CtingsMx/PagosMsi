
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<script src="https://js.stripe.com/v3/"></script>

  
<script type="text/javascript">
  var stripe = Stripe('pk_test_NVhGAEKZmHWV3XJBFo4YdLCA00mxzgDIwD');


  stripe.redirectToCheckout({
  // Make the id field from the Checkout Session creation API response
  // available to this file, so you can provide it as parameter here
  // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
  	sessionId: '{{<?=$sessionId?>}}'
	}).then(function (result) {
  // If `redirectToCheckout` fails due to a browser or network
  // error, display the localized error message to your customer
  // using `result.error.message`.
});
</script>


</body>
</html>