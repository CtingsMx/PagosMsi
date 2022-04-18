<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Openpay\Data\Openpay;
use Openpay\Data\OpenpayApiAuthError;
use Openpay\Data\OpenpayApiConnectionError;
use Openpay\Data\OpenpayApiError;
use Openpay\Data\OpenpayApiRequestError;
use Openpay\Data\OpenpayApiTransactionError;

/**
 * Clase dedicada a las funciones realizadas del lado del back
 * en el server alojado en local. *
 *
 * @category Controllers
 * @package  PagosMSI
 * @author   Daniel Mora <daniel.mora@ctings.com>
 * @license  https://github.io MIT
 * @link     https://github.com/danimc
 */
class Server extends CI_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        $this->load->model('m_server', "", true);
        $this->load->model('m_stripe', "", true);

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
     * Valida el Movid Enviado por el cliente
     *
     * @return void
     */
    public function validaID()
    {
        $id = $this->input->get('folio');

        if (!$id) {
            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "ingrese la Compra",
                ]
            );
            return;
        }

        if ($this->m_server->esPagoRealizado($id)) {
            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "Esta compra ya fue Pagada",
                ]
            );
            return;
        }

        //OBTENEMOS LA VENTA, DESPUES DE PASAR LAS VALIDACIONES
        $venta = $this->m_server->obtDatosPedido($id);

        if (empty($venta)) {
            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "La compra solicitada no existe",
                ]
            );
            return;
        }

        if (!$venta->MSI) {
            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "Este pedido no cuenta con Pagos a Meses sin intereses",
                    'MSI' => $venta->MSI,
                ]
            );
            return;
        }

        //  $sucursal = $this->m_pasarela->obtKeySucursal($venta->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
        $sucursal = $this->m_server->obtKeySucursal(0);

        if (empty($sucursal)) {

            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "La sucursal no cuenta aún con Pagos a Meses sin intereses",
                ]
            );
            return;
        }

        echo json_encode(
            [
                'error' => false,
                'resumen' => $venta,
                'articulos' => [],
            ]
        );
    }

    /**
     * Regresa la venta enviada por Get
     *
     * @return Json
     */
    public function getVenta()
    {

        $id = $this->input->get('movid');

        $venta = $this->m_server->obtVenta($id);

        echo json_encode($venta);

    }

    /**
     * Recibe los parametros del pago y la venta para alamacenarlos
     *
     * @return void
     */
    public function guardaPagoValidado()
    {
        $idOpenPay = $this->input->get('idOpen');
        $movid = $this->input->get('idVenta');

        try {

            $pago = $this->openpay->charges->get($idOpenPay);

            // Si el pago esta validado:
            if ($pago->status === 'completed') {
                $this->m_server->guardaPedido($pago, $movid);
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

        echo json_encode(
            [
                'ok' => true,
            ]
        );

    }

}
