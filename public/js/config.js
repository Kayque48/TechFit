// ==========================
// Troca de Tema
// ==========================
document.querySelectorAll(".btn-opcao").forEach(btn => {
    btn.addEventListener("click", () => {
        const tema = btn.getAttribute("data-tema");

        if (tema === "light") {
            document.body.classList.remove("dark-mode");
        } else {
            document.body.classList.add("dark-mode");
        }
    });
});


// ==========================
// Contas (simulado)
// ==========================
const listaContas = document.getElementById("listaContas");

let contas = [
    { nome: "Administrador", email: "admin@techfit.com" },
    { nome: "Instrutor Paulo", email: "paulo@techfit.com" }
];

// Renderiza contas
function atualizarContas() {
    listaContas.innerHTML = "";
    contas.forEach((c, i) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <span><strong>${c.nome}</strong> — ${c.email}</span>
            <button onclick="logar(${i})">Entrar</button>
        `;
        listaContas.appendChild(li);
    });
}
atualizarContas();

// Acessar minha conta
document.getElementById("btnMinhaConta").addEventListener("click", () => {
    alert("Abrindo sua conta...");
});

// Entrar com outra conta
document.getElementById("btnOutraConta").addEventListener("click", () => {
    const nome = prompt("Nome do usuário:");
    const email = prompt("E-mail do usuário:");

    if (nome && email) {
        contas.push({ nome, email });
        atualizarContas();
    }
});

// Entrar em conta da lista
function logar(index) {
    alert(`Entrando na conta de ${contas[index].nome}`);
}
