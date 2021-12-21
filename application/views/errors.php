<script>
function validar() {


    Swal.fire({
        title: 'Ingresa el ID de la compra',
        input: 'number',
        showCancelButton: false,
        confirmButtonText: 'Validar Pedido',
        showLoaderOnConfirm: true,
        preConfirm: (idVenta) => {
            return fetch(`./stripe/validaId?idVenta=${idVenta}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.mensaje)
                    }
                    return response.json()
                })
                .catch(error => {
                    console.log(error);
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.value.error) {
            Swal.fire({
                confirmButtonText: 'reintentar',
                html: `
                <div class="swal2-validation-message" 
                    id="swal2-validation-message" style="display: flex;">
                        Error en la solicitud: ${result.value.mensaje}
                    </div>`
            }).then((r) => {
                validar();
            })
        }
        else{
            window.location.href = `<?=base_url()?>?id=${result.value.id}`;
        }
    });
}
</script>