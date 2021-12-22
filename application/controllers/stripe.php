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

        $this->load->helper('url');
        $this->load->model('m_plados', "", true);
        $this->load->model('m_stripe', "", true);
        $this->load->library('session');
        $this->load->library('encrypt');
        //Obtenemos el valor de las llaves desde las constantes
        //$stripeKeys = STRIPE_KEYS;
       // $SK = $stripeKeys['serverside'][STRIPE_MODE];

      //  \Stripe\Stripe::setApiKey($SK);

        session_start();
    }

    public function index()
    {

        $head['title'] = "Portal de Pagos KOBER";
        //id del pago
        $id = $this->input->get('id');

        $this->load->view('inicio');

        if(!$id){
            $error['error'] = "ingrese la Compra";
            $this->load->view('errors', $error);
            return;
        }

        if($this->m_plados->esPagoRealizado($id)){
            $error['error'] = "Esta compra ya fue Pagada";
            $this->load->view('errors', $error);
            return;
        }
        
        $venta = $this->m_plados->obtVenta($id);

        if(empty($venta)) {
            $error['error'] = "La compra solicitada no existe";
            $this->load->view('errors', $error);
           return;
        }

        $this->m_stripe->generarCuenta($venta[0]);
        
        $sucursal = $this->m_plados->obtKeySucursal($venta[0]->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
        $sucursal = $this->m_plados->obtKeySucursal(0);

        if(empty($sucursal)) {
            $error['error'] = "La sucursal no cuenta aún con Pagos a Meses sin intereses";
            $this->load->view('errors', $error);
            return;
        }

        \Stripe::setApiKey($sucursal->llave_secreta);

        $datos['venta'] = $venta;
        $datos['pk']    = $sucursal->llave_publica; 
        $this->load->view('pagos', $datos);       
        
       
    }
    //FUNCIONES PARA PAGOS MSI

    /**
     * Vista del chechout de MSI
     * 
     * @return view
     */
    function checkoutMsi()
    {
        $usuario = $this->m_plados->obt_cliente($_SESSION['idCliente']);
        $datos['usuario'] = $usuario;

        if (isset($_SESSION['cart'])) {
            $datos['carrito'] = $_SESSION['cart'];
            $carrito = $_SESSION['cart'];
        } else {
            $datos['carrito'] = null;
            redirect('carrito');
        }

        $datos['cuenta']   = $this->m_stripe->obtCuenta();
        $head['title'] = "Checkout";

        $this->load->view('eco/_head', $head);
        $this->load->view('eco/_menu');
        $this->load->view('eco/pages/checkout', $datos);
        $this->load->view('eco/_footer');
    }


    /**
     * Revisa los datos del pedido en Stripe
     * 
     * @return Json
     */
    public function revisaDatos()
    {
        header('Content-Type: application/json');

        /**
         * Revisa que haya articulos en el carrito
         */
        if (!isset($_SESSION['cart'])) {
            $datos['carrito'] = null;
            redirect('carrito');
        }
        // retrieve json from POST body
        $cuenta = $this->m_stripe->obtCuenta();
        // $usuario = $this->m_plados->obt_cliente($_SESSION['idCliente']);

        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);

        $data = array(
            'payment_method' => $json_obj->payment_method_id,
            'amount' => $cuenta['total'] * 100,
            'currency' => 'mxn',
            'payment_method_options' => [
                'card' => [
                    'installments' => [
                        'enabled' => true
                    ]
                ]
            ],
            //'receipt_email' => $usuario->correo,
        );
        //Agrega al PI la direccion de envio
        //$data['shipping'] = $this->m_stripe->formateaEnvio($usuario);


        if (isset($_SESSION['promoCode'])) {
            $data['metadata'] = ['cupon' => $_SESSION['promoCode']];
        }

        try {
            $intent = Stripe\PaymentIntent::create($data);

            echo json_encode(
                [
                    'intent_id' => $intent->id,
                    'available_plans' => $intent->payment_method_options->card->installments->available_plans
                ]
            );
        } catch (\Stripe\Exception\CardException $e) {
            // "e" contains a message explaining why the request failed
            echo 'Card Error Message is:' . $e->getError()->message . '';
            echo json_encode(
                [
                    'error_message' => $e->getError()->message
                ]
            );
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            echo 'Invalid Parameters Message is:' . $e->getError()->message . '';
            echo json_encode(
                [
                    'error_message' => $e->getError()->message
                ]
            );
        }
    }


    /**
     * Valida el pago en Stripe y devuelve exito
     * 
     * @return view
     */
    function confirmarPago()
    {
        header('Content-Type: application/json');

        try {
            $confirm_data = '';
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
            $intent->confirm($confirm_data);
            if ($intent->status == 'succeeded') {
                $this->guardaPedido($intent, $json_obj['pedido']);
            }

            echo json_encode([
                'status' => $intent->status,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {

            //echo 'Card Error Message is:' . $e->getError()->message . '';

            echo json_encode(
                [
                    'status' => $intent->status,
                    'error_message' => $e->getError()->message
                ]
            );
        }
    }

    /**
     * Guarda el pedido en la bd
     * 
     * Almacena en la base de datos el pedido validado por Stripe
     * 
     * @param string $idPago  pago de de Stripe
     * @param string $estatus estatus desde stripe
     * 
     * @return json
     */
    function guardaPedido($PI, $idPedido)
    {
        $pedido = $this->m_plados->obtVenta($idPedido);
        $pedido = $pedido[0];

        $pago = array(
            'ModuloID'      => $idPedido,
            'mov'           => $pedido->Mov,
            'movid'         => $pedido->movid,
            'sucursal'      => $pedido->Sucursal,
            'cliente'       => $pedido->Cliente,
            'nombreCliente' => $PI->charges->data[0]->billing_details->name,
            'cp'            => $PI->charges->data[0]->billing_details->address->postal_code,
            'referencia'    => $PI->id,
            'fechaRegistro' => $this->m_plados->fecha_actual(),
            'importeTotal'  => $PI->amount,
            'msi'           => $PI->charges->data[0]->payment_method_details->card->installments->plan->count,
            'last4'         => $PI->charges->data[0]->payment_method_details->card->last4,
            'mesExp'        => $PI->charges->data[0]->payment_method_details->card->exp_month,
            'anioExp'       => $PI->charges->data[0]->payment_method_details->card->exp_year,
            'tipo'          => $PI->charges->data[0]->payment_method_details->card->network
        );

        $this->m_stripe->guardarRespuesta($pago);

        $_SESSION['cart'] = null;
    }



    function validaId()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('idVenta');

        if (!$id) {
            echo json_encode([
                'error' => true,
                'mensaje' => "ingrese la Compra"
            ]);
            return;
        }

        if ($this->m_plados->esPagoRealizado($id)) {
            echo json_encode([
                'error' => true,
                'mensaje' => "Esta compra ya fue Pagada"
            ]);
            return;
        }

        $venta = $this->m_plados->obtVenta($id);

        if (empty($venta)) {
            echo json_encode([
                'error' => true,
                'mensaje' => "La compra solicitada no existe"
            ]);
            return;
        }

        $sucursal = $this->m_plados->obtKeySucursal($venta[0]->Sucursal);

        //PARA PRUEBAS... BORRAR EN PROD
        $sucursal = $this->m_plados->obtKeySucursal(0);

        if (empty($sucursal)) {

            echo json_encode([
                'error' => true,
                'mensaje' => "La sucursal no cuenta aún con Pagos a Meses sin intereses"
            ]);
            return;
        }

        echo json_encode([
            'error' => false,
            'id'    => $id
        ]);
    }

    /**
     * Genera un nuevo cupon en Stripe
     *
     * @return void
     */
    public function nuevoCupon()
    {
        header('Content-Type: application/json');
        $nuevoCupon =   \Stripe\Coupon::create(
            [
                'duration' => 'forever',
                'currency' => 'mxn',
                'id' => 'BuenFin2021',
                'percent_off' => 20,

            ]
        );
        echo json_encode($nuevoCupon);
    }

    /**
     * Genera un nuevo Codigo de Promoción
     * 
     * @return void
     */
    public function nuevoCodigoPromocion()
    {
        header('Content-Type: application/json');

        $PC = \Stripe\PromotionCode::create(
            [
                'coupon' => 'BuenFin2021',
                'code' => 'tarjas',
                'expires_at' => strtotime('2021-12-12')
            ]
        );

        echo json_encode($PC);
    }

    /**
     * Valida si un cupon esta activo
     * 
     * @return Json Objeto de respuesta
     */
    public function validaCupon()
    {
        $cupon = $this->input->get('cupon');
        $cupon = strtolower($cupon);

        $validacion = \Stripe\PromotionCode::all(["code" => $cupon]);

        //Valida que el codigo exista 
        if (!$validacion->data) {
            echo json_encode(
                [
                    "error"     => true,
                    "mensaje"   => "El codigo introducido no es valido."
                ]
            );

            return 0;
        }

        if (isset($_SESSION['promoCode'])) {
            echo json_encode(
                [
                    "error"     => true,
                    "mensaje"   => "Este pedido ya cuenta con un codigo de promoción redimido"
                ]
            );
            return 0;
        }

        //datos del cupon
        $codigo = $validacion->data;

        $aplicaCodigo = $this->m_stripe->aplicaCodigo($codigo);

        if (!$aplicaCodigo) {
            echo json_encode(
                [
                    "error"     => true,
                    "mensaje"   => "El codigo introducido ya caducó"
                ]
            );
            return 0;
        }



        echo json_encode(
            [
                "error"     => false,
                "cuenta"    => $this->m_stripe->obtCuenta(),

            ]
        );
    }
}
