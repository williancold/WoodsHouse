document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formCadastroItem");
  const alertBox = document.getElementById("alertMessage");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      alertBox.classList.add("d-none");
      alertBox.innerHTML = "";

      const formData = new FormData(form);

      fetch("../actions/item_register.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alertBox.className = "alert alert-success";
            alertBox.innerText = data.message;
            form.reset();

            setTimeout(() => {
              $("#modalCadastroItem").modal("hide");
              alertBox.classList.add("d-none");
            }, 2000);
          } else {
            alertBox.className = "alert alert-danger";
            alertBox.innerText = data.message;
          }
        })
        .catch((err) => {
          console.error(err);
          alertBox.className = "alert alert-danger";
          alertBox.innerText = "Erro ao conectar com o servidor.";
          alertBox.classList.remove("d-none");
        });
    });
  }
});
