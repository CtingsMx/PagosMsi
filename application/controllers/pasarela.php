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
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('m_pasarela', "", true);
        $this->load->library('session');
        $this->load->library('encrypt');

        $this->baseUrl = base_url();
        session_start();
    }

    /**
     * Muestra la interfaz inicial del sistema
     *
     * @return void
     */
    public function index()
    {
        //  $data['pk'] = $_ENV['OP_PUBLIC_KEY'];
        $this->load->view('inicio');
        $this->load->view('pasarela');
        $this->load->view('footer');
    }

    private function getOpenPay()
    {
        //INICIANDO OPENPAY
        Openpay::getProductionMode(false);
        $openPay = Openpay::getInstance(
            $_SESSION['merchant'],
            $_SESSION['private_key']
        );

        return $openPay;
    }

    /**
     * Recibe un Id mediante Get y lo balida con la Bd Kober
     *
     * @return void
     */
    public function revisaId()
    {
        $id = $this->input->get('folio');

        $respuesta = $this->m_pasarela->validaID($id);

        if (!$respuesta['error']) {
            $_SESSION['private_key'] = $respuesta['private_key'];
            $_SESSION['merchant'] = $respuesta['merchant'];

            unset($respuesta['private_key']);
        }

        echo json_encode($respuesta);
    }

    /**
     * Valida el formulario
     *
     * @return void
     */
    public function validaFormulario()
    {
        header('Content-Type: application/json');

        $openPay = $this->getOpenPay();

        $msi = $this->input->post('msi');
        $name = $this->input->post('name');
        $idPedido = $this->input->post('idPedido');

        $venta = $this->m_pasarela->obtVenta($idPedido);

        $this->m_pasarela->generarCuenta($venta);
        $cuenta = $this->m_pasarela->obtCuenta();

        if (!$venta['eMail1']) {
            $venta['eMail1'] = 'sincorreo@kober.mx';
        }

        $customer = array(
            'name' => $venta['Nombre'],
            // 'last_name' => 'Kober',
            'phone_number' => $venta['Telefonos'],
            'email' => $venta['eMail1'],
        );

        $chargeData = array(
            'method' => 'card',
            'source_id' => $_POST["token_id"],
            'amount' => (float) $cuenta['total'],
            'currency' => 'MXN',
            'order_id' => $venta['ID'] . '123',
            'description' => "pedido con movid: {$venta['movid']}",
            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
            'customer' => $customer,
            'use_3d_secure' => true,
            'payment_plan' => [
                'payments' => $msi,
            ],

            'redirect_url' => "{$this->baseUrl}pasarela/pagoExitoso?venta={$venta['movid']}",
        );

        try {

            $charge = $openPay->charges->create($chargeData);

            header("Location: " . $charge->payment_method->url);

        } catch (OpenpayApiTransactionError $e) {

            header("Location: " . "{$this->baseUrl}?folio={$venta['movid']}&code={$e->getErrorCode()}");
            die();



            echo json_encode(
                [
                    'ERROR on the transaction: ' . $e->getMessage() .
                    ' [error code: ' . $e->getErrorCode() .
                    ', error category: ' . $e->getCategory() .
                    ', HTTP code: ' . $e->getHttpCode() .
                    ', request ID: ' . $e->getRequestId() . ']', 0,
                ]
            );

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

    /**
     * Valida un pedido Exitoso
     *
     * @return void
     */
    public function pagoExitoso()
    {
        header('Content-Type: application/json');

        $openPay = $this->getOpenPay();

        $pagoGuardado = false;
        $id = $this->input->get('id');
        $venta = $this->input->get('venta');

        try {

            $pago = $openPay->charges->get($id);

            // Si el pago esta validado:
            if ($pago->status === 'completed') {
                $objOpenPay = $this->m_pasarela->generaObjetoOpenPay($pago);
                $pagoGuardado = $this->m_pasarela->enviaPagoServer($objOpenPay, $venta);
            }
            else{

                header("Location: " . "{$this->baseUrl}?folio={$venta}&code={$pago->error_code}");
                die();
            }

        } catch (OpenpayApiTransactionError $e) {
            echo json_encode(
                [
                    'ERROR on the transaction: ' . $e->getMessage() .
                    ' [error code: ' . $e->getErrorCode() .
                    ', error category: ' . $e->getCategory() .
                    ', HTTP code: ' . $e->getHttpCode() .
                    ', request ID: ' . $e->getRequestId() . ']', 0,
                ]
            );

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

        //SI el responde OK a la petición de almacenar los datos
        if ($pagoGuardado['ok']) {
            header("Location: " . "{$this->baseUrl}exito");
        } else {
            echo json_encode("ERROR PREOCESANDO EL PAGO");
        }

    }

    /**
     * Mestra la vista para una venta Exitosa
     *
     * @return void
     */
    public function exito()
    {
        $this->load->view('inicio');
        $this->load->view('exito');
    }

    public function contacto()
    {
        $this->load->view('inicio');
        $this->load->view('contacto');
    }

    /**
     * Envia mensaje de contacto
     *
     * @return void
     */
    public function enviarMensaje()
    {
        header("Location: / ");
    }

    public function avisoPrivacidad()
    {
        $this->load->view('inicio');
        $this->load->view('privacidad');
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
