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
        $this->load->model('M_Pasarela', "", true);
        $this->load->model('m_stripe', "", true);
        $this->load->library('session');
        $this->load->library('encrypt');

        //INICIANDO OPENPAY
        Openpay::getProductionMode(false);
        $this->openpay = Openpay::getInstance(
            $_ENV['OP_ID'],
            $_ENV['OP_PRIVATE_KEY']
        );

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
        $data['pk'] = $_ENV['OP_PUBLIC_KEY'];
        $this->load->view('inicio');
        $this->load->view('pasarela', $data);
    }

    /**
     * Regresa los datos de una compra si esta es valida
     *
     * @return void
     * @deprecated En su lugar usar: validaID
     */
    public function getCompra()
    {

        $folio = $this->input->get('folio');

        $datosCompra = $this->M_Pasarela->obtDatosPedido($folio);
        if ($datosCompra) {
            echo json_encode(
                [
                    'resumen' => $datosCompra,
                    'articulos' => [],
                ]
            );

        } else {
            echo json_encode("no enconte nada ");
            die();
        }

    }

    /**
     * Valida el formulario
     *
     * @return void
     */
    public function validaFormulario()
    {
        header('Content-Type: application/json');

        $msi = $this->input->post('msi');
        $name = $this->input->post('name');
        $idPedido = $this->input->post('idPedido');

        $venta = $this->M_Pasarela->obtVenta;

        //CAMBIAR A CURL
        //$venta = $this->M_Pasarela->obtVenta($idPedido);

        //$venta = $this->M_Pasarela->datosPrueba();

        $this->m_stripe->generarCuenta($venta);
        $cuenta = $this->m_stripe->obtCuenta();

        if (!$venta->eMail1) {
            $venta->eMail1 = 'sincorreo@kober.mx';
        }

        $customer = array(
            'name' => $venta->Nombre,
            // 'last_name' => 'Kober',
            'phone_number' => $venta->Telefonos,
            'email' => $venta->eMail1,
        );

        $chargeData = array(
            'method' => 'card',
            'source_id' => $_POST["token_id"],
            'amount' => (float) $cuenta['total'] * 2,
            'currency' => 'MXN',
            'order_id' => $venta->ID . '123',
            'description' => "pedido con movid: {$venta->movid}",
            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
            'customer' => $customer,
            'use_3d_secure' => true,
            'payment_plan' => [
                'payments' => $msi,
            ],

            'redirect_url' => "{$this->baseUrl}pasarela/pagoExitoso?venta={$venta->movid}",
        );

        try {

            $charge = $this->openpay->charges->create($chargeData);

            header("Location: " . $charge->payment_method->url);

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

    }

    /**
     * Valida un pedido Exitoso
     *
     * @return void
     */
    public function pagoExitoso()
    {
        header('Content-Type: application/json');

        $id = $this->input->get('id');
        $venta = $this->input->get('venta');

        try {

            $pago = $this->openpay->charges->get($id);

            // Si el pago esta validado:
            if ($pago->status === 'completed') {
                $this->guardaPedido($pago, $venta);
            }

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

    /**
     * Guarda el pedido en la bd
     *
     * Almacena en la base de datos el pedido validado por Openpay
     *
     * @param string $idPago  pago de de Openpay
     * @param string $estatus estatus desde Openpay
     *
     * @return json
     */
    public function guardaPedido($PI, $idPedido)
    {

        $pedido = $this->M_Pasarela->obtVenta($idPedido);

        $pago = array(
            'ModuloID' => $pedido->ID,
            'mov' => $pedido->Mov,
            'movid' => $pedido->movid,
            'sucursal' => $pedido->Sucursal,
            'cliente' => $pedido->Cliente,
            'nombreCliente' => $pedido->Nombre,
            //'cp' => $PI->charges->data->billing_details->address->postal_code,
            'referencia' => $PI->id,
            'fechaRegistro' => $this->M_Pasarela->fecha_actual(),
            'importeTotal' => $PI->amount,
            'msi' => 3,
            'last4' => substr($PI->card->card_number, -4),
            'mesExp' => $PI->card->expiration_month,
            'anioExp' => $PI->card->expiration_year,
            'tipo' => $PI->card->brand,
        );

        $this->m_stripe->guardarRespuesta($pago);

        $_SESSION['cart'] = null;
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
