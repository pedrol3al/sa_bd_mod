// Lista inicial de fornecedores para exemplo
let listaFornecedores = [
    {
      codigo: "001",
      empresa: "Tech Suprimentos Ltda",
      cnpj: "12.345.678/0001-00",
      endereco: "Rua das Indústrias, 456",
      num: "456",
      complemento: "Galpão 2",
      bairro: "Industrial",
      cidade: "Joinville",
      uf: "SC",
      cep: "89200-000",
      telefone: "(47) 3333-4444",
      celular: "(47) 98888-7777",
      email: "contato@techsuprimentos.com",
      data_cadastro: "2025-05-20",
      observacoes: "Entrega pontual, fornece peças originais"
    }
  ];
  
  // Verifica se campos obrigatórios estão preenchidos
  function camposObrigatoriosPreenchidos() {
    const camposObrigatorios = [
      "codigo", "empresa", "cnpj", "endereco", "num", "bairro",
      "cidade", "uf", "cep", "telefone", "celular", "email", "data_cadastro"
    ];
    for (const id of camposObrigatorios) {
      const campo = document.getElementById(id);
      if (!campo || campo.value.trim() === "") {
        return false;
      }
    }
    return true;
  }
  
  // Pega os dados do formulário e retorna como objeto
  function pegarDadosFormulario() {
    return {
      codigo: document.getElementById("codigo").value.trim(),
      empresa: document.getElementById("empresa").value.trim(),
      cnpj: document.getElementById("cnpj").value.trim(),
      endereco: document.getElementById("endereco").value.trim(),
      num: document.getElementById("num").value.trim(),
      complemento: document.getElementById("complemento").value.trim(),
      bairro: document.getElementById("bairro").value.trim(),
      cidade: document.getElementById("cidade").value.trim(),
      uf: document.getElementById("uf").value.trim(),
      cep: document.getElementById("cep").value.trim(),
      telefone: document.getElementById("telefone").value.trim(),
      celular: document.getElementById("celular").value.trim(),
      email: document.getElementById("email").value.trim(),
      data_cadastro: document.getElementById("data_cadastro").value.trim(),
      observacoes: document.getElementById("observacoes").value.trim()
    };
  }
  
  // Preenche o formulário com dados do fornecedor
  function preencherFormulario(fornecedor) {
    for (const campo in fornecedor) {
      const elemento = document.getElementById(campo);
      if (elemento) {
        elemento.value = fornecedor[campo];
      }
    }
    fecharModalPesquisar();
  }
  
  // Atualiza exibição do overlay de fundo escuro
  function atualizarOverlay() {
    const modalPesquisarAberta = document.getElementById('modal_pesquisar').style.display === 'block';
    const modalDetalhesAberta = document.getElementById('modalDetalhes').style.display === 'block';
    const overlay = document.getElementById('overlay');
  
    if (modalPesquisarAberta || modalDetalhesAberta) {
      overlay.style.display = 'block';
    } else {
      overlay.style.display = 'none';
    }
  }
  
  // Abre modal de pesquisa
  function abrirModalPesquisar() {
    document.getElementById('modal_pesquisar').style.display = 'block';
    document.getElementById('campoBusca').focus();
    atualizarOverlay();
  }
  
  // Fecha modal de pesquisa e limpa dados
  function fecharModalPesquisar() {
    document.getElementById('modal_pesquisar').style.display = 'none';
    document.getElementById('campoBusca').value = '';
    document.getElementById('resultadoPesquisa').innerHTML = '';
    atualizarOverlay();
  }
  
  // Fecha modal de detalhes
  function fecharModalDetalhes() {
    document.getElementById('modalDetalhes').style.display = 'none';
    atualizarOverlay();
  }
  
  // Exibe detalhes do fornecedor na modal detalhes
  function mostrarDetalhes(fornecedor) {
    const conteudo = `
      <p><strong>Empresa:</strong> ${fornecedor.empresa}</p>
      <p><strong>CNPJ:</strong> ${fornecedor.cnpj}</p>
      <p><strong>Email:</strong> ${fornecedor.email}</p>
      <p><strong>Telefone:</strong> ${fornecedor.telefone}</p>
      <p><strong>Celular:</strong> ${fornecedor.celular}</p>
      <p><strong>Endereço:</strong> ${fornecedor.endereco}, Nº ${fornecedor.num}</p>
      <p><strong>Complemento:</strong> ${fornecedor.complemento || '-'}</p>
      <p><strong>Bairro:</strong> ${fornecedor.bairro}</p>
      <p><strong>CEP:</strong> ${fornecedor.cep}</p>
      <p><strong>Estado:</strong> ${fornecedor.uf}</p>
      <p><strong>Cidade:</strong> ${fornecedor.cidade}</p>
      <p><strong>Data de Cadastro:</strong> ${fornecedor.data_cadastro}</p>
      <p><strong>Observações:</strong> ${fornecedor.observacoes || '-'}</p>
    `;
    document.getElementById('conteudoDetalhes').innerHTML = conteudo;
    document.getElementById('modalDetalhes').style.display = 'block';
    atualizarOverlay();
  }
  
  // Exibe resultados da pesquisa na modal
  function mostrarResultados(resultados) {
    const container = document.getElementById('resultadoPesquisa');
    container.innerHTML = '';
  
    if (resultados.length === 0) {
      container.innerHTML = '<p>Nenhum fornecedor encontrado.</p>';
      return;
    }
  
    const ul = document.createElement('ul');
    ul.style.listStyle = 'none';
    ul.style.padding = '0';
  
    resultados.forEach(fornecedor => {
      const li = document.createElement('li');
      li.style.display = 'flex';
      li.style.justifyContent = 'space-between';
      li.style.alignItems = 'center';
      li.style.padding = '8px 0';
      li.style.borderBottom = '1px solid #ccc';
  
      const textoInfo = document.createElement('span');
      textoInfo.textContent = `${fornecedor.empresa} - CNPJ: ${fornecedor.cnpj}`;
  
      const botoesDiv = document.createElement('div');
  
      const btnPreencher = document.createElement('button');
      btnPreencher.type = 'button';
      btnPreencher.textContent = '🔄 Preencher';
      btnPreencher.style.marginRight = '5px';
      btnPreencher.onclick = () => preencherFormulario(fornecedor);
  
      const btnExcluir = document.createElement('button');
      btnExcluir.type = 'button';
      btnExcluir.textContent = '❌ Excluir';
      btnExcluir.style.marginRight = '5px';
      btnExcluir.onclick = () => {
        if (confirm(`Confirma a exclusão do fornecedor "${fornecedor.empresa}"?`)) {
          const idx = listaFornecedores.findIndex(f => f.cnpj === fornecedor.cnpj);
          if (idx !== -1) {
            listaFornecedores.splice(idx, 1);
            pesquisarFornecedores();
          }
        }
      };
  
      const btnDetalhes = document.createElement('button');
      btnDetalhes.type = 'button';
      btnDetalhes.textContent = '🔍 Detalhes';
      btnDetalhes.onclick = () => mostrarDetalhes(fornecedor);
  
      botoesDiv.appendChild(btnPreencher);
      botoesDiv.appendChild(btnExcluir);
      botoesDiv.appendChild(btnDetalhes);
  
      li.appendChild(textoInfo);
      li.appendChild(botoesDiv);
  
      ul.appendChild(li);
    });
  
    container.appendChild(ul);
  }
  
  // Função para filtrar fornecedores conforme o campo de busca
  function pesquisarFornecedores() {
    const termo = document.getElementById('campoBusca').value.toLowerCase();
    const resultados = listaFornecedores.filter(fornecedor =>
      (fornecedor.empresa.toLowerCase().includes(termo)) || (fornecedor.cnpj && fornecedor.cnpj.includes(termo))
    );
    mostrarResultados(resultados);
  }
  
  // Função para cadastrar ou atualizar fornecedor
  function cadastrarFornecedor(event) {
    event.preventDefault();
  
    const containerErro = document.getElementById('mensagemErro');
    const containerSucesso = document.getElementById('mensagemSucesso');
  
    if (!camposObrigatoriosPreenchidos()) {
      containerErro.textContent = "Por favor, preencha todos os campos obrigatórios!";
      containerErro.style.display = "block";
      containerSucesso.style.display = "none";
      return;
    }
  
    const fornecedor = pegarDadosFormulario();
  
    const idxExistente = listaFornecedores.findIndex(f => f.cnpj === fornecedor.cnpj);
  
    if (idxExistente !== -1) {
      listaFornecedores[idxExistente] = fornecedor;
      containerSucesso.textContent = "Fornecedor atualizado com sucesso!";
    } else {
      listaFornecedores.push(fornecedor);
      containerSucesso.textContent = "Fornecedor cadastrado com sucesso!";
    }
  
    containerSucesso.style.display = "block";
    containerErro.style.display = "none";
  
    document.querySelector("form.formulario").reset();
  }

  document.addEventListener("DOMContentLoaded", function() {
    const botaoPesquisar = document.querySelector(".pesquisar");
    const modalPesquisar = document.getElementById("modal_pesquisar");
    const overlay = document.getElementById("overlay");
    const fecharModal = document.getElementById("fechar-modal");
  
    function abrirModalPesquisar() {
      modalPesquisar.style.display = "block";
      overlay.style.display = "block";
    }
  
    function fecharModalPesquisar() {
      modalPesquisar.style.display = "none";
      overlay.style.display = "none";
    }
  
    botaoPesquisar.addEventListener("click", abrirModalPesquisar);
    fecharModal.addEventListener("click", fecharModalPesquisar);
  
    // Também fecha o modal se clicar no overlay
    overlay.addEventListener("click", fecharModalPesquisar);
  });  
  
  // Configurações dos eventos após carregar o DOM
  document.addEventListener("DOMContentLoaded", () => {
    const botaoCadastrar = document.getElementById("bt_cadastrar");
    const botaoPesquisar = document.getElementById("bt_pesquisar");
    const inputBusca = document.getElementById("campoBusca");
    const btnFecharPesquisar = document.getElementById("botaoFechar");
    const btnFecharDetalhes = document.getElementById("fecharDetalhes");
    const overlay = document.getElementById("overlay");
  
    let containerErro = document.createElement("div");
    containerErro.id = 'mensagemErro';
    containerErro.style.color = "#721c24";
    containerErro.style.backgroundColor = "#f8d7da";
    containerErro.style.padding = "10px";
    containerErro.style.marginBottom = "10px";
    containerErro.style.border = "1px solid #f5c6cb";
    containerErro.style.borderRadius = "5px";
    containerErro.style.display = "none";
  
    let containerSucesso = document.createElement("div");
    containerSucesso.id = 'mensagemSucesso';
    containerSucesso.style.color = "#155724";
    containerSucesso.style.backgroundColor = "#d4edda";
    containerSucesso.style.padding = "10px";
    containerSucesso.style.marginBottom = "10px";
    containerSucesso.style.border = "1px solid #c3e6cb";
    containerSucesso.style.borderRadius = "5px";
    containerSucesso.style.display = "none";
  
    const formulario = document.querySelector("form.formulario");
    formulario.insertBefore(containerErro, formulario.firstChild);
    formulario.insertBefore(containerSucesso, formulario.firstChild);
  
    botaoCadastrar.addEventListener("click", cadastrarFornecedor);
    botaoPesquisar.addEventListener("click", (e) => {
      e.preventDefault();
      abrirModalPesquisar();
    });
  
    inputBusca.addEventListener("input", pesquisarFornecedores);
    btnFecharPesquisar.addEventListener("click", fecharModalPesquisar);
    btnFecharDetalhes.addEventListener("click", fecharModalDetalhes);
  
    overlay.addEventListener("click", () => {
      if (document.getElementById('modal_pesquisar').style.display === 'block') {
        fecharModalPesquisar();
      }
      if (document.getElementById('modalDetalhes').style.display === 'block') {
        fecharModalDetalhes();
      }
    });
  });