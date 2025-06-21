$(document).ready(function () {
  $("#formCadastroItem").on("submit", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
      url: "../actions/item_register.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        $("#alertContainer").html(`
          <div class="alert alert-${response.status} alert-dismissible fade show" role="alert">
            ${response.message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        `);

        if (response.status === "success") {
          $("#formCadastroItem")[0].reset();
        }
      },
      error: function () {
        $("#alertContainer").html(`
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Erro na comunicação com o servidor.
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        `);
      },
    });
  });
});
