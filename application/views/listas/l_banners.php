<section id="page-title">
  <div class="container clearfix" align="center">
    <h1>Administración de Banners</h1>
  </div>
</section>

<section id="content">
  <div class="content-wrap">
    <div class="container clearfix">
      
        <div class="row">
            <div class="col-xs-12 text-right">
                <button type="button" class="btn btn-primary"  id="new-banner">
                    Nuevo Banner
                </button>
                <br/><br/>
            </div>
        </div>


        <div class="table-responsive">
        
        <table id="datatable1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
            <tr role="row">
              <th>Banner</th>
              <th>Sección</th>
              <th>Títulos</th>
              <th>Link</th>
              <th>Botón</th>
              <th>Fondo</th>
              <th>Editar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($banners as $b) { ?>
                <tr width="10px" align="center" class="">
                    <td><img src="/<?= $b->banner ?>" width="100px" alt="Foto Principal"></td>
                    <td><?= $b->seccion ?></td>
                    <td><?= htmlspecialchars($b->titulos) ?></td>
                    <td><?= $b->link ?></td>
                    <td><?= $b->boton ?></td>
                    <td><?= $b->fondo ?></td>
                    <td>
                        <a class="btn btn-warning btn-edit-banner" data-id="<?php echo $b->id; ?>" href="javascript:void(0);">
                            <i class="icon icon-pencil"></i>
                        </a>
                        <a class="btn btn-danger btn-delete-banner" data-id="<?php echo $b->id; ?>" href="javascript:void(0);">
                            <i class="icon icon-trash"></i>
                        </a>                        
                    </td>                    
                </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>




<!-- Form Modal --> >
<div class="modal fade" id="promoFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="promoForm" action="/admin/submitBanner">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Promociones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Banner *</label>
                    <input type="file" class="form-control-file" name="banner">
                    <img src="" id="banner-preview" class="img-responsive hidden"/>
                    <small class="form-text text-muted">Seleccione la imagen a utilizar, medidas recomendadas: 1920px * 700px</small>
                </div>
                <div class="form-group">
                    <label>Títulos *</label>
                    <textarea name="titulos" class="form-control" placeholder="" style="height:100px; resize:none;"></textarea>
                    <small class="form-text text-muted">Utilice elementos HTML: <code>&lt;h2&gt;Línea uno&lt;/h2&gt;</code></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sección *</label>
                            <select class="form-control form-control-lg" name="seccion">
                                <option value="">Seleccionar</option>
                                <option value="home">Home</option>
                                <option value="promos">Promociones</option>
                            </select>
                            <small class="form-text text-muted">Seleccione la sección donde se mostrará el banner.</small>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo de Fondo *</label>
                            <select class="form-control form-control-lg" name="fondo">
                                <option value="">Seleccionar</option>
                                <option value="dark">Oscuro</option>
                                <option value="light">Claro</option>
                            </select>
                            <small class="form-text text-muted">Si el fondo de la imagen es predominantemente oscuro, seleccione oscuro, de lo contrario, seleccione claro. Esto ayuda a contrastar los títulos con el color adecuado.</small>
                        </div>
                    </div>                    
                </diV>                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Texto del Botón *</label>
                            <input type="text" class="form-control" placeholder="" name="boton"/>
                            <small class="form-text text-muted">Texto corto para el botón, ejemplo: "Comprar Ahora", "Más detalles", etc.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Link del Botón *</label>
                            <input type="text" class="form-control" placeholder="" name="link"/>
                            <small class="form-text text-muted">Ingrese la liga a la que llevará el botón.</small>
                        </div>   
                    </div>
                </div>

                <div class="alert alert-danger hidden" role="alert"></div>
                <div class="alert alert-success hidden" role="alert">El banner ha sido almacenado correctamente.</div>
            </div>          
            
            <div class="modal-footer">  
                <input type="hidden" name="id" value=""/>            
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guadar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function(){
        // Delete:
        $('.btn-delete-banner').click(function(){
            var id = $(this).attr("data-id");

            if(confirm("¿Estás seguro de eliminar este banner?")){
                location.href="/admin/bannerDelete/"+id;
            }
        });

        // Edit Modal:
        $('.btn-edit-banner').click(function(){
            var id = $(this).attr("data-id");
            // Get record:
            $.getJSON( "/admin/banner/"+id, function( data ) {
                $('#promoFormModal [name="titulos"]').val(data.titulos);
                $('#promoFormModal [name="seccion"]').val(data.seccion);
                $('#promoFormModal [name="fondo"]').val(data.fondo);
                $('#promoFormModal [name="boton"]').val(data.boton);
                $('#promoFormModal [name="link"]').val(data.link);
                $('#promoFormModal [name="id"]').val(data.id);
                $('#banner-preview').attr('src', "/"+data.banner);
                $('#banner-preview').removeClass("hidden");
                $('#promoFormModal').modal('show');
            });
        });


        // Insert Modal:
        $('#new-banner').click(function(){
            document.getElementById('promoForm').reset();
            $('#banner-preview').addClass("hidden");            
            $('#promoFormModal').modal('show');
            $('[name="id"]').val("");
        });




        $('#promoForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $('#promoForm .alert-danger').addClass("hidden");
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false
            }).complete(function(r){
                var res = r.responseJSON;

                if(res && res.errors && res.errors.length > 0){
                    $('#promoForm .alert-danger').text(res.errors[0]);
                    $('#promoForm .alert-danger').removeClass("hidden");
                } else {
                    $('#promoForm .alert-success').removeClass("hidden");
                    location.reload();
                }
            });
        });
    });
</script>