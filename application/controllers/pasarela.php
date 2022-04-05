<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Openpay\Data\Openpay;
use Openpay\Data\OpenpayApiAuthError;
use Openpay\Data\OpenpayApiConnectionError;
use Openpay\Data\OpenpayApiError;
use Openpay\Data\OpenpayApiRequestError;
use Openpay\Data\OpenpayApiTransactionError;

class Pasarela extends CI_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('m_plados', "", true);
        $this->load->model('m_stripe', "", true);
        $this->load->library('session');
        $this->load->library('encrypt');

        //INICIANDO OPENPAY
        Openpay::getProductionMode(false);
        $this->openpay = Openpay::getInstance('mex0qnhtpq3m0yvkl3sa', 'sk_0d2dbc7f9a6a4f88a5320c75a28815dd');

        session_start();

    }

    public function index()
    {
        // header('Content-Type: application/json');
        Openpay::getProductionMode(false);
        $openpay = Openpay::getInstance('mex0qnhtpq3m0yvkl3sa', 'sk_0d2dbc7f9a6a4f88a5320c75a28815dd', 'MX');

        /* $customerData = array(
        'name' => 'Teofilo',
        'last_name' => 'Velazco',
        'email' => 'teofilo@payments.com',
        'phone_number' => '4421112233',
        'address' => array(
        'line1' => 'Privada Rio No. 12',
        'line2' => 'Co. El Tintero',
        'line3' => '',
        'postal_code' => '76920',
        'state' => 'Querétaro',
        'city' => 'Querétaro.',
        'country_code' => 'MX'));

        $customer = $openpay->customers->add($customerData);
         */

        $findData = array(
            'creation[gte]' => '2022-01-01',
            'creation[lte]' => '2022-12-31',
            'offset' => 0,
            'limit' => 5);

        $customerList = $openpay->customers->getList($findData);

        // echo json_encode($customerList);
    }

    public function pagar()
    {
        $this->load->view('pasarela');
    }

    public function datosPagos()
    {
        $customer = array(
            'name' => 'Pago chido',
            'last_name' => 'Kober',
            'phone_number' => '3312124587',
            'email' => 'daniel.mora@kober.com');

        $chargeData = array(
            'method' => 'card',
            'source_id' => $_POST["token_id"],
            'amount' => (float) 5000,
            'currency' => 'MXN',
            'description' => "articulo de prueba desde Kober",
            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
            'customer' => $customer,
            'use_3d_secure' => true,
            'redirect_url' => 'https://localhost/pagosmsi/pasarela/pagoExitoso?',
        );

        $chargeData['payment_plan'] = array('payments' => 6);

        try {

            $charge = $this->openpay->charges->create($chargeData);
            echo json_encode($charge->payment_method);

            //header("Location: " . $charge->payment_method->url);

        } catch (OpenpayApiTransactionError $e) {
            echo json_encode(['ERROR on the transaction: ' . $e->getMessage() .
                ' [error code: ' . $e->getErrorCode() .
                ', error category: ' . $e->getCategory() .
                ', HTTP code: ' . $e->getHttpCode() .
                ', request ID: ' . $e->getRequestId() . ']', 0]);

        } catch (OpenpayApiRequestError $e) {
            echo json_encode('ERROR on the request: ' . $e->getMessage(), 0);

        } catch (OpenpayApiConnectionError $e) {
            echo json_encode('ERROR while connecting to the API: ' . $e->getMessage(), 0);

        } catch (OpenpayApiAuthError $e) {
            echo json_encode('ERROR on the authentication: ' . $e->getMessage(), 0);

        } catch (OpenpayApiError $e) {
            echo json_encode('ERROR on the API: ' . $e->getMessage(), 0);

        } catch (Exception $e) {
            echo json_encode('Error on the script: ' . $e->getMessage(), 0);
        }

    }

    public function pagoExitoso()
    {
        header('Content-Type: application/json');

        $id = $this->input->get('id');

        try {

            $pago = $this->openpay->charges->get("tro5mkqvqqjfvakczeab");
            echo json_encode($pago->status);

        } catch (OpenpayApiTransactionError $e) {
            echo json_encode(['ERROR on the transaction: ' . $e->getMessage() .
                ' [error code: ' . $e->getErrorCode() .
                ', error category: ' . $e->getCategory() .
                ', HTTP code: ' . $e->getHttpCode() .
                ', request ID: ' . $e->getRequestId() . ']', 0]);

        } catch (OpenpayApiRequestError $e) {
            echo json_encode('ERROR on the request: ' . $e->getMessage(), 0);

        } catch (OpenpayApiConnectionError $e) {
            echo json_encode('ERROR while connecting to the API: ' . $e->getMessage(), 0);

        } catch (OpenpayApiAuthError $e) {
            echo json_encode('ERROR on the authentication: ' . $e->getMessage(), 0);

        } catch (OpenpayApiError $e) {
            echo json_encode('ERROR on the API: ' . $e->getMessage(), 0);

        } catch (Exception $e) {
            echo json_encode('Error on the script: ' . $e->getMessage(), 0);
        }

    }

    public function codigoEjemplo()
    {
        try {
            $charge = $this->openpay->charges->create($chargeData);
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            $errorCode = $e->getCode();
        }
        $status = null;
        if ($errorMsg !== null || $errorCode !== null) {
            $errorMsg = $this->getError($errorCode);
            $status = array("status" => false, "error" => $errorMsg, "errorCode" => $errorCode);
        } else {
            $status = array("status" => true, "charge" => json_encode($chargeData));
        }
        return $status;
    }
}
