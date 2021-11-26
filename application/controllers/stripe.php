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

        $this->load->model('m_usuario', "", true);
        $this->load->model('m_plados', "", true);
        $this->load->model('m_correos', "", true);
        $this->load->model('m_stripe', "", true);


        $this->load->library('session');
        $this->load->library('encrypt');

        //Obtenemos el valor de las llaves desde las constantes
        $stripeKeys = STRIPE_KEYS;
        $SK = $stripeKeys['serverside'][STRIPE_MODE];


        \Stripe\Stripe::setApiKey($SK);

        session_start();
    }

    function index()
    {
        echo "hola";
    }


    


    // FUNCIONES PARA CHECKOUT STRIPE

    /**
     * Carga el ceckout externo de Stripe
     *
     * @var array $datos Variable de array inicial para generar un check out
     *
     * @return void redirige a la pagina de exito o cancelación
     */
    public function checkout()
    {
        header('Content-Type: application/json');

        $productos = $_SESSION['cart'];
        $array = array();
        $cuenta = $this->m_plados->obt_cuenta();
        $descuento = abs($cuenta['puntos']);
        $descuento = $descuento * 100;

        // Llave de produccion
        $shipping = 'shr_1JDzTFAwKkEu57LsDfe5PKWF';
        //$shipping = 'shr_1JDyhmAwKkEu57Lsv9UyyNTT';

        if ($cuenta['total'] >= 1499) {
            // Llave de produccion
            $shipping = 'shr_1JPENvAwKkEu57LsHH2eLzEj';
            //$shipping = 'shr_1JDzUeAwKkEu57LszCX3PHFF';
        }

        $x = 0;
        foreach ($productos as $key) {
            $foto = str_replace(" ", "%20", $key['foto']);
            $array[$x]['price_data']['currency'] = 'mxn';
            $array[$x]['price_data']['unit_amount'] = (int)$key['precio'] * 100;
            $array[$x]['price_data']['product_data']['name'] = $key['descripcion'];
            $array[$x]['price_data']['product_data']['images'][0] = "https://plados.mx/src/images/shop/{$foto}";
            $array[$x]['quantity'] = $key['cantidad'];
            $x++;
        }

        $datos = array(
            'success_url' =>  base_url()  . 'stripe/procesar_pago_checkout?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => base_url() . "web/checkout",
            'payment_method_types' => ['card'],
            'shipping_rates' => [$shipping],
            'shipping_address_collection' => [
                'allowed_countries' => ['MX'],
            ],
            'line_items' => $array,
            'mode' => 'payment',
        );

        if ($descuento > 0) {
            //crea Cupon de descuento
            $coupon = \Stripe\Coupon::create(
                [
                    'amount_off' => $descuento,
                    'name'        => "Domótica Rewards",
                    'currency'  => 'mxn',
                    'duration' => 'once',
                ]
            );

            $puntos = array('coupon' => $coupon->id);

            $datos['discounts'] =  [$puntos];
        }

        if ($this->session->userdata('idStripe')) {
            $datos['customer'] = $this->session->userdata('idStripe');
        }

        $checkout_session = \Stripe\Checkout\Session::create($datos);

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
    }

    /**
     * Funcion de pago exitoso por checkout de Stipe
     *
     * @var int $idDireccion Almacena el id de la direccion del cliente
     * @var string $clienteEmail extrae el correo del cliente para verificar si ya
     * esta dado de alta en el sistema
     *
     * @return redirect redirige al checkout de stripe
     */
    public function procesarPagoCheckout()
    {
        header('Content-Type: application/json');

        $session = \Stripe\Checkout\Session::retrieve($this->input->get('session_id'));

        $clienteEmail = strtolower($session->customer_details->email);
        $usuarioBD = $this->m_usuario->es_usuario_registrado($clienteEmail);
        $rewards = 0;
        $idUser = '';

        if (isset($usuarioBD->id)) {
            $idUser = $usuarioBD->id;
        } else {
            $nuevoUsuario = array(
                'nombreCompleto'  => $session->shipping->name,
                'correo'          => $session->customer_details->email,
                'idStripe'        => $session->customer,
                'fecha_registro'  => $this->m_plados->fechahora_actual()
            );

            $this->m_plados->guardar_cliente($nuevoUsuario);
            $idUser = $this->db->insert_id();
        }

        $direccion = array(
            'cliente'     => $idUser,
            'calle'       => $session->shipping->address->line1,
            'ciudad'      => $session->shipping->address->city,
            'estado'      => $session->shipping->address->state,
            'cp'          => $session->shipping->address->postal_code,
            'colonia'     => $session->shipping->address->line2
            // 'referencias' => $session->shipping->address,
        );

        $idDireccion = 0;

        $direcciones = $this->m_admin->buscar_direccion($idUser, $session->shipping->address->line1);

        // verifica las direcciones del usuario
        if (isset($direcciones->calle)) {
            $idDireccion = $direcciones->id;
        } else {
            $this->m_plados->guardar_direccion($direccion);
            $idDireccion = $this->db->insert_id();
        }


        $PI = $session->payment_intent;     //Variable del pago realizado
        $carrito = $_SESSION['cart'];
        $cuenta = $this->m_plados->obt_cuenta();

        //Calcula la cantidad de Recompensas a obtener
        $rewards = ($cuenta['subtotal'] - (-$cuenta['puntos'])) / 20;

        $pedido = array(
            'cliente'       => $idUser,
            'idPago'        => $PI,
            'cantArticulos' => $cuenta['cantProductos'],
            'subtotal'      => $cuenta['subtotal'] * 100,
            'envio'         => $cuenta['envio'] * 100,
            'cuenta'        => $cuenta['total'] * 100,
            'puntos'        => $cuenta['puntos'],
            'idDireccion'   => $idDireccion
        );

        if ($session->payment_status == 'paid') {
            $pedido['estatus'] = 2;
        }

        $this->m_plados->guardaPedido($pedido);
        $idPedido = $this->db->insert_id();

        // Array con los datos para añadir rewards a la cuenta del usuario
        $puntos = array(
            'pedido'    => $idPedido,
            'usuario'   => $idUser,
            'fecha'     => $this->m_plados->fechahora_actual(),
            'cantidad'  => (int)$rewards
        );

        //añade los puntos generados por la compra actual
        $this->m_plados->add_rewards($puntos);

        //Ingresa por separado los articulos solicitados para cotejar con el inventario
        foreach ($carrito as $c) {
            $c['pedido'] = $idPedido;
            $this->m_plados->articulo_pedido($c);
            $this->m_plados->actualizaStock($c['articulo'], $c['cantidad']);
        }

        if ($cuenta['puntos'] != 0) {
            $puntos['cantidad']     = $cuenta['puntos'];
            $puntos['movimiento']   = 2;

            $this->m_plados->add_rewards($puntos);
        }

        $_SESSION['cart'] = null;
        unset($_SESSION['descuento']);

        redirect("web/exito/" . $this->encrypt->encode($idPedido));
    }

    // FIN DE FUNCIONES CHECKOUT STRIPE

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
        $usuario = $this->m_plados->obt_cliente($_SESSION['idCliente']);

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
            'receipt_email' => $usuario->correo,
        );
        //Agrega al PI la direccion de envio
        $data['shipping'] = $this->m_stripe->formateaEnvio($usuario);


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
            echo json_encode($intent);
            if ($intent->status == 'succeeded') {
                $this->guardaPedido($json_obj['payment_intent_id'], $intent->status);
            }
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
    function guardaPedido($idPago, $estatus)
    {
        $carrito = $_SESSION['cart'];
        $cuenta = $this->m_stripe->obtCuenta();

        $pedido = array(
            'cliente'       => $_SESSION['idCliente'],
            'idPago'        => $idPago,
            'cantArticulos' => $cuenta['cantProductos'],
            'cuenta'        => $cuenta['total'],
            'descuento'     => $cuenta['puntos'],
            'subtotal'      => $cuenta['subtotal']
        );

        $this->m_plados->guardaPedido($pedido);

        $idPedido = $this->db->insert_id();
        $x = 0;
        foreach ($carrito as $c) {
            $carrito[$x]['pedido'] = $idPedido;
            $this->m_plados->articulo_pedido($carrito[$x]);
            $x++;
        }
        //si hay datos de facturacion...
        if (isset($_SESSION['factura'])) {
            $this->m_plados->ingresar_factura($idPedido, $_SESSION['factura']);
        }

        $_SESSION['cart'] = null;
        //@$this->m_correos->correo_cliente($idPedido);
        // @$this->m_correos->correo_ventas($idPedido);


        echo json_encode(
            [
                'status' => $estatus,
                'idPedido' => $idPedido
            ]
        );
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
        $codigo = $validacion->data[0];

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
