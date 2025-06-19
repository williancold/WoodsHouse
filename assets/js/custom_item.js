$(document).ready(function () {
  $("#formCadastroItem").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../actions/item_create.php",
      data: $(this).serialize(),
      dataType: "json",
      success: function (res) {
        if (res.status === "ok") {
          alert("Item cadastrado com sucesso!");
          $("#modalCadastroItem").modal("hide");
          $("#formCadastroItem")[0].reset();
        } else {
          alert("Erro: " + res.message);
        }
      },
    });
  });
});
