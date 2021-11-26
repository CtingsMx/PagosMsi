<?
$estados = $this->m_ticket->estatus();
?>

 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <div class="page-heading">
                <h1 class="page-title">Lista de Tickets: <?=$titulo?></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-2.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Tickets</li>
                    <li class="breadcrumb-item">Lista de Tickets</li>
                </ol>
                <br>
    <a href="<?=base_url()?>" class="btn btn-blue btn-icon-only btn-lg"><i class="fa fa-arrow-left"></i></a>
    <a href="<?=base_url()?>index.php?/ticket/nuevo_ticket" class="btn btn-warning btn-icon-only btn-lg "><span class="fa fa-plus"></span></a>
    </div>
  <!-- Main content -->
  <section class="page-content fade-in-up">

    <div class="ibox">
                    <div class="ibox-body">
                      <span>PRIORIDAD DE LOS SERVICIOS: </span>
                      <span class="badge badge-info"> BAJA </span>
                      <span class="badge badge-secondary"> NORMAL </span>
                      <span class="badge badge-warning"> ALTA </span>
                      <span class="badge badge-danger"> ¡URGENTE! </span>
                        <div class="flexbox mb-4">
                            <div class="flexbox">
                               
                                <div class="btn-group bootstrap-select show-tick form-control" style="width: 150px;"></div>
                            </div>
                            <div class="input-group-icon input-group-icon-left mr-3">
                                <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                                <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Buscar ...">
                            </div>
                        </div>
                        <div class="table-responsive row">
                            <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                              <table class="table table-bordered table-hover  no-footer" id="datatable" role="grid" aria-describedby="datatable_info" >
                                <thead class="thead-default thead-lg">
                                  <tr role="row">
                                    <th>
                                        #Servicio
                                    </th>
                                    <th>
                                      Medio Reporte
                                    </th>
                                    <th>
                                      Oficio
                                    </th>                                    
                                    <th>
                                       Fecha Reporte
                                    </th>
                                    <th>
                                       Departamento
                                    </th>
                                    <th>
                                      Incidente</th>
                                    <th >
                                        Categoria
                                    </th>
                                    <th >
                                     Dias sin atención
                                    </th>
                                    <th>
                                      Estatus
                                    </th>

                        
                                  </tr>
                                </thead>

                                <tbody>
                                  <? foreach ($tickets as $ticket) 
                                   {
                                    $fecha = $this->m_ticket->fecha_text_f($ticket->fecha_inicio);
                                    $estatus = $this->m_ticket->etiqueta($ticket->id_situacion);
                                    $prioridad = $this->m_ticket->prioridad($ticket->prioridad);
                                    
                                    if($ticket->diferencia > 1){?>
                                    
                                    <tr class="<?=$prioridad?>">
                                      <td ><?=$ticket->folio?></td>
                                      <td><?=$ticket->forma?></td>
                                      <td><?
                                        if ($ticket->oficio != '') {?>
                                          <?=$ticket->oficio?> <b> <br>Folio: </b> <?=$ticket->foliador?>
                                        <?}?>
                                      </td>
                                      <td  data-toggle = "tooltip" title="Hora de reporte: <?=$ticket->hora_inicio?>"><?=$fecha?></td>                             
                                      <td data-toggle = "tooltip" title="Reportado por: <?=$ticket->nombreCompleto?>" >
                                        <?=$ticket->departamento?>
                                        <span class="hidden"><?=$ticket->nombreCompleto?></span>
                                        </td>
                                      <td data-toggle = "tooltip" title="atendido por: <?=$ticket->usr_asignado?>" >
                                        <?=$ticket->titulo?>
                                          <span class="hidden"><?=$ticket->usr_asignado?></span>
                                        </td>
                                      <td ><?=$ticket->categoria?></td>
                                      <td><b><?=$ticket->diferencia?> días</b></td>

                                      <td align="center"><a href="<?=base_url()?>index.php?/ticket/seguimiento/<?=$ticket->folio?>" target="_blank" title="seguimiento del Ticket"><?=$estatus?></a></td>
                                      
                                    </tr>
                                
                                  <?
                                    }
                                  }
                                  ?>
                                    </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                       </div></div>
                        </div>
                    </div>
                </div>

  </section>


 <script>
        $(function() {
            $('#datatable').DataTable({
                pageLength: 10,
                fixedHeader: true,
                responsive: true,
                "sDom": 'rtip',
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
            var table = $('#datatable').DataTable();
            $('#key-search').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#type-filter').on('change', function() {
                table.column(2).search($(this).val()).draw();
            });
        });
    </script>

