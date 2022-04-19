<?php

/**
 * Clase encargada de realizar las consultas a la Bd
 *
 * @author Daniel Mora <daniel.mora@ctings.com>
 *
 */
class m_server extends CI_Model
{

    /**
     * Retorna un objeto con toda la informacion del pedido
     *
     * @param string $id Identificador de la compra
     *
     * @return objeto
     */

    public function obtDatosPedido(string $id)
    {

        if ($id == 123) {
            return $this->datosPrueba();
            die();
        }

        $qry = "";

        $qry = "
        SELECT v.ID,
        v.Mov,
        movid,
        v.Sucursal,
        v3.VentaSubTotal,
        ISNULL(v3.VentaDescuentoImporte,0) AS Descuento,
        v3.VentaTotal,
        v3.MonedaV33,
        d.Articulo,
        a.Descripcion1,
        d.Cantidad,
        v.Cliente,
        c.Nombre,
        c.RFC,
        c.eMail1,
        c.Telefonos,
        c.Direccion,
        c.CodigoPostal,
        c.Poblacion,
        c.Estado,
        v.MSI
        FROM venta v
        JOIN CFDVentaV33 v3 ON v3.id=v.id
        JOIN ventad d ON d.id=v.id
        JOIN art a ON a.Articulo=d.Articulo
        JOIN cte c ON c.Cliente=v.Cliente
        WHERE movid='{$id}'
        AND Mov LIKE 'Factura%'";

        return $this->db->query($qry)->row();
    }

    /**
     * Retorna una lista de productos Pedidos
     *
     * @param int $id identificador del pedido
     *
     * @return object
     */
    public function obtProductosPedidos($id)
    {

        $qry = "";

        $qry = "

        v3.VentaSubTotal,
        ISNULL(v3.VentaDescuentoImporte,0) AS Descuento,
        v3.VentaTotal,
        v3.MonedaV33,
        d.Articulo,
        a.Descripcion1,
        d.Cantidad,
        v.MSI
        FROM venta v
        JOIN CFDVentaV33 v3 ON v3.id=v.id
        JOIN ventad d ON d.id=v.id
        JOIN art a ON a.Articulo=d.Articulo
        JOIN cte c ON c.Cliente=v.Cliente
        WHERE movid='{$id}'
        AND Mov LIKE 'Factura%'";

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa datos de prueba
     *
     * @return void
     */
    public function datosPrueba()
    {
        $datos = new \stdClass;
        $datos->ID = 56465462;
        $datos->Mov = 1;
        $datos->movid = "123";
        $datos->Sucursal = "Guadalajara";
        $datos->Cliente = 12;
        $datos->Nombre = 'Juan Perez';
        $datos->eMail1 = 'contoso@kober.com';
        $datos->RFC = 'MOCL9402236E1';
        $datos->Telefonos = "3333336546";
        $datos->VentaTotal = 3000;
        $datos->MSI = 1;

        return $datos;
    }

    /**
     * Provee un objeto de datos de prueba
     *
     * @return void
     */
    public function productosPrueba()
    {
        $productos = array(
            [

            ]
        );
    }

    /**
     * Obtiena los datos de venta a pagar
     *
     * @param string $id Movid de de la venta
     *
     * @return object
     */
    public function obtVenta(string $id)
    {
        $qry = "";

        if ($id == 123) {
            return $this->datosPrueba();
        }

        $qry = "
        SELECT v.ID,
        v.Mov,
        movid,
        v.Sucursal,
        v3.VentaSubTotal,
        ISNULL(v3.VentaDescuentoImporte,0) AS Descuento,
        v3.VentaTotal,
        v3.MonedaV33,
        d.Articulo,
        a.Descripcion1,
        d.Cantidad,
        v.Cliente,
        c.Nombre,
        c.RFC,
        c.eMail1,
        c.Telefonos,
        c.Direccion,
        c.CodigoPostal,
        c.Poblacion,
        c.Estado,
        v.MSI
        FROM venta v
        JOIN CFDVentaV33 v3 ON v3.id=v.id
        JOIN ventad d ON d.id=v.id
        JOIN art a ON a.Articulo=d.Articulo
        JOIN cte c ON c.Cliente=v.Cliente
        WHERE movid='{$id}'
        AND Mov LIKE 'Factura%'";

        return $this->db->query($qry)->row();
    }

    public function obtKeySucursal($idSucursal)
    {
        $this->db->where('sucursal', $idSucursal);
        return $this->db->get('KeySucursal')->row();
    }

    /**
     * Valida que el pago no se encientre pagado
     *
     * @param string $id movid de la compra
     *
     * @return boolean
     */
    public function esPagoRealizado($id)
    {
        $this->db->where('movid', $id);

        return $this->db->get('respuestaPagoMSI')->num_rows();
    }

    /**
     * Guarda el pedido en la bd
     *
     * Almacena en la base de datos el pedido validado por Openpay
     *
     * @param Object $openPay Objeto con la respuesta de pago de de Openpay
     * @param string $movid   id del pago
     *
     * @return json
     */
    public function guardaPedido($movid)
    {

        $pedido = $this->obtVenta($movid);

        $pago = array(
            'ModuloID' => $pedido->ID,
            'mov' => $pedido->Mov,
            'movid' => $pedido->movid,
            'sucursal' => $pedido->Sucursal,
            'cliente' => $pedido->Cliente,
            'nombreCliente' => $pedido->Nombre,
            'fechaRegistro' => $this->input->post('fechaRegistro'),
            //'cp' => $openPay->charges->data->billing_details->address->postal_code,
            'referencia' => $this->input->post('referencia'),
            'importeTotal' => $this->input->post('importeTotal'),
            'msi' => $this->input->post('msi'),
            'last4' => $this->input->post('last4'),
            'mesExp' => $this->input->post('mesExp'),
            'anioExp' => $this->input->post('anioExp'),
            'tipo' => $this->input->post('tipo'),
        );

        echo json_encode($pago);
        die();

        $this->guardarRespuesta($pago);
        // $_SESSION['cart'] = null;

        return true;
    }

    /**
     * Almacena en la BD la compra hecha en la pasarela
     *
     * @param object $pago objeto del pago
     *
     * @return void
     */
    public function guardarRespuesta($pago)
    {
        $this->db->insert('respuestaPagoMSI', $pago);
    }

}
