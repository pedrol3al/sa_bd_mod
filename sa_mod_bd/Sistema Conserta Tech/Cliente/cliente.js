document.addEventListener('DOMContentLoaded', function () {
    // Elementos do formulário
    const btnCadastrar = document.getElementById('bt_cadastrar');
    const btnPesquisar = document.querySelector('.pesquisar');
    const btnNovo = document.getElementById('bt_novo');
    const tipoPessoaSelect = document.getElementById('tipo_pessoa');
    const form = document.querySelector('.formulario');
    
    // Estados da aplicação
    let modoEdicao = false;
    let clienteEmEdicao = null;
    const modalFactory = new ModalFactory();

    // Event Listeners
    if (btnCadastrar) {
        btnCadastrar.addEventListener('click', handleCadastrarClick);
    }

    if (btnNovo) {
        btnNovo.addEventListener('click', handleNovoClick);
    }

    if (tipoPessoaSelect) {
        tipoPessoaSelect.addEventListener('change', handleTipoPessoaChange);
    }

    if (btnPesquisar) {
        btnPesquisar.addEventListener('click', handlePesquisarClick);
    }

    // Funções de tratamento de eventos
    function handleCadastrarClick(e) {
        e.preventDefault();
        
        const cliente = obterDadosFormulario();
        
        if (!validarCliente(cliente)) {
            mostrarErro('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        if (modoEdicao) {
            salvarEdicao(cliente);
        } else {
            cadastrarCliente(cliente);
        }
    }

    function handleNovoClick(e) {
        e.preventDefault();
        
        if (modoEdicao) {
            cancelarEdicao();
        } else {
            limparFormulario();
        }
    }

    function handleTipoPessoaChange() {
        const tipo = this.value;
        toggleCamposPessoa(tipo);
    }

    function handlePesquisarClick(e) {
        e.preventDefault();
        abrirModalPesquisa();
    }

    // Funções principais de negócio
    function cadastrarCliente(cliente) {
        try {
            cliente.id_cliente = gerarIdCliente();
            
            const clientes = JSON.parse(localStorage.getItem('clientes')) || [];
            clientes.push(cliente);
            localStorage.setItem('clientes', JSON.stringify(clientes));

            mostrarSucesso('Cliente cadastrado com sucesso!');
            limparFormulario();
        } catch (error) {
            console.error('Erro ao cadastrar cliente:', error);
            mostrarErro('Ocorreu um erro ao cadastrar o cliente.');
        }
    }

    function salvarEdicao(clienteEditado) {
        try {
            clienteEditado.id_cliente = clienteEmEdicao.id_cliente;
            
            const clientes = JSON.parse(localStorage.getItem('clientes')) || [];
            const index = clientes.findIndex(c => c.id_cliente === clienteEmEdicao.id_cliente);
            
            if (index !== -1) {
                clientes[index] = clienteEditado;
                localStorage.setItem('clientes', JSON.stringify(clientes));
                mostrarSucesso('Cliente atualizado com sucesso!');
                sairModoEdicao();
                limparFormulario();
            } else {
                mostrarErro('Cliente não encontrado para edição.');
            }
        } catch (error) {
            console.error('Erro ao editar cliente:', error);
            mostrarErro('Ocorreu um erro ao editar o cliente.');
        }
    }

    // Funções auxiliares
    function obterDadosFormulario() {
        const tipoPessoa = tipoPessoaSelect.value;
        if (!tipoPessoa) return null;

        const cliente = {
            id_cliente: document.getElementById('id_cliente').value.trim(),
            id_usuario: document.getElementById('id_usuario').value.trim(),
            tipo_pessoa: tipoPessoa,
            endereco: document.getElementById('endereco').value.trim(),
            num: document.getElementById('num').value.trim(),
            complemento: document.getElementById('complemento').value.trim(),
            bairro: document.getElementById('bairro').value.trim(),
            uf: document.getElementById('uf').value,
            cidade: document.getElementById('cidade').value.trim(),
            cep: document.getElementById('cep').value.trim(),
            email: document.getElementById('email').value.trim(),
            telefone: document.getElementById('telefone').value.trim(),
            celular: document.getElementById('celular').value.trim(),
            observacoes: document.getElementById('observacoes').value.trim()
        };

        if (tipoPessoa === 'fisica') {
            cliente.nome = document.getElementById('nome').value.trim();
            cliente.cpf = document.getElementById('cpf').value.trim();
            cliente.data_nasc = document.getElementById('data_nasc').value;
            cliente.sexo = document.getElementById('sexo').value;
            cliente.rg = document.getElementById('rg').value.trim();
        } else if (tipoPessoa === 'juridica') {
            cliente.razao_social = document.getElementById('razao_social').value.trim();
            cliente.nome_fantasia = document.getElementById('nome_fantasia').value.trim();
            cliente.cnpj = document.getElementById('cnpj').value.trim();
            cliente.data_fundacao = document.getElementById('data_fundacao').value;
            cliente.inscricao_estadual = document.getElementById('inscricao_estadual').value.trim();
        }

        return cliente;
    }

    function validarCliente(cliente) {
        if (!cliente || !cliente.tipo_pessoa) return false;
        
        // Campos comuns obrigatórios
        const camposObrigatorios = ['endereco', 'num', 'bairro', 'uf', 'cidade'];
        for (const campo of camposObrigatorios) {
            if (!cliente[campo]) return false;
        }
        
        // Campos específicos por tipo
        if (cliente.tipo_pessoa === 'fisica') {
            return cliente.nome && cliente.cpf;
        } else if (cliente.tipo_pessoa === 'juridica') {
            return cliente.razao_social && cliente.cnpj;
        }
        
        return false;
    }

    function gerarIdCliente() {
        return 'CL' + Date.now();
    }

    function limparFormulario() {
        form.reset();
        document.getElementById('id_cliente').value = '';
        document.getElementById('pessoa_fisica_fields').style.display = 'none';
        document.getElementById('pessoa_juridica_fields').style.display = 'none';
        sairModoEdicao();
    }

    function toggleCamposPessoa(tipo) {
        document.getElementById('pessoa_fisica_fields').style.display = 
            tipo === 'fisica' ? 'block' : 'none';
        document.getElementById('pessoa_juridica_fields').style.display = 
            tipo === 'juridica' ? 'block' : 'none';
    }

    function entrarModoEdicao(cliente) {
        modoEdicao = true;
        clienteEmEdicao = cliente;
        atualizarBotoes();
    }

    function sairModoEdicao() {
        modoEdicao = false;
        clienteEmEdicao = null;
        atualizarBotoes();
    }

    function cancelarEdicao() {
        Swal.fire({
            title: 'Cancelar Edição',
            text: 'Tem certeza que deseja cancelar a edição? Todas as alterações serão perdidas.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, cancelar',
            cancelButtonText: 'Continuar editando'
        }).then((result) => {
            if (result.isConfirmed) {
                limparFormulario();
            }
        });
    }

    function atualizarBotoes() {
        if (btnCadastrar) {
            btnCadastrar.textContent = modoEdicao ? 'Salvar Edição' : 'Cadastrar';
            btnCadastrar.className = modoEdicao ? 'btn btn-success' : 'btn btn-primary';
        }
        
        if (btnNovo) {
            btnNovo.textContent = modoEdicao ? 'Cancelar Edição' : 'Novo';
            btnNovo.style.display = 'inline-block';
            btnNovo.className = modoEdicao ? 'btn btn-danger' : 'btn btn-secondary';
        }
        
        if (btnPesquisar) {
            btnPesquisar.disabled = modoEdicao;
        }
    }

    function mostrarSucesso(mensagem) {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: mensagem,
            timer: 2000
        });
    }

    function mostrarErro(mensagem) {
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: mensagem
        });
    }

    // Funções relacionadas à pesquisa
    function abrirModalPesquisa() {
        const pesquisaModal = modalFactory.createModal({
            id: 'modal-pesquisa-clientes',
            title: 'Pesquisar Cliente',
            width: '80%',
            maxWidth: '1000px',
            height: '600px',
            content: `
                <div style="margin-bottom: 15px;">
                    <input type="text" id="input-pesquisa-cliente" class="form-control" 
                        placeholder="Digite o nome, CPF/CNPJ ou ID do cliente..." style="width: 100%; padding: 8px;">
                </div>
                <div id="resultado-pesquisa-cliente" style="margin-top: 15px; max-height: 400px; 
                    overflow-y: auto; border-top: 1px solid #ddd; padding-top: 10px;"></div>
            `
        });

        const inputPesquisa = document.getElementById('input-pesquisa-cliente');
        const resultado = document.getElementById('resultado-pesquisa-cliente');

        pesquisaModal.show();
        inputPesquisa.value = "";
        resultado.innerHTML = "<p>Digite um termo para buscar.</p>";
        inputPesquisa.focus();

        inputPesquisa.addEventListener("input", function() {
            const termo = inputPesquisa.value.trim().toLowerCase();
            const clientes = JSON.parse(localStorage.getItem('clientes')) || [];
            
            resultado.innerHTML = termo === ""
                ? "<p>Digite um termo para buscar.</p>"
                : gerarResultadosPesquisa(clientes, termo);
        });
    }

    function gerarResultadosPesquisa(clientes, termo) {
        const encontrados = clientes.filter(cliente => {
            const nome = cliente.tipo_pessoa === 'fisica' ? cliente.nome : cliente.razao_social;
            const id = cliente.id_cliente || '';
            const cpfCnpj = cliente.tipo_pessoa === 'fisica' ? cliente.cpf : cliente.cnpj;
            
            return (nome && nome.toLowerCase().includes(termo)) ||
                   (id && id.toLowerCase().includes(termo)) ||
                   (cpfCnpj && cpfCnpj.toLowerCase().includes(termo));
        });

        if (encontrados.length === 0) {
            return "<p>Nenhum cliente encontrado.</p>";
        }

        return encontrados.map(cliente => `
            <div style="padding: 8px; border-bottom: 1px solid #ccc; cursor: pointer;"
                onmouseenter="this.style.backgroundColor='#f5f5f5'"
                onmouseleave="this.style.backgroundColor=''"
                onclick="window.preencherFormularioClienteEfechar(${JSON.stringify(cliente).replace(/"/g, '&quot;')})">
                
                <strong>ID:</strong> ${cliente.id_cliente}<br>
                <strong>Nome/Razão Social:</strong> ${cliente.tipo_pessoa === 'fisica' ? cliente.nome : cliente.razao_social}<br>
                <strong>${cliente.tipo_pessoa === 'fisica' ? 'CPF' : 'CNPJ'}:</strong> ${cliente.tipo_pessoa === 'fisica' ? cliente.cpf : cliente.cnpj}
                
                <div class="btn-group" style="margin-top: 8px; display: flex; gap: 5px;">
                    <button class="btn-visualizar" 
                        style="padding: 4px 8px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;"
                        onclick="event.stopPropagation(); window.visualizarDetalhesCliente(${JSON.stringify(cliente).replace(/"/g, '&quot;')})">
                        Visualizar
                    </button>
                    <button class="btn-editar" 
                        style="padding: 4px 8px; background: #FFC107; color: black; border: none; border-radius: 4px; cursor: pointer;"
                        onclick="event.stopPropagation(); window.preencherFormularioCliente(${JSON.stringify(cliente).replace(/"/g, '&quot;')})">
                        Editar
                    </button>
                    <button class="btn-excluir" 
                        style="padding: 4px 8px; background: #F44336; color: white; border: none; border-radius: 4px; cursor: pointer;"
                        onclick="event.stopPropagation(); window.excluirCliente(${JSON.stringify(cliente).replace(/"/g, '&quot;')})">
                        Excluir
                    </button>
                </div>
            </div>
        `).join('');
    }

    // Funções globais para interação com o modal
    window.preencherFormularioCliente = function(cliente) {
        document.getElementById('tipo_pessoa').value = cliente.tipo_pessoa;
        toggleCamposPessoa(cliente.tipo_pessoa);
        
        document.getElementById('id_cliente').value = cliente.id_cliente || '';
        document.getElementById('id_usuario').value = cliente.id_usuario || '';
        document.getElementById('endereco').value = cliente.endereco || '';
        document.getElementById('num').value = cliente.num || '';
        document.getElementById('complemento').value = cliente.complemento || '';
        document.getElementById('bairro').value = cliente.bairro || '';
        document.getElementById('uf').value = cliente.uf || '';
        document.getElementById('cidade').value = cliente.cidade || '';
        document.getElementById('cep').value = cliente.cep || '';
        document.getElementById('email').value = cliente.email || '';
        document.getElementById('telefone').value = cliente.telefone || '';
        document.getElementById('celular').value = cliente.celular || '';
        document.getElementById('observacoes').value = cliente.observacoes || '';

        if (cliente.tipo_pessoa === 'fisica') {
            document.getElementById('nome').value = cliente.nome || '';
            document.getElementById('cpf').value = cliente.cpf || '';
            document.getElementById('data_nasc').value = cliente.data_nasc || '';
            document.getElementById('sexo').value = cliente.sexo || '';
            document.getElementById('rg').value = cliente.rg || '';
        } else if (cliente.tipo_pessoa === 'juridica') {
            document.getElementById('razao_social').value = cliente.razao_social || '';
            document.getElementById('nome_fantasia').value = cliente.nome_fantasia || '';
            document.getElementById('cnpj').value = cliente.cnpj || '';
            document.getElementById('data_fundacao').value = cliente.data_fundacao || '';
            document.getElementById('inscricao_estadual').value = cliente.inscricao_estadual || '';
        }

        entrarModoEdicao(cliente);
    };

    window.preencherFormularioClienteEfechar = function(cliente) {
        window.preencherFormularioCliente(cliente);
        document.querySelector('.custom-modal').style.display = 'none';
        document.getElementById('modal-overlay').style.display = 'none';
    };

    window.visualizarDetalhesCliente = function(cliente) {
        const nome = cliente.tipo_pessoa === 'fisica' ? cliente.nome : cliente.razao_social;
        const tipo = cliente.tipo_pessoa === 'fisica' ? 'Pessoa Física' : 'Pessoa Jurídica';
        
        const detalhesContent = `
            <h3 style="margin-top: 0; color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                Detalhes do Cliente: ${nome} (${tipo})
            </h3>
            <div style="margin-top: 15px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <h4 style="margin-top: 0; color: #555;">Informações Básicas</h4>
                        <p><strong>ID:</strong> ${cliente.id_cliente}</p>
                        ${cliente.tipo_pessoa === 'fisica' ? `
                            <p><strong>Nome:</strong> ${cliente.nome}</p>
                            <p><strong>CPF:</strong> ${cliente.cpf}</p>
                            <p><strong>RG:</strong> ${cliente.rg || 'Não informado'}</p>
                            <p><strong>Data de Nascimento:</strong> ${cliente.data_nasc || 'Não informada'}</p>
                            <p><strong>Sexo:</strong> ${cliente.sexo || 'Não informado'}</p>
                        ` : `
                            <p><strong>Razão Social:</strong> ${cliente.razao_social}</p>
                            <p><strong>Nome Fantasia:</strong> ${cliente.nome_fantasia || 'Não informado'}</p>
                            <p><strong>CNPJ:</strong> ${cliente.cnpj}</p>
                            <p><strong>Inscrição Estadual:</strong> ${cliente.inscricao_estadual || 'Não informada'}</p>
                            <p><strong>Data de Fundação:</strong> ${cliente.data_fundacao || 'Não informada'}</p>
                        `}
                    </div>
                    <div>
                        <h4 style="margin-top: 0; color: #555;">Contato e Endereço</h4>
                        <p><strong>Email:</strong> ${cliente.email || 'Não informado'}</p>
                        <p><strong>Telefone:</strong> ${cliente.telefone || 'Não informado'}</p>
                        <p><strong>Celular:</strong> ${cliente.celular || 'Não informado'}</p>
                        <p><strong>Endereço:</strong> ${cliente.endereco || 'Não informado'}, ${cliente.num || ''}</p>
                        <p><strong>Complemento:</strong> ${cliente.complemento || 'Não informado'}</p>
                        <p><strong>Bairro:</strong> ${cliente.bairro || 'Não informado'}</p>
                        <p><strong>Cidade:</strong> ${cliente.cidade || 'Não informado'}/${cliente.uf || ''}</p>
                        <p><strong>CEP:</strong> ${cliente.cep || 'Não informado'}</p>
                        <p><strong>Observações:</strong> ${cliente.observacoes || 'Nenhuma'}</p>
                    </div>
                </div>
            </div>
        `;

        const detalhesModal = modalFactory.createModal({
            id: 'modal-detalhes-cliente',
            title: 'Detalhes do Cliente',
            width: '70%',
            maxWidth: '800px',
            content: detalhesContent
        });

        detalhesModal.show();
    };

    window.excluirCliente = function(cliente) {
        Swal.fire({
            title: 'Tem certeza?',
            text: `Você está prestes a excluir o cliente "${cliente.tipo_pessoa === 'fisica' ? cliente.nome : cliente.razao_social}" (ID: ${cliente.id_cliente})`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                try {
                    let clientes = JSON.parse(localStorage.getItem('clientes')) || [];
                    clientes = clientes.filter(c => c.id_cliente !== cliente.id_cliente);
                    localStorage.setItem('clientes', JSON.stringify(clientes));
                    
                    // Atualiza a lista de pesquisa
                    const inputPesquisa = document.getElementById('input-pesquisa-cliente');
                    if (inputPesquisa) {
                        inputPesquisa.dispatchEvent(new Event('input'));
                    }
                    
                    Swal.fire(
                        'Excluído!',
                        'O cliente foi removido com sucesso.',
                        'success'
                    );
                } catch (error) {
                    console.error('Erro ao excluir cliente:', error);
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro ao excluir o cliente.',
                        'error'
                    );
                }
            }
        });
    };
});

