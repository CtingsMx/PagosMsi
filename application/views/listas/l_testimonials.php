<section id="page-title">
  <div class="container clearfix" align="center">
    <h1>Administración de Testimoniales</h1>
  </div>
</section>

<section id="content">
  <div class="content-wrap">
    <div class="container clearfix">
      
        <div class="row">
            <div class="col-xs-12 text-right">
                <button type="button" class="btn btn-primary"  id="new-testimonial">
                    Nuevo Testimonial
                </button>
                <br/><br/>
            </div>
        </div>


        <div class="table-responsive">
        
        <table id="datatable1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
            <tr role="row">
              <th>Foto</th>
              <th>Nombre</th>
              <th>Testimonial</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($testimonials as $t) { ?>
                <tr width="10px" align="center" class="">
                    <td><img src="/<?= $t->photo ?>" width="100px" alt="Foto Principal"></td>
                    <td><?= $t->name ?></td>
                    <td><?= $t->testimonial ?></td>
                    <td>
                        <a class="btn btn-warning btn-edit-testimonial" data-id="<?php echo $t->id; ?>" href="javascript:void(0);">
                            <i class="icon icon-pencil"></i>
                        </a>
                        <a class="btn btn-danger btn-delete-testimonial" data-id="<?php echo $t->id; ?>" href="javascript:void(0);">
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
<div class="modal fade" id="testimonialFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="testimonialForm" action="/admin/submitTestimonial">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Administrar Testimoniales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Foto *</label>
                    <input type="file" class="form-control-file" name="photo">
                    <img src="" id="photo-preview" class="img-responsive hidden"/>
                    <small class="form-text text-muted">Seleccione la imagen a utilizar, medidas recomendadas: 112px * 112x</small>
                </div>
                <div class="form-group">
                    <label>Nombre *</label>
                    <input type="text" name="name" class="form-control" placeholder="" />
                    <small class="form-text text-muted">Nombre de quien proporciona el testimonio.</small>
                </div>
            
                <div class="form-group">
                    <label>Testimonial *</label>
                    <input type="text" class="form-control" placeholder="" name="testimonial"/>
                    <small class="form-text text-muted">Texto testimonial.</small>
                </div>

                <div class="alert alert-danger hidden" role="alert"></div>
                <div class="alert alert-success hidden" role="alert">El testimonial ha sido almacenado correctamente.</div>
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
        $('.btn-delete-testimonial').click(function(){
            var id = $(this).attr("data-id");

            if(confirm("¿Estás seguro de eliminar este testimonial?")){
                location.href="/admin/testimonialDelete/"+id;
            }
        });

        // Edit Modal:
        $('.btn-edit-testimonial').click(function(){
            var id = $(this).attr("data-id");
            // Get record:
            $.getJSON( "/admin/testimonial/"+id, function( data ) {
                $('#testimonialFormModal [name="name"]').val(data.name);
                $('#testimonialFormModal [name="testimonial"]').val(data.testimonial);
                $('#testimonialFormModal [name="id"]').val(data.id);
                $('#photo-preview').attr('src', "/"+data.photo);
                $('#photo-preview').removeClass("hidden");
                $('#testimonialFormModal').modal('show');
            });
        });


        // Insert Modal:
        $('#new-testimonial').click(function(){
            document.getElementById('testimonialForm').reset();
            $('#photo-preview').addClass("hidden");            
            $('#testimonialFormModal').modal('show');
            $('[name="id"]').val("");
        });




        $('#testimonialForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $('#testimonialForm .alert-danger').addClass("hidden");
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
                    $('#testimonialForm .alert-danger').text(res.errors[0]);
                    $('#testimonialForm .alert-danger').removeClass("hidden");
                } else {
                    $('#testimonialForm .alert-success').removeClass("hidden");
                    location.reload();
                }
            });
        });
    });
</script>