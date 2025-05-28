document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form.formulario');
    const btnSalvar = form.querySelector('button.salvar');
    const btnPesquisar = form.querySelector('button.pesquisar');
    const btnNovo = form.querySelector('button.novo');

    form.addEventListener('submit', (e) => e.preventDefault());

    function limparFormulario() {
        form.reset();
    }

    function validarCampos() {
        const campos = form.querySelectorAll('input[type="text"], textarea');
        for (const campo of campos) {
            if (!campo.value.trim()) {
                return false;
            }
        }
        return true;
    }

    function coletarDados() {
        const dados = {};
        const campos = form.querySelectorAll('input[type="text"], textarea');
        campos.forEach(campo => {
            const label = campo.previousElementSibling ? campo.previousElementSibling.innerText.trim() : campo.name || campo.id;
            dados[label] = campo.value.trim();
        });
        return dados;
    }

    function salvarDados(dados) {
        const registros = JSON.parse(localStorage.getItem('ordensServico')) || [];
        registros.push(dados);
        localStorage.setItem('ordensServico', JSON.stringify(registros));
    }

    function gerarListaHTML(registros) {
        let html = '<ul style="text-align:left; padding:0;">';
        registros.forEach((registro, index) => {
            html += `<li style="margin-bottom:10px; border-bottom:1px solid #ccc; padding-bottom:5px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>`;
            for (const chave in registro) {
                html += `${chave}: ${registro[chave]}<br>`;
            }
            html += `</div>
                    <div style="display:flex; gap:5px;">
                        <button onclick="editarRegistro(${index})" 
                            style="background:#007bff; color:#fff; border:none; padding:4px 8px; border-radius:5px; cursor:pointer;">
                            ✏️ Editar
                        </button>
                        <button onclick="excluirRegistro(${index})" 
                            style="background:#dc3545; color:#fff; border:none; padding:4px 8px; border-radius:5px; cursor:pointer;">
                            🗑️ Excluir
                        </button>
                    </div>
                </div>
            </li>`;
        });
        html += '</ul>';
        return html;
    }

    btnSalvar.addEventListener('click', (e) => {
        e.preventDefault();

        if (validarCampos()) {
            const dados = coletarDados();
            salvarDados(dados);

            Swal.fire({
                icon: 'success',
                title: 'Salvo!',
                text: 'Dados salvos com sucesso.',
                timer: 2000,
                showConfirmButton: false,
            });

            limparFormulario();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Por favor, preencha todos os campos antes de salvar.',
                confirmButtonText: 'Ok'
            });
        }
    });

    btnPesquisar.addEventListener('click', (e) => {
        e.preventDefault();

        const registros = JSON.parse(localStorage.getItem('ordensServico')) || [];

        Swal.fire({
            title: 'Pesquisar Registros',
            html: `
              <input type="text" id="barraPesquisa" placeholder="🔍 Digite para pesquisar..." 
                  style="width:95%; padding:5px; margin-bottom:10px; border-radius:5px; border:1px solid #ccc;">
              <div id="resultadoPesquisa" style="max-height:300px; overflow:auto; text-align:left;">
                <p style="color:gray; text-align:center;">Digite algo para exibir os registros...</p>
              </div>
            `,
            width: 600,
            confirmButtonText: 'Fechar',
            didOpen: () => {
                const inputPesquisa = Swal.getPopup().querySelector('#barraPesquisa');
                const divResultado = Swal.getPopup().querySelector('#resultadoPesquisa');

                inputPesquisa.addEventListener('input', () => {
                    const termo = inputPesquisa.value.toLowerCase();

                    if (termo.trim() === '') {
                        divResultado.innerHTML = '<p style="color:gray; text-align:center;">Digite algo para exibir os registros...</p>';
                        return;
                    }

                    const filtrados = registros.filter(registro => {
                        return Object.values(registro).some(valor =>
                            valor.toLowerCase().includes(termo)
                        );
                    });

                    if (filtrados.length > 0) {
                        divResultado.innerHTML = gerarListaHTML(filtrados);
                    } else {
                        divResultado.innerHTML = '<p style="text-align:center;">Nenhum resultado encontrado.</p>';
                    }
                });
            }
        });
    });

    btnNovo.addEventListener('click', (e) => {
        e.preventDefault();
        limparFormulario();
        Swal.fire({
            icon: 'info',
            title: 'Novo formulário',
            text: 'Formulário limpo para novo registro.',
            timer: 1500,
            showConfirmButton: false,
        });
    });

    // 🔧 Funções Editar e Excluir
    window.editarRegistro = (index) => {
        const registros = JSON.parse(localStorage.getItem('ordensServico')) || [];
        const registro = registros[index];

        if (registro) {
            const campos = form.querySelectorAll('input[type="text"], textarea');
            campos.forEach(campo => {
                const label = campo.previousElementSibling ? campo.previousElementSibling.innerText.trim() : campo.name || campo.id;
                campo.value = registro[label] || '';
            });

            registros.splice(index, 1); // Remove temporariamente para não duplicar ao salvar de novo
            localStorage.setItem('ordensServico', JSON.stringify(registros));

            Swal.fire({
                icon: 'info',
                title: 'Modo Edição',
                text: 'Altere os dados e clique em Salvar para atualizar.',
                timer: 2000,
                showConfirmButton: false,
            });
        }
    };

    window.excluirRegistro = (index) => {
        const registros = JSON.parse(localStorage.getItem('ordensServico')) || [];
        registros.splice(index, 1);
        localStorage.setItem('ordensServico', JSON.stringify(registros));

        Swal.fire({
            icon: 'success',
            title: 'Excluído!',
            text: 'Registro removido com sucesso.',
            timer: 1500,
            showConfirmButton: false,
        });
    };
});
