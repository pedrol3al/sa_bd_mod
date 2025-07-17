const meses = [
    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];
let dataAtual = new Date(2025, 4); // Maio = 4
const mesAno = document.getElementById("mesAno");
const diasCalendario = document.getElementById("diasCalendario");
let eventosPorData = JSON.parse(localStorage.getItem('eventosAgenda')) || {};

function renderizarCalendario() {
    const ano = dataAtual.getFullYear();
    const mes = dataAtual.getMonth();
    const primeiroDia = new Date(ano, mes, 1);
    const ultimoDia = new Date(ano, mes + 1, 0);
    const diaSemanaInicio = primeiroDia.getDay();
    const totalDias = ultimoDia.getDate();

    mesAno.textContent = `${meses[mes]} ${ano}`;
    diasCalendario.innerHTML = "";

    for (let i = 0; i < diaSemanaInicio; i++) {
        const vazio = document.createElement("div");
        vazio.classList.add("vazio");
        diasCalendario.appendChild(vazio);
    }

    for (let dia = 1; dia <= totalDias; dia++) {
        const divDia = document.createElement("div");
        divDia.textContent = dia;
        divDia.classList.add("dia");

        const dataChave = `${ano}-${mes + 1}-${dia}`;
        if (eventosPorData[dataChave]) {
            const barraEvento = document.createElement("div");
            barraEvento.classList.add("evento-barra");
            barraEvento.textContent = eventosPorData[dataChave].titulo;
            barraEvento.addEventListener("click", (e) => {
                e.stopPropagation();
                abrirModal(dia, mes, ano);
            });
            divDia.appendChild(barraEvento);
        }

        divDia.addEventListener("click", () => abrirModal(dia, mes, ano));
        diasCalendario.appendChild(divDia);
    }
}

function abrirModal(dia, mes, ano) {
    const modal = document.getElementById('modal');
    const dataSpan = document.getElementById('dataSelecionada');
    const inputTitulo = document.getElementById('inputTitulo');
    const inputDescricao = document.getElementById('inputDescricao');
    const dataChave = `${ano}-${mes + 1}-${dia}`;

    dataSpan.textContent = `${dia} de ${meses[mes]} de ${ano}`;

    const evento = eventosPorData[dataChave] || { titulo: '', descricao: '' };
    inputTitulo.value = evento.titulo;
    inputDescricao.value = evento.descricao;
    inputTitulo.setAttribute('data-chave', dataChave);

    modal.style.display = 'block';
}

document.querySelector('.salvar').addEventListener('click', () => {
    const modal = document.getElementById('modal');
    const inputTitulo = document.getElementById('inputTitulo');
    const inputDescricao = document.getElementById('inputDescricao');
    const dataChave = inputTitulo.getAttribute('data-chave');
    const titulo = inputTitulo.value.trim();
    const descricao = inputDescricao.value.trim();

    if (titulo || descricao) {
        eventosPorData[dataChave] = { titulo, descricao };
    } else {
        delete eventosPorData[dataChave];
    }

    localStorage.setItem('eventosAgenda', JSON.stringify(eventosPorData));
    modal.style.display = 'none';
    renderizarCalendario();
});

document.getElementById("mesAnterior").addEventListener("click", () => {
    dataAtual.setMonth(dataAtual.getMonth() - 1);
    renderizarCalendario();
});

document.getElementById("mesProximo").addEventListener("click", () => {
    dataAtual.setMonth(dataAtual.getMonth() + 1);
    renderizarCalendario();
});

document.querySelector('.fechar-agenda').addEventListener('click', () => {
    document.getElementById('modal').style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === document.getElementById('modal')) {
        document.getElementById('modal').style.display = 'none';
    }
});

document.querySelector('.novo').addEventListener('click', () => {
    document.querySelector('.formulario').reset();
    campoData.value = '';
});

renderizarCalendario();


const campoData = document.getElementById('campoData');

campoData.addEventListener('input', (e) => {
    let valor = e.target.value.replace(/\D/g, '');
    if (valor.length > 8) valor = valor.slice(0, 8);

    let formatado = '';
    if (valor.length > 4) {
        formatado = valor.slice(0, 2) + '/' + valor.slice(2, 4) + '/' + valor.slice(4);
    } else if (valor.length > 2) {
        formatado = valor.slice(0, 2) + '/' + valor.slice(2);
    } else {
        formatado = valor;
    }

    e.target.value = formatado;
});

campoData.addEventListener('blur', () => {
    const valor = campoData.value;
    const partes = valor.split('/');

    if (partes.length === 3) {
        const dia = parseInt(partes[0], 10);
        const mes = parseInt(partes[1], 10) - 1;
        const ano = parseInt(partes[2], 10);

        const novaData = new Date(ano, mes, dia);

        if (
            novaData &&
            novaData.getFullYear() === ano &&
            novaData.getMonth() === mes &&
            novaData.getDate() === dia
        ) {
            dataAtual = new Date(ano, mes);
            renderizarCalendario();

            setTimeout(() => {
                const dias = document.querySelectorAll('#diasCalendario .dia');
                dias.forEach(d => {
                    if (parseInt(d.textContent, 10) === dia) {
                        d.classList.add('selecionado');
                        d.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        d.classList.remove('selecionado');
                    }
                });
            }, 0);
        }
    }
});