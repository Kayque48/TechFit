const abrirBotoes = document.querySelectorAll(".abrirModal");
const fechar = document.getElementById("fecharModal");
const modal = document.getElementById("modalPlano");

// abrir o modal ao clicar em qualquer botão
abrirBotoes.forEach(botao => {
  botao.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });
});

// fechar pelo X
fechar.addEventListener("click", () => {
  modal.classList.add("hidden");
});

// fechar ao clicar fora do conteúdo
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
  }
});
