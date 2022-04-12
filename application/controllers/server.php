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

        $this->load->model('M_Server', "", true);
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

        if ($this->M_Pasarela->esPagoRealizado($id)) {
            echo json_encode(
                [
                    'error' => true,
                    'mensaje' => "Esta compra ya fue Pagada",
                ]
            );
            return;
        }

        //OBTENEMOS LA VENTA, DESPUES DE PASAR LAS VALIDACIONES
        $venta = $this->M_Pasarela->obtDatosPedido($id);

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

        //  $sucursal = $this->M_Pasarela->obtKeySucursal($venta->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
        $sucursal = $this->M_Pasarela->obtKeySucursal(0);

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

        $venta = $this->M_Pasarela->obtVenta($id);

        echo json_encode($venta);

    }

}
