<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe extends CI_Controller
{

  /**
   * Get All Data from this method.
   *
   * @return Response
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->library("session");
    $this->load->helper('url');
  }

  /**
   * Get All Data from this method.
   *
   * @return Response
   */
  public function index()
  {
    $this->load->view('eco/stripe/index');
  }

  /**
   * Get All Data from this method.
   *
   * @return Response
   */
  public function payment()
  {
    require_once('application/libraries/stripe-php/init.php');

    $stripeSecret = 'sk_test_cNEnkPQ796OFqgwfXH2oBUyq00qKunHgZw';

    \Stripe\Stripe::setApiKey($stripeSecret);

    $stripe = \Stripe\Charge::create([
      "amount" => $this->input->post('amount'),
      "currency" => "usd",
      "source" => $this->input->post('tokenId'),
      "description" => "Test payment from tutsmake.com."
    ]);

    // after successfull payment, you can store payment related information into your database

    $data = array('success' => true, 'data' => $stripe);

    echo json_encode($data);
  }

  public function pasarela()
  {
    $this->load->view('eco/_head');
		$this->load->view('eco/_menu');
    $this->load->view('eco/stripe/index');
    $this->load->view('eco/_footer');
  }

  public function collect_details()
  {
    try {
      
      # vendor using composer
      require_once('application/libraries/stripe-php/init.php');
      $stripeSecret = 'sk_test_cNEnkPQ796OFqgwfXH2oBUyq00qKunHgZw';
      \Stripe\Stripe::setApiKey($stripeSecret);
      header('Content-Type: application/json');

      # retrieve json from POST body
      $json_str = file_get_contents('php://input');
      $json_obj = json_decode($json_str);

      $intent = Stripe\PaymentIntent::create([
        'payment_method' => $json_obj->payment_method_id,
        'amount' => '170000',
        'currency' => 'mxn',
        'payment_method_options' => [
          'card' => [
            'installments' => [
              'enabled' => true
            ]
          ]
        ],
      ]);
      echo json_encode([
        'intent_id' => $intent->id,
        'available_plans' => $intent->payment_method_options->card->installments->available_plans
      ]);
    } catch (\Stripe\Exception\CardException $e) {
      # "e" contains a message explaining why the request failed
      echo 'Card Error Message is:' . $e->getError()->message . '
      ';
      echo json_encode([
        'error_message' => $e->getError()->message
      ]);
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Invalid parameters were supplied to Stripe's API
      // echo 'Invalid Parameters Message is:' . $e->getError()->message . '';
      echo json_encode([
        'error_message' => $e->getError()->message
      ]);
    }
  }

  function confirmarPago()
  {

    $confirm_data = 1;
    # vendor using composer
    require_once('application/libraries/stripe-php/init.php');
    \Stripe\Stripe::setApiKey('sk_test_cNEnkPQ796OFqgwfXH2oBUyq00qKunHgZw');
    header('Content-Type: application/json');

    # retrieve json from POST body
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str, true);   

    if (isset($json_obj['selected_plan'])) {
      $confirm_data = ['payment_method_options' =>
      [
        'card' => [
          'installments' => [
            'plan' => $json_obj['selected_plan']
          ]
        ]
      ]];
    }

    $intent = \Stripe\PaymentIntent::retrieve(
      $json_obj['payment_intent_id']
    );

    $intent->confirm($params = $confirm_data);

    echo json_encode([
      'status' => $intent->status,
    ]);
  }
}
