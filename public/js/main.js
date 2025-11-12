document.addEventListener("DOMContentLoaded", () => {
  const botoes = document.querySelectorAll(".btn-inscrever");
  const modal = document.getElementById("modalPlano");
  const fecharModal = document.getElementById("fecharModal");
  const modalTitulo = document.getElementById("modalTitulo");

  // Abrir modal e marcar plano selecionado
  botoes.forEach(btn => {
    btn.addEventListener("click", e => {
      const card = e.target.closest(".card");
      document.querySelectorAll(".card").forEach(c => c.classList.remove("selecionado"));
      card.classList.add("selecionado");

      const nomePlano = card.dataset.plano;
      modalTitulo.textContent = `Inscrição no Plano ${nomePlano}`;
      modal.classList.remove("hidden");
    });
  });

  // Fechar modal
  fecharModal.addEventListener("click", () => {
    modal.classList.add("hidden");
    document.querySelectorAll(".card").forEach(c => c.classList.remove("selecionado"));
  });

  // Fechar clicando fora
  modal.addEventListener("click", e => {
    if (e.target === modal) {
      modal.classList.add("hidden");
      document.querySelectorAll(".card").forEach(c => c.classList.remove("selecionado"));
    }
  });
});
