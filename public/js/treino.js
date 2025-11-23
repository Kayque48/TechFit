const treinosRealizados = [
    { nome: "Peito e Tríceps", horas: 1, data: "20/11/2025" },
    { nome: "Costas e Bíceps", horas: 1.5, data: "21/11/2025" },
    { nome: "Pernas e Ombros", horas: 2, data: "22/11/2025" },
];

function carregarTreinos() {
    let lista = document.getElementById("listaTreinos");
    lista.innerHTML = "";

    treinosRealizados.forEach(t => {
        const item = document.createElement("div");
        item.classList.add("treino-item");
        item.innerHTML = `
            <h3>${t.nome}</h3>
            <p><strong>Duração:</strong> ${t.horas}h</p>
            <p><strong>Data:</strong> ${t.data}</p>
        `;
        lista.appendChild(item);
    });

    document.getElementById("totalTreinos").textContent =
        treinosRealizados.length;

    document.getElementById("horasTreinadas").textContent =
        treinosRealizados.reduce((acc, t) => acc + t.horas, 0) + "h";
}

// Busca
document.getElementById("inputBuscaTreino").addEventListener("keyup", function () {
    const termo = this.value.toLowerCase();
    const itens = document.querySelectorAll(".treino-item");

    itens.forEach(i => {
        const nome = i.querySelector("h3").textContent.toLowerCase();
        i.style.display = nome.includes(termo) ? "block" : "none";
    });
});

carregarTreinos();
