<?php 

class m_admin extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function obt_lista_usuarios(){
        $this->db->select('nombre');
        return $this->db->get("usuario")->result();   
    }

    function lista_productos()
    {
        $qry = '';

    	$qry = "
    	SELECT
    	p.id_catProducto
       ,t.producto
	   ,l.linea
       ,c.color
       ,p.color as idColor
       ,p.modelo
       ,p.precio
       ,p.foto
       ,p.descripcion
       ,p.activo
       ,p.destacado
		FROM tb_cat_producto p
		LEFT JOIN tb_cat_tipo t ON t.id_tipo = p.producto
		LEFT JOIN tb_cat_linea l ON l.id_linea = p.linea
		LEFT JOIN tb_cat_colores c ON c.codigo = p.color";

		return $this->db->query($qry)->result();
    }

    function obt_producto($producto)
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
       ,p.foto
       ,p.descripcion
       ,p.activo
		FROM tb_cat_producto p
		LEFT JOIN tb_cat_tipo t ON t.id_tipo = p.producto
		LEFT JOIN tb_cat_linea l ON l.id_linea = p.linea
        LEFT JOIN tb_cat_colores c ON c.codigo = p.color
        WHERE id_catProducto = '$producto'";

		return $this->db->query($qry)->row();
    }

    function obt_estatus()
    {
        $this->db->where('id >', 1);
        return $this->db->get('tb_estatusPedido')->result();
    }

    function obt_catBullets()
    {
        return $this->db->get('tb_cat_bullets')->result();
    }

    function obt_bullets($producto)
    {
        $qry = '';

        $qry = "SELECT
                p.id 
                ,bullet
                FROM tb_bullets_producto p
                INNER JOIN tb_cat_bullets c
                WHERE c.id = id_bullet
                AND p.id_producto = $producto";

        return $this->db->query($qry)->result();
    }

    function agregar_bullet($etiqueta)
    {
        $this->db->insert('tb_bullets_producto', $etiqueta);
    }

    function agregar_catBullet($bullet)
    {
        $this->db->insert('tb_cat_bullets', $bullet);
    }

    function elimina_bullet($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('tb_bullets_producto');
    }

    function editar_descripcion($id, $texto)
    {
        $this->db->set('descripcion', $texto);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function editar_titulo($id, $titulo)
    {
        $this->db->set('titulo', $titulo);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function editar_sku($id, $sku)
    {
        $this->db->set('sku', $sku);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function editar_precio($id, $precio)
    {
        $this->db->set('precio', $precio);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function subir_portada($portada, $id)
    {
        $this->db->set('foto', $portada);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function obt_imgGaleria($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_galeria')->row();
    }

    function habilitar_galeria($id, $estatus)
    {
        $this->db->set('activa', $estatus);
        $this->db->where('id', $id);

        $this->db->update('tb_galeria', $this);
    }

    function modificar_estatusProducto($id, $estatus)
    {
        $this->db->set('activo', $estatus);
        $this->db->where('id_catProducto', $id);

        $this->db->update('tb_cat_producto', $this);
    }

    function eliminar_galeria($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_galeria');
    }

    function obt_galeria($producto)
    {
        $this->db->where('id_producto', $producto);

        return $this->db->get('tb_galeria')->result();
    }

    function subir_galeria($attach)
    {
        $this->db->insert('tb_galeria', $attach);
    }

    function obt_categorias(){
        $this->db->order_by('nombre_tipoCat', 'ASC');
        return $this->db->get("Tb_CatTipoCategoria")->result();   

    }

    function obt_asignados($puesto){

        $this->db->where("rol >", 2);
        $this->db->where("puesto", $puesto);
        return $this->db->get("usuario")->result();
    }

    function obt_dependencias(){
        $this->db->order_by('nombre_dependencia', 'ASC');
        return $this->db->get("dependencias")->result();   
    }


    function obt_titulos()
    {
        $qry = "";
        $qry = "SELECT
                 nombre_categoria as titulo
                 FROM categoria_ticket";

        $titulos = $this->db->query($qry)->result();
        $array = array();
        foreach ($titulos as $titulo) {
            $array[] = 
                $titulo->titulo;
        }
        return json_encode($array);
    }

    function obt_canales()
    {
        $this->db->where('id_puesto <', 8);
        return $this->db->get('tb_Cat_puestos')->result();
    }

    function obt_nombreCanal($canal)
    {
        $this->db->where('id_puesto', $canal);
        return $this->db->get('tb_Cat_puestos')->row();
    }

    function obt_asignado($folio)
    {
        $this->db->where("folio", $folio);
        $this->db->select('usr_asignado');
        return $this->db->get("ticket")->row(); 
    }

    function obt_imagenesChat($folio)
    {
        $this->db->where('img !=', '');
        $this->db->where('folio', $folio);

        return $this->db->get('h_ticket')->num_rows();
    }

    function estatus()
    {
        $this->db->where('id !=', 1);
        $this->db->where('id !=', 2);
        $this->db->where('id !=', 5);
        $this->db->where('id !=', 7);
        $this->db->where('id !=', 9);
        return $this->db->get("situacion_ticket")->result();
    }

    function nuevo_incidente($ticket)
    {
        $this->db->insert("ticket", $ticket);
    }

    function seguimiento_ticket($folio)
    {
        $qry = "";

        $qry = "SELECT 
                folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as usuario
                ,dependencias.nombre_dependencia
                ,ext as extension
                ,ticket.correo
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,detalle_ubicacion as ubicacion
                ,ticket.categoria as id_tipoCat
                ,ticket.descripcion
                ,asignado.usuario as asignado
                ,usr_asignado
                ,est.id as situacion
                ,fecha_cierre
                ,hora_cierre
                ,canal_atencion as canal
                ,c.nombrePuesto as nCanal
                ,ticket.tSolicitud
                ,escribiente.usuario as escribiente
                ,prioridad
                from ticket
                LEFT JOIN usuario asignado on asignado.codigo = ticket.usr_asignado
                LEFT JOIN usuario escribiente on escribiente.codigo = ticket.usr_reportante
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN dependencias on  ticket.departamento = dependencias.id_dependencia
                LEFT JOIN tb_Cat_puestos c on ticket.canal_atencion = c.id_puesto 
                WHERE ticket.folio = '$folio'";

        return $this->db->query($qry)->row();
    }

    function obt_seguimiento($folio)
    {
   $qry = "SELECT 
        h_ticket.id
        ,cat.nombre_tipoCat as categoria
        ,situ.situacion
        ,usuario.usuario
        ,asignado.usuario asignado
        ,mensaje
        ,fecha
        ,hora
        ,canal
        ,h_ticket.img
        ,pu.nombrePuesto as nombre_canal
        FROM h_ticket
        LEFT JOIN Tb_CatTipoCategoria cat ON cat.id_tipoCat = h_ticket.categoria
        LEFT JOIN situacion_ticket situ ON situ.id = h_ticket.estatus
        LEFT JOIN usuario ON usuario.codigo = h_ticket.usr
        LEFT JOIN usuario asignado ON asignado.codigo = h_ticket.asignado
        LEFT JOIN tb_Cat_puestos pu ON pu.id_puesto = canal
        WHERE folio = '$folio'";

        return $this->db->query($qry)->result();
    }



    function asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus, $canal)
    {
        $this->db->set('usr_asignado', $ingeniero);
        $this->db->set('fecha_asignado', $fecha);
        $this->db->set('hora_asignado', $hora);
        $this->db->set('estatus', $estatus);
        $this->db->set('canal_atencion', $canal);
        $this->db->where('folio', $folio);
        $this->db->update('ticket');      

    }

    function cambiar_categoria($folio, $categoria)
    {
        $this->db->set('categoria', $categoria);
        $this->db->where('folio', $folio);
        $this->db->update('ticket');
    }

    function cambiar_estatus( $estatus, $pedido)
    {
        $this->db->set('estatus', $estatus);
        $this->db->where('id_pedido', $pedido);
        $this->db->update('tb_pedidos');

        $this->db->where('id' ,$estatus);
        return $this->db->get('tb_estatusPedido')->row();

    }

    function cerrar_ticket($folio, $fecha, $hora)
    {
        $this->db->set('estatus', 5);
        $this->db->set('fecha_cierre', $fecha);
        $this->db->set('hora_cierre', $hora);
        $this->db->where('folio', $folio);
        $this->db->update('ticket');
    }

    function editar_datosSolicitante($ticket, $update)
    {
        $this->db->where('folio', $ticket);
        $this->db->update('ticket',$update);
    }

    function subir_pdf($nuevoPdf)
    {
        $this->db->insert('Tb_Oficios_HelpDesk', $nuevoPdf); 
    }

    function h_asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus, $canal, $mensaje=null)
    {
        $this->folio = $folio;
        $this->usr = $this->session->userdata("codigo");
        $this->estatus = $estatus;
        $this->asignado = $ingeniero;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->canal = $canal;
        $this->mensaje = $mensaje;


        $this->db->insert('h_ticket', $this);
    }

    function h_cambiar_categoria($folio, $categoria, $fecha, $hora)
    {
        $this->folio = $folio;
        $this->usr = $this->session->userdata("codigo");
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->categoria = $categoria;

        $this->db->insert('h_ticket', $this);
    }

    function h_cambiar_estatus($update)
    {
        $this->db->insert('h_ticket', $update);
    }

    function h_cerrar_ticket($folio, $usr, $fecha, $hora, $mensaje)
    {
        $this->folio = $folio;
        $this->usr = $usr;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->estatus = 5;
        $this->mensaje = $mensaje;

        $this->db->insert('h_ticket', $this);
    }

    function insertarCat_x_titulo($titulo)
    {
         $qry = "SELECT 
                id_tipoCat,
                nombre_categoria
                FROM crm.Tb_CatTipoCategoria
                INNER JOIN categoria_ticket
                WHERE tipo_Cat = id_tipoCat
                AND nombre_categoria = '$titulo'";
        
        return $this->db->query($qry)->row();
    }

    function notificacion()
    {
        
    }

    function mensaje($folio, $mensaje, $fecha, $hora, $nImg)
    {
        $this->folio = $folio;
        $this->usr = $this->session->userdata("codigo");
        $this->mensaje = $mensaje;
        $this->fecha = $fecha;
        $this->hora =  $hora;
        $this->img = $nImg;

        $this->db->insert('h_ticket', $this);
    }

   /* function noti_alta($reportante, $usuarioIncidente, $idIncidente, $notificacion)
    {
        $this->generador = $reportante;
        $this->ticket = $idIncidente;
        $this->receptor = $usuarioIncidente;
        $this->tipo = $notificacion;
        $this->vistoR = 1;

        $this->db->insert('crm.notificaciones', $this);

    }*/

    //***********************TABLAS **********************

    function lista_tickets_administrador()
    {
        $qry = '';
        $qry = "SELECT 
                distinct folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as nombreCompleto
                ,dep.nombre_dependencia as departamento
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,prioridad
                ,asignado.usuario usr_asignado
                ,ticket.estatus,
                f.oficio,
                f.foliador
                ,m.forma      
                from ticket
                LEFT JOIN  dependencias dep on dep.id_dependencia = ticket.departamento
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                LEFT JOIN Tb_Oficios_HelpDesk f on f.id_ticket = folio 
                LEFT JOIN tb_Cat_FormaReporte m ON m.id = ticket.tSolicitud
                ORDER BY folio DESC";
               
                return $this->db->query($qry)->result();
    }

    function lista_tickets_propios($usr)
    {
        $qry = '';
        $qry = "SELECT 
                distinct folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as nombreCompleto
                ,dep.nombre_dependencia as departamento
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,prioridad
                ,asignado.usuario usr_asignado
                ,ticket.estatus,
                f.oficio,
                f.foliador
                ,m.forma      
                from ticket
                LEFT JOIN  dependencias dep on dep.id_dependencia = ticket.departamento
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                LEFT JOIN Tb_Oficios_HelpDesk f on f.id_ticket = folio 
                LEFT JOIN tb_Cat_FormaReporte m ON m.id = ticket.tSolicitud
                WHERE usr_asignado =$usr
                ORDER BY folio DESC";
               
                return $this->db->query($qry)->result();
    }

        function lista_tickets_administrador_cerrados()
    {
        $qry = '';
        $qry = "SELECT 
                folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as nombreCompleto
                ,dep.nombre_dependencia as departamento
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,prioridad
                ,asignado.usuario usr_asignado
                ,ticket.estatus,
                f.oficio,
                f.foliador
                ,m.forma      
                from ticket
                LEFT JOIN  dependencias dep on dep.id_dependencia = ticket.departamento
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                LEFT JOIN Tb_Oficios_HelpDesk f on f.id_ticket = folio 
                LEFT JOIN tb_Cat_FormaReporte m ON m.id = ticket.tSolicitud
                WHERE est.id = 5
                ORDER BY folio DESC";
               
                return $this->db->query($qry)->result();
    }

    function lista_tickets_administrador_abiertos()
    {
        $qry = '';
        $qry = "SELECT 
                distinct folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as nombreCompleto
                ,dep.nombre_dependencia as departamento
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,prioridad
                ,asignado.usuario usr_asignado
                ,ticket.estatus
                ,f.oficio
                ,f.foliador
                ,m.forma                
                from ticket
                LEFT JOIN  dependencias dep on dep.id_dependencia = ticket.departamento
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                LEFT JOIN Tb_Oficios_HelpDesk f on f.id_ticket = folio 
                LEFT JOIN tb_Cat_FormaReporte m ON m.id = ticket.tSolicitud
                WHERE est.id != 5
                ORDER BY folio DESC";
               
                return $this->db->query($qry)->result();
    }

    function l_seguimientoTicketsPendientes()
    {
        $qry = '';
        $qry = "SELECT 
                ticket.folio
                ,fecha_inicio
                ,hora_inicio
                ,nombre_usr as nombreCompleto
                ,dep.nombre_dependencia as departamento
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,prioridad
                ,asignado.usuario usr_asignado
                ,ticket.estatus
                ,f.oficio
                ,f.foliador
                ,m.forma
                ,datediff(CURDATE(), max(h.fecha)) as diferencia 
                from ticket
                LEFT JOIN  dependencias dep on dep.id_dependencia = ticket.departamento
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                LEFT JOIN Tb_Oficios_HelpDesk f on f.id_ticket = folio 
                LEFT JOIN tb_Cat_FormaReporte m ON m.id = ticket.tSolicitud
                INNER JOIN h_ticket h
                where ticket.estatus >= 0
                and ticket.estatus != 5
                and ticket.folio = h.folio
                group by ticket.folio
                order by diferencia desc";
               
                return $this->db->query($qry)->result();
    }

    function lista_tickets_usuario($codigo)
    {
        $qry = '';
        $qry = "SELECT 
                folio
                ,fecha_inicio
                ,hora_inicio
                ,us.usuario
                ,titulo
                ,Tb_CatTipoCategoria.nombre_tipoCat as categoria
                ,est.id as id_situacion
                ,est.situacion
                ,fecha_asignado
                ,hora_asignado
                ,asignado.usuario usr_asignado
                ,ticket.estatus
                from ticket
                LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
                LEFT JOIN Tb_CatTipoCategoria on Tb_CatTipoCategoria.id_tipoCat = ticket.categoria
                LEFT JOIN situacion_ticket est on est.id = ticket.estatus
                LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
                WHERE usr_incidente = '$codigo'
                ORDER BY folio DESC";

                return $this->db->query($qry)->result();
    }

    function obtPdf($folio)
    {
        $this->db->where('id_ticket', $folio);
        $this->db->where('tipo', 1);

        return $this->db->get('Tb_Oficios_HelpDesk')->row();
    }

    function obtAdjunto($folio)
    {
        $this->db->where('id_ticket', $folio);
        $this->db->where('tipo', 3);

        return $this->db->get('Tb_Oficios_HelpDesk')->result();
    }

    function obt_activos() 
    {
        return $this->db->get('Tb_Cat_Activos')->result();
    }

    //******************************** FECHAS **********************************************/   
        
    function fecha_a_sql($date){
        $fecha = explode("/",$date);
        $fecha_sql = $fecha['2']."-".$fecha['0']."-".$fecha['1'];
        return $fecha_sql;
    }
    
    function fecha_a_form($date){
        $fecha = explode("-",$date);
        $fecha_sql = $fecha['1']."/".$fecha['2']."/".$fecha['0'];
        return $fecha_sql;
    }
    
    function fecha_actual(){
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        return $fecha;
    }
    
      function hora_actual(){
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }
    function fechahora_actual(){
        date_default_timezone_get("America/Mexico_City");
        $fecha = date("Y-m-d h:i:s");
        return $fecha;
    }
    
    function fecha_text($datetime)
    {
        if($datetime == "0000-00-00 00:00:00"){
            return "Fecha indefinida";
        }else{
            
        $dia = explode(" ",$datetime);
        $fecha = explode("-",$dia[0]);
            if($fecha[1] == 1){
                $mes = 'enero';
            }else if($fecha[1] == 2){
                $mes = 'febrero';
            }else if($fecha[1] == 3){
                $mes = 'marzo';
            }else if($fecha[1] == 4){
                $mes = 'abril';
            }else if($fecha[1] == 5){
                $mes = 'mayo';
            }else if($fecha[1] == 6){
                $mes = 'junio';
            }else if($fecha[1] == 7){
                $mes = 'julio';
            }else if($fecha[1] == 8){
                $mes = 'agosto';
            }else if($fecha[1] == 9){
                $mes = 'septiembre';
            }else if($fecha[1] == 10){
                $mes = 'octubre';
            }else if($fecha[1] == 11){
                $mes = 'noviembre';
            }else if($fecha[1] == 12){
                $mes = 'diciembre';
            }
            
            $hora = explode(":",$dia[1]);
            
            $time = $hora[0].":".$hora[1]." Hrs";
            
            $fecha2 = $fecha[2]." ".$mes." ".$fecha[0];
            return $fecha2." a las ".$time ;
        }
    }
    
    function fecha_text_f($datetime)
    {
        if($datetime == "0000-00-00"){
            return "Fecha indefinida";
        }else{
            
        $fecha = explode("-",$datetime);
            if($fecha[1] == 1){
                $mes = 'enero';
            }else if($fecha[1] == 2){
                $mes = 'febrero';
            }else if($fecha[1] == 3){
                $mes = 'marzo';
            }else if($fecha[1] == 4){
                $mes = 'abril';
            }else if($fecha[1] == 5){
                $mes = 'mayo';
            }else if($fecha[1] == 6){
                $mes = 'junio';
            }else if($fecha[1] == 7){
                $mes = 'julio';
            }else if($fecha[1] == 8){
                $mes = 'agosto';
            }else if($fecha[1] == 9){
                $mes = 'septiembre';
            }else if($fecha[1] == 10){
                $mes = 'octubre';
            }else if($fecha[1] == 11){
                $mes = 'noviembre';
            }else if($fecha[1] == 12){
                $mes = 'diciembre';
            }
            
            
            $fecha2 = $fecha[2]." ".$mes." ".$fecha[0];
            return $fecha2 ;
        }
    }
    
    function hora_fecha_text($dia)
    {
        $dia2 = explode(" ",$dia);
        
        if($dia2[0] == "0000-00-00"){
            $fecha2 = "Termino indefinido";
        }else{
            $fecha = explode("-",$dia2[0]);
            if($fecha[1] == 1){
                $mes = 'enero';
            }else if($fecha[1] == 2){
                $mes = 'febrero';
            }else if($fecha[1] == 3){
                $mes = 'marzo';
            }else if($fecha[1] == 4){
                $mes = 'abril';
            }else if($fecha[1] == 5){
                $mes = 'mayo';
            }else if($fecha[1] == 6){
                $mes = 'junio';
            }else if($fecha[1] == 7){
                $mes = 'julio';
            }else if($fecha[1] == 8){
                $mes = 'agosto';
            }else if($fecha[1] == 9){
                $mes = 'septiembre';
            }else if($fecha[1] == 10){
                $mes = 'octubre';
            }else if($fecha[1] == 11){
                $mes = 'noviembre';
            }else if($fecha[1] == 12){
                $mes = 'diciembre';
            }
            
            $fecha2 = $fecha[2]." de ".$mes." del ".$fecha[0];
        }
        return $fecha2;
    }

    function etiqueta($estatus)
    {
        if($estatus == 0){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-warning badge-pill mb-2"><i class="fa  fa-warning"></i> Sin Estado!</span>';
            return $esta;
        }
        if($estatus == 1){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-primary badge-pill mb-2"><i class="fa fa-ticket"></i> Abierto</span>';
            return $esta;
        }
        if($estatus == 2){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-pink badge-pill mb-2"><i class="fa fa-user-plus"></i> Asignado</span>';
            return $esta;
        }
          if($estatus == 3){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-info badge-pill mb-2"><i class="fa fa-spinner"></i> En Proceso</span>';
            return $esta;
        }
          if($estatus == 4){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-success badge-pill mb-2"><i class="fa fa-check-circle"></i> Resuelto</span>';
            return $esta;
        }
            if($estatus == 5){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-danger badge-pill mb-2"><i class="fa fa-lock"></i> Cerrado</span>';
            return $esta;
        }
           if($estatus == 6){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-secondary badge-pill mb-2"><i class="fa  fa-hourglass-2" ></i> Pendiente</span>';
            return $esta;
        }
           if($estatus == 7){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-warning badge-pill mb-2"><i class="fa  fa-random"></i> Reasignado</span>';
            return $esta;
        }
        if($estatus == 8){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-danger badge-pill mb-2"><i class="fa  fa-close"></i> Cancelado </span>';
            return $esta;
        }
        if($estatus == 9){
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge bg-green badge-pill mb-2"><i class="fa  fa-map-signs"></i> Canalizado</span>';
            return $esta;
        }
    }

    function asignados($id, $canal)
    {
        $puesto = $this->session->userdata("puesto");
        if ($canal == $puesto) {
            if ($id == '') {
                $asig = '<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Asignar</button>';
            }
        else{
                $asig = '<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal" title="Reasignar Ingeniero"><i class="fa fa-exchange "></i> </button>';
            }
        }else{
            $asig = '<button class="btn btn-sm btn-default" disabled><i class="fa fa-plus"></i> Asignar</button>';
        }
        return $asig;
    }

    function ext($ext)
    {
        if ($ext == "pdf" OR $ext == "PDF") {
            $src = '<img width="" src="src/img/pdf.png">';
            return $src;
        }
        if ($ext == "jpg" OR $ext == "JPG") {
            $src = '<img width="" src="src/img/jpg.png">';
            return $src;
        }
        if ($ext == "doc" OR $ext == "DOC" OR $ext == "docx" OR $ext == "DOCX") {
            $src = '<img width="" src="src/img/doc.png">';
            return $src;
        }
        if ($ext == "xls" OR $ext == "XLS" OR $ext == "xlsx" OR $ext == "XLSX") {
            $src = '<img width="" src="src/img/xls.png">';
            return $src;
        }
        if ($ext == 'ppt'OR $ext == "PPT" OR $ext == 'pptx' or $ext == "PPTX") {
           $src = '<img width="" src="src/img/ppt.png">';
            return $src; 
        }


    }

    function timeline($mensaje, $fecha)
    {
        if ($fecha != 1) {
            $fecha = $this->m_ticket->hora_fecha_text($mensaje->fecha); ?>
            
            <li class="time-label">
                <span class="bg-red">
                    <?=$fecha?>
                </span>
            </li> <?   
        }
        else{} 
        if (isset($mensaje->categoria)) { ?>
            <li>
                <i class="fa fa-tags bg-orange"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                    <h3 class="timeline-header"><a href="#">Cambio de Categoria:</a> <b> <?=$mensaje->usuario?></b> Cambio la categoria a <b><?=$mensaje->categoria?> </b>
                </div>
            </li> <?
        }

        if (isset($mensaje->situacion)) {
            if (isset($mensaje->asignado)) {
                if ($mensaje->situacion != 'Resuelto') { ?>
                    <li>
                        <i class="fa fa-user bg-pink"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o">    </i> <?=$mensaje->hora?></span>
                            <h3 class="timeline-header"><a href="#">El ticket ha sido Asignado a: <?=$mensaje->asignado?> </a></h3>          
                        </div>
                    </li><?
                }
            }
            if ($mensaje->situacion == 'Cerrado') { ?>
                <li>
                    <i class="fa fa-lock bg-red"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                        <h3 class="timeline-header"><a href="#"></a> <b> <?=$mensaje->usuario?></b> Cerró el ticket<b>mensaje: </b> </h3>
                        <div class="timeline-body bg-gray ">
                            <?=$mensaje->mensaje?>                
                        </div>
                    </div>
                </li> <?
            }
            if ($mensaje->situacion == 'Canalizado') { ?>
                <li>
                    <i class="fa fa-map-signs bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                        <h3 class="timeline-header"><a href="#"></a> <b> <?=$mensaje->usuario?></b> Canalizo el incidente a <b> <?=$mensaje->nombre_canal?> </b> </h3>
                        <div class="timeline-body bg-gray ">
                            <?=$mensaje->mensaje?>                
                        </div>
                    </div>
                </li> <?
            }
            if ($mensaje->situacion == 'Resuelto') { ?>
                    <li>
                        <i class="fa fa-check-circle bg-success"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                            <h3 class="timeline-header"><a href="#">Cambio de Estatus</a> <b> <?=$mensaje->usuario?></b> Cambio es estatus del incidente a <b> <?=$mensaje->situacion?> </b> </h3>
                        </div>
                    </li> <?
                }
            if ($mensaje->situacion == 'En Proceso') { ?>
                    <li>
                        <i class="fa fa-spinner bg-info"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                            <h3 class="timeline-header"><a href="#">Cambio de Estatus</a> <b> <?=$mensaje->usuario?></b> Cambio es estatus del incidente a <b> <?=$mensaje->situacion?> </b> </h3>
                        </div>
                    </li> <?
                }
            if ($mensaje->situacion == 'Pendiente') { ?>
                    <li>
                        <i class="fa fa-hourglass-2 bg-grey"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                            <h3 class="timeline-header"><a href="#"></a> <b> <?=$mensaje->usuario?></b> marcó <b> <?=$mensaje->situacion?> </b> el servicio </h3>
                        </div>
                    </li> <?
                }
            if ($mensaje->situacion == 'Cancelado') { ?>
                    <li>
                        <i class="fa fa-close bg-red"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                            <h3 class="timeline-header"><a href="#"></a> <b> <?=$mensaje->usuario?></b> <b>Canceló </b> el servicio </h3>
                        </div>
                    </li> <?
                }
            else {

            }
        }
        else {
            if (isset($mensaje->mensaje)) { ?>
                <li>
                    <i class="fa fa-comment bg-purple"></i>
                    <div class="timeline-item bg-default ">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=$mensaje->hora?></span>
                        <h3 class="timeline-header btn-default"><a href="">Mensaje:</a> <b> <?=$mensaje->usuario?></b> Dice: </h3>
                        <div class="timeline-body bg-gray ">
                            <? if($mensaje->img != '') {
                                    $ext = explode('.',$mensaje->img);
                                    $ext = $ext[count($ext) - 1];
                                    if($ext != 'jpg' AND $ext != 'png' AND $ext != 'jpeg') {
                                        $loguito = $this->m_ticket->ext($ext); 
                                    ?> <b>Archivos Adjuntos:</b>  <a target="_blank" href="src/oficios/att/<?=$mensaje->img?>" data-toggle="tooltip" title="ver archivo"><?=$loguito?></a><hr>
                                <?  } else{ 
                                      ?>
                                    <a target="_blank" href="src/oficios/att/<?=$mensaje->img?>" data-toggle="tooltip" title="ver imagen">
                                     <img width="200px" src="src/oficios/att/<?=$mensaje->img?>"></a> <hr> 
                                    <?}
                                 }?>
                            <?=$mensaje->mensaje?>                
                        </div>
                    </div>
                </li> <?
            }
        }
    }

    function prioridad($prioridad)
    {
        switch ($prioridad) {
            case '1':
                $respuesta = 'info';
                break;
            case '2':
                $respuesta = '';
                break;
            case '3':
                $respuesta = 'warning';
                break;
            case '4':
                $respuesta = 'danger';
                break;
            
            default:
                $respuesta = '';
                break;
        }

        return $respuesta;
    }


    public function SendTelegram($ticket, $idIncidente)
    {
        //Roland IA
        $apiToken = "782921076:AAG9TTAb7KX0B5TJxEVEGinKuajUrSbYAAg";
        $horario = $this->m_ticket->hora_actual();
        $fechaHora = $ticket['fecha_inicio']. ' ' . $ticket['hora_inicio'];
        $fecha = $this->m_ticket->fecha_text($fechaHora);
        $saludo = '';
        $canal = $ticket['canal_atencion'];
        $escribiente = $this->session->userdata("usuario");
        $area = '';

        if ($ticket->prioridad == 4) {
            $prioridad = "<b> SE PRECISA URGENTE! </b>";
        }
        if ($ticket->prioridad == 3) {
            $prioridad = "<b> DE IMPORTANCIA ALTA! </b>";
        }

        switch ($canal) {
            case '1':
                $area = "Dirección TI";
                break;
            case '2':
                $area = "Sistemas";
                break;
            case '3':
                $area = "Centro de Operaciones Tecnológicas";
                break;
            case '4':
                $area = "Soporte Técnico";
                break;            
            default:
                $area = "---";
                break;
        }

        if($horario <= '11:59:59'){
            $saludo = 'Buenos días.';
        }
        elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes.';
        }
        elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches.';
        }

        $mensaje = $saludo .'
Se ha levantado un nuevo ticket de servicio con la siguiente información:

<b># SERVICIO:</b> ' . $idIncidente . '
<b>ASUNTO:</b> ' . $ticket['titulo'] . '
<b>DESCRIPCION:</b> ' . strip_tags($ticket['descripcion']) . '
<b>FECHA DE REPORTE: </b>' . $fecha .'
<b>CAPTURADO POR:</b> '. $escribiente .'

Se canalizo automaticamente con <b>' . $area . ' </b>

Se Agradece su atención.';

 //die(var_dump($mensaje));


        $data = [
            'chat_id' => '-1001460198987',  
            //'chat_id' => '591531437_6135385119973428661',
            'text' => $mensaje,
            'parse_mode' => 'HTML'
        ];

        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
    }

    public function sendTelegram_asignado($tg, $folio)
    {

        //Roland IA
        $apiToken = "782921076:AAG9TTAb7KX0B5TJxEVEGinKuajUrSbYAAg";
        $horario = $this->m_ticket->hora_actual();    
        $id_tg = $tg->tg_user;  
        $ticket = $this->m_ticket->seguimiento_ticket($folio);
        $saludo = '';
        if($horario <= '11:59:59'){
            $saludo = 'Buenos días.';
        }
        elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes.';
        }
        elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches.';
        }

        $mensaje = $saludo .'
