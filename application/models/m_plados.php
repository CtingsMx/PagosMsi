<?php

class m_plados extends CI_Model
{

    /**
     * Retorna un objeto con toda la informacion del pedido
     *
     * @param int $id Identificador de la compra
     *
     * @return void
     */
    public function obtDatosPedido($id)
    {

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

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa datos de prueba 
     *
     * @return void
     */
    public function datosPrueba()
    {
        $datos = array(
            'movid' => 123,
            'pedido' => "123das",

        );

        return $datos;
    }

    public function obtVenta($id)
    {

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

    public function obtKeySucursal($idSucursal)
    {
        $this->db->where('sucursal', $idSucursal);
        return $this->db->get('KeySucursal')->row();
    }

    public function esPagoRealizado($id)
    {
        $this->db->where('movid', $id);

        return $this->db->get('respuestaPagoMSI')->num_rows();
    }

    public function fecha_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        return $fecha;
    }

    public function hora_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }

    public function fecha_text($datetime)
    {
        if ($datetime == "0000-00-00 00:00:00") {
            return "Fecha indefinida";
        } else {

            $dia = explode(" ", $datetime);
            $fecha = explode("-", $dia[0]);
            if ($fecha[1] == 1) {
                $mes = 'enero';
            } else if ($fecha[1] == 2) {
                $mes = 'febrero';
            } else if ($fecha[1] == 3) {
                $mes = 'marzo';
            } else if ($fecha[1] == 4) {
                $mes = 'abril';
            } else if ($fecha[1] == 5) {
                $mes = 'mayo';
            } else if ($fecha[1] == 6) {
                $mes = 'junio';
            } else if ($fecha[1] == 7) {
                $mes = 'julio';
            } else if ($fecha[1] == 8) {
                $mes = 'agosto';
            } else if ($fecha[1] == 9) {
                $mes = 'septiembre';
            } else if ($fecha[1] == 10) {
                $mes = 'octubre';
            } else if ($fecha[1] == 11) {
                $mes = 'noviembre';
            } else if ($fecha[1] == 12) {
                $mes = 'diciembre';
            }

            $hora = explode(":", $dia[1]);

            $time = $hora[0] . ":" . $hora[1] . " Hrs";

            $fecha2 = $fecha[2] . " " . $mes . " " . $fecha[0];
            return $fecha2 . " a las " . $time;
        }
    }
}
