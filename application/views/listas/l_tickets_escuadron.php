<?
$estados = $this->m_ticket->estatus();
?>

 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <div class="page-heading">
                <h1 class="page-title">Escuadron </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-2.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Escuadrones</li>
                  
                </ol>
                <br>
    <a href="javascript:history.back(1)" class="btn btn-blue btn-icon-only btn-lg"><i class="fa fa-arrow-left"></i></a>
   
    </div>
  <!-- Main content -->
  <section class="page-content fade-in-up">

    <div class="ibox">
                    <div class="ibox-body">
                        <h5 class="font-strong mb-4">Resumen de escuadron</h5>
                        <div class="flexbox mb-4">
                            <div class="flexbox">
                                <label class="mb-0 mr-2"></label>
                             
                            </div>
                            <div class="input-group-icon input-group-icon-left mr-3">
                                <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                                <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Buscar ...">
                            </div>
                        </div>
                        <div class="table-responsive row">
                            <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                              <table class="table table-bordered table-hover dataTable no-footer dtr-inline" id="datatable" role="grid" aria-describedby="datatable_info" style="width: 1042px;">
                                <thead class="thead-default thead-lg">
                                    <tr role="row">
                                      <th>
                                       Nombre
                                    </th>
                                    <th>
                                       Asignados
                                    </th>
                                    <th >
                                      Proceso
                                    </th>
                                    <th>
                                       Resueltos
                                    </th>
                                    <th>
                                      Cerrados</th>
                                    <th>
                                        Pendientes
                                    </th>

                                    <th class="no-sort sorting_disabled" rowspan="1" colspan="1" style="width: 33.8667px;" aria-label="">
                                        
                                      </th>
                                    </tr>
                                </thead>
                                
          <tbody>
           <? foreach ($usuarios as $usuario) 
           {
            
            ?>
            <tr class="" align="center">
              <td ><?=$usuario->nombre_completo?></td>
              <td ><b><?= $usuario->asignados + $usuario->reasignados ?> </b> </td>
              <td ><b><?=$usuario->proceso?></b></td>
              <td ><b><?=$usuario->resueltos?></b></td>
              <td ><b><?=$usuario->cerrados?></b></td>
              <td ><b><?=$usuario->pendientes?></b></td>
              <td width="10" align="center"><a class="btn btn-sm btn-default" href="<?=base_url()?>index.php?/escuadron/tickets/<?=$usuario->codigo?> "    data-toggle="tooltip" title="lista de tickets del usario"><i class="fa fa-eye"></i> </a>
              </td>
            </tr>
           <?
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

