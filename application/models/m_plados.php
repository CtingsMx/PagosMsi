<?php

class m_plados extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function obt_productos()
    {
        $qry = '';

        $qry = "
    	SELECT
        p.id_catProducto
       ,p.titulo
       ,p.sku
       ,t.producto
	   ,l.linea
       ,c.color
       ,p.color as idColor
       ,p.modelo
       ,p.precio
       ,p._precio
       ,p.foto
       ,p.descripcion
		FROM tb_cat_producto p
		LEFT JOIN tb_cat_tipo t ON t.id_tipo = p.producto
		LEFT JOIN tb_cat_linea l ON l.id_linea = p.linea
        LEFT JOIN tb_cat_colores c ON c.codigo = p.color
        WHERE p.activo = 1 
        ORDER BY p.destacado DESC";

        return $this->db->query($qry)->result();
    }

    function obt_articulo($id)
    {
        $qry = '';

        $qry = "
    	SELECT
        p.id_catProducto
        ,p.titulo
        ,p.sku
       ,t.producto
	   ,l.linea
	   ,p.color as idColor
       ,c.color
       ,p.modelo
       ,p.precio
       ,p._precio
       ,p.foto
       ,p.descripcion
		FROM tb_cat_producto p
		LEFT JOIN tb_cat_tipo t ON t.id_tipo = p.producto
		LEFT JOIN tb_cat_linea l ON l.id_linea = p.linea
		LEFT JOIN tb_cat_colores c ON c.codigo = p.color
		WHERE id_catProducto = $id";

        return $this->db->query($qry)->row();
    }

    function obt_relacionados($modelo)
    {
        $qry = '';

        $qry = "
    	SELECT t.producto
	   ,l.linea
       ,c.color
       ,p.modelo
       ,p.precio
       ,p.foto
       ,p.descripcion
		FROM tb_cat_producto p
		LEFT JOIN tb_cat_tipo t ON t.id_tipo = p.producto
		LEFT JOIN tb_cat_linea l ON l.id_linea = p.linea
		LEFT JOIN tb_cat_colores c ON c.codigo = p.color
		WHERE id_catProducto = '$modelo'";

        return $this->db->query($qry)->row();
    }

    function obt_productosPedidos($pedido)
    {
        $this->db->where('pedido', $pedido);

        return $this->db->get('tb_articulosPedidos')->result();
    }

    function guardar_cliente($cliente)
    {
        $this->db->insert('tb_clientes', $cliente);
    }

    function guardar_direccion($direccion)
    {
        $this->db->insert('tb_direcciones', $direccion);
    }

    function ingresar_factura($idPedido, $factura)
    {
        $this->db->where('id', $factura);
        $this->db->set('pedido', $idPedido);

        $this->db->update('tb_datos_factura', $this);
    }

    function buscar_datosFactura($pedido)
    {
        $this->db->where('pedido', $pedido);
        return $this->db->get('tb_datos_factura')->row();
    }

    function obt_cliente($id)
    {
        $qry = '';

        $qry = "
			SELECT * FROM tb_clientes
			INNER JOIN tb_direcciones
			WHERE id = '$id'
			AND id = cliente";

        return $this->db->query($qry)->row();
    }

    /**
     * Guarda el pedido validado en la Base de datos
     * 
     * @param object $pedido datos del nuevo pedido
     * 
     * @return void
     */
    function guardaPedido($pedido)
    {
        $this->db->insert('tb_pedidos', $pedido);
    }

    function datos_factura($datos)
    {
        $this->db->insert('tb_datos_factura', $datos);
    }

    function articulo_pedido($carrito)
    {
        $this->db->insert('tb_articulosPedidos', $carrito);
    }

    function comprobar_pedido($usuario)
    {
        $this->db->where('sesCompra', $usuario);

        return $this->db->get('tb_pedidos')->num_rows();
    }

    function obt_pedido($pedido)
    {
        $qry = '';

        $qry = "
		SELECT * FROM tb_clientes c
		INNER JOIN tb_pedidos p
		INNER JOIN tb_direcciones d
        INNER JOIN tb_estatusPedido e
		WHERE c.id = p.cliente
		AND d.cliente = c.id
        AND e.id = p.estatus
		AND p.id_pedido = $pedido";

        return $this->db->query($qry)->row();
    }

    function color($color)
    {
        if ($color == 58) {
            $esta = ' <span style="background-color: #f3f3f3 !important; border-color:#000 !important" class="badge badge-info badge-circle"><i class="fa fa-tint"></i> </span>';
            return $esta;
        }
        if ($color == 44) {
            $esta = ' <span style="background-color: #292a2a !important; border-color:#000" class="badge badge-info badge-circle"><i class="fa fa-tint"></i> </span>';
            return $esta;
        }
        if ($color == 42) {
            $esta = ' <span style="background-color: #B6AFA9 !important; border-color:#000" class="badge badge-info badge-circle"><i class="fa fa-tint"></i> </span>';
            return $esta;
        }
    }

    function resaltar($texto, $criterio)
    {
        $claves = explode(" ", $criterio);
        $clave = array_unique($claves);
        $num = count($clave);
        for ($i = 0; $i < $num; $i++) {
            $texto = preg_replace("/(" . trim($clave[$i]) . ")/i", "<span style='color: #000000;
	background: #55FF2A;
	font-weight: bold;'>\\1</span>", $texto);
        }
        return $texto;
    }

    function hora_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }

    function fecha_text($datetime)
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
