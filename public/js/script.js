// Interatividade para os status
document.addEventListener("DOMContentLoaded", function () {
  const statusOptions = document.querySelectorAll(".status-option");

  statusOptions.forEach((option) => {
    option.addEventListener("click", function () {
      // Remove a classe selected de todos
      statusOptions.forEach((opt) => opt.classList.remove("selected"));
      // Adiciona a classe selected ao clicado
      this.classList.add("selected");
    });
  });

  // Validação do formulário
  document
    .getElementById("productForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const productName = document.getElementById("productName").value;
      const productPrice = document.getElementById("productPrice").value;

      if (!productName || !productPrice) {
        alert("Por favor, preencha todos os campos obrigatórios!");
        return;
      }

      // Simulação de cadastro bem-sucedido
      alert("Produto cadastrado com sucesso!");
      this.reset();

      // Reset do status para Ativo
      statusOptions.forEach((opt) => opt.classList.remove("selected"));
      document.querySelector(".status-active").classList.add("selected");
    });
});

// Auto-fechar alertas de sucesso após 5 segundos
document.addEventListener("DOMContentLoaded", function () {
  const alertas = document.querySelectorAll(".alert-success");
  alertas.forEach((alerta) => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alerta);
      bsAlert.close();
    }, 5000);
  });
});

// Validação do formulário de agendamento
document.querySelectorAll('form[method="POST"]').forEach((form) => {
  if (form.querySelector('input[name="agendar_aula"]')) {
    form.addEventListener("submit", function (e) {
      const senha = this.querySelector('input[name="senha_agendamento"]');
      if (senha && senha.value.length < 1) {
        e.preventDefault();
        alert("Por favor, digite sua senha para confirmar o agendamento.");
        senha.focus();
      }
    });
  }
});
