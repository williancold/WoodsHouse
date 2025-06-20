document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formCadastroItem");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const nome = document.getElementById("nome").value.trim();
      const grupo_id = document.getElementById("grupo_id").value;
      const unidade_id = document.getElementById("unidade_id").value;

      if (!nome || !grupo_id || !unidade_id) {
        alert("Por favor, preencha todos os campos.");
        return;
      }

      const formData = new FormData(form);

      fetch("../actions/item_register.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert(data.message);
            form.reset();
            $("#modalCadastroItem").modal("hide");
            location.reload();
          } else {
            alert("Erro: " + data.message);
          }
        })
        .catch((error) => {
          console.error("Erro:", error);
          alert("Erro inesperado no envio.");
        });
    });
  }
});
