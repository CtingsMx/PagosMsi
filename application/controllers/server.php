<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Openpay\Data\Openpay;

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

        $sucursal = $this->m_server->obtKeySucursal($venta->Sucursal);

        if (empty($sucursal)) {

            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "La sucursal no cuenta a??n con Pagos a Meses sin intereses",
                ]
            );
            return;
        }

        echo json_encode(
            [
                'error' => false,
                'resumen' => $venta,
                'public_key'    => $sucursal->llave_publica,
                'private_key'   => $sucursal->llave_secreta,
                'merchant'      => $sucursal->nombre,
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

        $movid = $this->input->post('movid');

        if (!$movid) {
            echo json_encode(
                [
                    "error" => true,
                    "msg" => "Error al recibir los parametros de la venta",
                ]
            );
        }

        $this->m_server->guardaPedido($movid);

        $compraGuardada = $this->db->insert_id();
        if ($compraGuardada != '') {

            echo json_encode(
                [
                    'ok' => true,
                    'msg' => "Se Guardo con exito la compra",
                ]
            );
        } else {
            echo json_encode(
                [
                    'ok' => false,
                    'msg' => "Hubo un error al intentar alamacenar en BD",
                ]
            );
        }

    }

}