Se te ha asignado el ticket de servicio <b> #' . $folio . ' </b>:
    
<b>SOLICITA: </b>' . $ticket->usuario .'
<b>ÁREA: </b> '. $ticket->nombre_dependencia .'
<b>EXTENSIÓN: </b>' .$ticket->extension .'
<b>UBICACIÓN: </b>' . $ticket->ubicacion .'
-------------------------------
Datos de Servicio:

<b>ASUNTO: </b> '. $ticket->titulo . '
<b>DESCRIPCIÓN </b> '.  strip_tags($ticket->descripcion) .' 

Saludos :)';


        $data = [
            'chat_id' => $id_tg,  
            //'chat_id' => '591531437_6135385119973428661',
            'text' => $mensaje,
            'parse_mode' => 'HTML'
        ];

        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );    
    }

    public function SendTelegram1()
    {
          //Roland IA
        $apiToken = "867232459:AAGRKQwjqdeXFENj_b0okBwI9-ai1WeMGqY";
        $horario = $this->m_ticket->hora_actual();    
        
        
       
        $mensaje = '
Se te ha asignado el ticket de servicio <p>';


        $data = [
            'chat_id' => '913700',  
            //'chat_id' => '591531437_6135385119973428661',
            'text' => strip_tags($mensaje),
            'document' => 'https://ugeek.github.io/blog/images-blog/telegram2org.png',
            'caption' => 'holi', 
            'parse_mode' => 'HTML'
        ];

        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendDocument?" . http_build_query($data) );    
    }




    public function sendTelegram_canal($nCanal, $user, $folio)
    {
        $apiToken = "782921076:AAG9TTAb7KX0B5TJxEVEGinKuajUrSbYAAg";
        $horario = $this->m_ticket->hora_actual();    
        $saludo = '';
        if($horario <= '11:59:59'){
            $saludo = 'Buenos días.';
        }
        elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes.';
        }
        elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches.';
        }

        $mensaje = 'ATENCION!!!
