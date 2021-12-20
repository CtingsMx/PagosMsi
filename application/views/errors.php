

<script>
    Swal.fire({
  title: 'Ingresa el ID de la compra',
  input: 'number',
  showCancelButton: false,
  confirmButtonText: 'Validar Pedido',
  showLoaderOnConfirm: true,
  preConfirm: (idVenta) => {
    return fetch(`./stripe/validaId/${idVenta}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(response.mensaje)
        }
        return response.json()
      })
      .catch(error => {
        Swal.showValidationMessage(
          `Request failed: ${error}`
        )
      })
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: `${result.value.idVenta}'s avatar`,
      imageUrl: result.value.avatar_url
    })
  }
})
</script>