// Classe ModalFactory (mantida igual)
class ModalFactory {
    constructor() {
        this.overlay = this.createOverlay();
        document.body.appendChild(this.overlay);
    }

    createOverlay() {
        const overlay = document.createElement("div");
        overlay.id = 'modal-overlay';
        Object.assign(overlay.style, {
            display: 'none', position: 'fixed', top: '0', left: '0',
            width: '100%', height: '100%', backgroundColor: 'rgba(0,0,0,0.5)', zIndex: '999'
        });
        return overlay;
    }

    createModal({ id = 'custom-modal', title = '', content = '', width = 'auto', height = 'auto', maxWidth = 'none' }) {
        const existing = document.getElementById(id);
        if (existing) existing.remove();

        const modal = document.createElement("div");
        modal.id = id;
        modal.className = 'custom-modal';
        Object.assign(modal.style, {
            display: 'none', position: 'fixed', top: '50%', left: '50%',
            transform: 'translate(-50%, -50%)', backgroundColor: 'white',
            padding: '20px', borderRadius: '8px', boxShadow: '0 0 10px rgba(0,0,0,0.3)',
            zIndex: '1000', height, width, maxWidth, overflow: 'auto'
        });

        const header = document.createElement("div");
        Object.assign(header.style, {
            display: 'flex', justifyContent: 'space-between', alignItems: 'center',
            marginBottom: '20px', borderBottom: '1px solid #eee', paddingBottom: '10px'
        });

        const titleElement = document.createElement("h2");
        titleElement.textContent = title;
        titleElement.style.margin = '0';

        const closeButton = document.createElement("button");
        closeButton.innerHTML = '&times;';
        Object.assign(closeButton.style, {
            background: 'none', border: 'none', fontSize: '24px',
            cursor: 'pointer', color: 'black'
        });

        header.appendChild(titleElement);
        header.appendChild(closeButton);

        const body = document.createElement("div");
        body.className = 'modal-body';
        body.innerHTML = content;

        modal.appendChild(header);
        modal.appendChild(body);
        document.body.appendChild(modal);

        closeButton.addEventListener('click', () => this.closeModal(modal));
        this.overlay.addEventListener('click', () => this.closeModal(modal));

        return {
            element: modal,
            show: () => this.showModal(modal),
            close: () => this.closeModal(modal),
            updateContent: (newContent) => { body.innerHTML = newContent; }
        };
    }

    showModal(modal) {
        modal.style.display = 'block';
        this.overlay.style.display = 'block';
        this.aplicarBlur();
    }

    closeModal(modal) {
        modal.style.display = 'none';
        this.overlay.style.display = 'none';
        this.removerBlur();
    }

    aplicarBlur() {
        document.querySelectorAll("#menu-container, .conteudo").forEach(el => {
            el.style.filter = "blur(5px)";
            el.style.pointerEvents = "none";
            el.style.userSelect = "none";
        });
    }

    removerBlur() {
        document.querySelectorAll("#menu-container, .conteudo").forEach(el => {
            el.style.filter = "";
            el.style.pointerEvents = "";
            el.style.userSelect = "";
        });
    }
}