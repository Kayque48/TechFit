function mostrarSecao(secao) {
  const secoes = ["geral", "plano", "treino", "ficha", "config"];
  secoes.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.classList.add("hidden");
  });

  const ativa = document.getElementById(secao);
  if (ativa) {
    ativa.classList.remove("hidden");
    console.log("Mostrando:", secao);
  }
}


// Mostra a seção "geral" por padrão ao carregar
document.addEventListener("DOMContentLoaded", () => {
  mostrarSecao("geral");
});
