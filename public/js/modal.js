const abrir = document.getElementById("abrirModal");
const fechar = document.getElementById("fecharModal");
const modal = document.getElementById("meuModal");

abrir.addEventListener("click", () => {
  modal.classList.remove("hidden");
});

fechar.addEventListener("click", () => {
  modal.classList.add("hidden");
});

// Fechar ao clicar fora do conteúdo
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
  }
});
