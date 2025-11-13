function mostrarSecao(secao) {
  const secoes = ["geral", "plano", "treino", "ficha", "config"];
  secoes.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.classList.remove("active");
  });

  const ativa = document.getElementById(secao);
  if (ativa) ativa.classList.add("active");
  atualizarEstadoMenu(secao);
}



// Mostra a seção "geral" por padrão ao carregar
document.addEventListener("DOMContentLoaded", () => {
  mostrarSecao("geral");
});

// Atualiza o estado ativo do menu lateral
function atualizarEstadoMenu(secao) {
  // remove active de todos os links
  const links = document.querySelectorAll('.techfit-sidebar .nav-link');
  links.forEach(l => l.classList.remove('active'));

  // Preferência: busca por data-section
  let ativo = document.querySelector(`.techfit-sidebar .nav-link[data-section="${secao}"]`);
  // fallback: busca por onclick que contenha a chamada
  if (!ativo) {
    const selector = `.techfit-sidebar .nav-link[onclick*="mostrarSecao('${secao}')"], .techfit-sidebar .nav-link[onclick*=\"mostrarSecao(\'${secao}\')\"]`;
    ativo = document.querySelector(selector);
  }

  if (ativo) ativo.classList.add('active');
}

// Integrar atualização do menu dentro de mostrarSecao
// (mantemos a função existente, então chamamos atualizarEstadoMenu após mostrar a seção)
const _mostrarSecaoOrig = mostrarSecao;
function mostrarSecao(secao) {
  // chama a implementação anterior (que está acima) - reimplementar logicamente para evitar recursão
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

  // atualiza classe active do menu
  atualizarEstadoMenu(secao);
}

// Reaplica comportamento padrão no carregamento
document.addEventListener("DOMContentLoaded", () => {
  mostrarSecao("geral");
});

const ativa = document.getElementById(secao);
if (ativa) {
  ativa.classList.remove("hidden");
  ativa.style.position = "relative"; // <-- garante alinhamento correto
  ativa.style.visibility = "visible";
  ativa.style.opacity = "1";
  ativa.style.pointerEvents = "auto";
  console.log("Mostrando:", secao);
}
