document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formCadastroItem");
  const mensagem = document.getElementById("mensagem");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const response = await fetch("../actions/item_register.php", {
      method: "POST",
      body: formData,
    });

    const result = await response.json();
    mensagem.classList.remove("d-none", "alert-danger", "alert-success");

    if (result.success) {
      mensagem.classList.add("alert-success");
      mensagem.innerText = result.message;
      form.reset();
    } else {
      mensagem.classList.add("alert-danger");
      mensagem.innerText = result.message;
    }
  });
});
