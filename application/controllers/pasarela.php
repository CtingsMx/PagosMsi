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
        $data['pk'] = 'pk_live_51JtbiWE2YIoXTzM7rBeQpef1CJn7Fwg79GUveG9wdhPDqxJQj2c5YhziGIgH39KOnqY21j7EzwWAfXqDklFfaDLG00WE2ADeys';
        $data['venta'] = $this->m_plados->datosPrueba();
        $this->load->view('inicio');
        $this->load->view('pasarela2', $data);
    }

    /**
     * Regresa los datos de una compra si esta es valida
     *
     * @return void
     */
    public function getCompra()
    {

        $folio = $this->input->get('folio');

        //CONEXION A DATOS DE LA BASE SQLSRV
        //$datosCompra = $this->m_plados->obtDatosPedido($folio);
        $datosCompra = $this->m_plados->datosPrueba();
        if (sizeof($datosCompra)) {
            echo json_encode(
                [
                    'resumen' => $datosCompra,
                    'articulos' => [],
                ]);

        } else {
            echo json_encode("no enconte nada ");
            die();
        }

    }

    /**
     * FUNCION PARA MOSTRAR PAGOS
     * 
     * @deprecated SE MIGRO A INDEX
     *
     * @return void
     */
    public function pagar()
    {
        $data['pk'] = 'pk_live_51JtbiWE2YIoXTzM7rBeQpef1CJn7Fwg79GUveG9wdhPDqxJQj2c5YhziGIgH39KOnqY21j7EzwWAfXqDklFfaDLG00WE2ADeys';
        $data['venta'] = $this->m_plados->datosPrueba();
        $this->load->view('inicio');
        $this->load->view('pasarela2', $data);

        //FGSU73502
    }

    /**
     * Valida el formulario 
     *
     * @return void
     */
    public function validaFormulario()
    {
        header('Content-Type: application/json');

        $pedido = $this->input->post('idPedido');
        $msi = $this->input->post('msi');
        $name = $this->input->post('name');

        $venta = $this->m_plados->obtVenta($pedido);
        $this->m_stripe->generarCuenta($venta);
        $cuenta = $this->m_stripe->obtCuenta();

        $customer = array(
            'name' => $venta->Cliente,
           // 'last_name' => 'Kober',
            'phone_number' => $venta->Telefonos,
            'email' => $venta->eMail1
        );

        $chargeData = array(
            'method' => 'card',
            'source_id' => $_POST["token_id"],
            'amount' => (float) 5000,
            'currency' => 'MXN',
            //'order_id' => 'TREsdd023',
            'description' => "articulo de prueba desde Kober",
            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
            'customer' => $customer,
            'use_3d_secure' => true,
            'redirect_url' => 'https://localhost/pagosmsi/pasarela/pagoExitoso?',
        );

        echo json_encode(['usuario' => $customer, 'cargo' => $chargeData]);

        $chargeData['payment_plan'] = array('payments' => 6);

        try {

            $charge = $this->openpay->charges->create($chargeData);

            header("Location: " . $charge->payment_method->url);

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

            $pago = $this->openpay->charges->get($id);
            echo json_encode($pago->order_id);

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
