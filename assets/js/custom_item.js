$("#formCadastroItem").on("submit", function (e) {
  e.preventDefault();

  const formData = $(this).serialize();

  $.post(
    "../actions/item_register.php",
    formData,
    function (response) {
      $("#alertContainer").html(`
            <div class="alert alert-${response.status}" role="alert">
                ${response.message}
            </div>
        `);

      if (response.status === "success") {
        $("#formCadastroItem")[0].reset();
      }
    },
    "json"
  );
});
