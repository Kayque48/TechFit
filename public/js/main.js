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

document.addEventListener("DOMContentLoaded", () => {
  const botoesTreino = document.querySelectorAll(".btn-ver-treino");
  const modalTreino = document.getElementById("modalTreino");
  const fecharModalTreino = document.getElementById("fecharTreinoModal");
  const tituloTreino = document.getElementById("tituloTreino");
  const descricaoTreino = document.getElementById("descricaoTreino");

  botoesTreino.forEach(btn => {
    btn.addEventListener("click", e => {
      const card = e.target.closest(".treino-card");
      const nome = card.dataset.treino;
      tituloTreino.textContent = nome;
      descricaoTreino.textContent = `Confira os detalhes do treino de ${nome}.`;
      modalTreino.classList.remove("hidden");
    });
  });

  fecharModalTreino.addEventListener("click", () => {
    modalTreino.classList.add("hidden");
  });

  modalTreino.addEventListener("click", e => {
    if (e.target === modalTreino) {
      modalTreino.classList.add("hidden");
    }
  });
});