<b>'. $user .'</b> ha canalizado el incidente con el numero de servicio: <b>' . $folio . '</b> a <b>' . $nCanal->nombrePuesto. '</b>
Favor de dar seguimiento.' ;


        $data = [
            'chat_id' => '-1001460198987',  
            //'chat_id' => '591531437_6135385119973428661',
            'text' => $mensaje,
            'parse_mode' => 'HTML'
        ];

        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );   
    }

    public function sendTelegram_chat($folio, $mensaje)
    {
        $apiToken = "782921076:AAG9TTAb7KX0B5TJxEVEGinKuajUrSbYAAg";
        $horario = $this->m_ticket->hora_actual();    
        $user = $this->session->userdata("usuario");
        $mensaje = '<b>' . $user . '</b> Dice:
' . $mensaje .'
en el servicio #<b>'. $folio. '</b>

<a href="https://10.15.16.227/helpDesk/index.php/ticket/seguimiento/'. $folio.'">Respoder</a>';


        $data = [
            'chat_id' => '-1001460198987',   
            //'chat_id' => '591531437_6135385119973428661',
            'text' => $mensaje,
            'parse_mode' => 'HTML'
        ];

        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );   
    }

    public function bonndia()
    {
        $clima = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/weather?id=8133378&APPID=731ac0d3caf3cd694ce7a8df5d1c278b&units=metric&lang=es"));

        //$clima = json_decode($respuesta);
        $datosClima = $clima->main;
        $datosGen   = $clima->weather;
        $temperatura = $datosClima->temp;
        //$descripcion    = $datosGen->description;

        echo $temperatura;
    }

}