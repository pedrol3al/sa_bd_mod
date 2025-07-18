class ModalFactory {
  constructor() {
    this.overlay = this.createOverlay();
    document.body.appendChild(this.overlay);
  }

  createOverlay() {
    const overlay = document.createElement("div");
    overlay.id = 'modal-overlay';
    Object.assign(overlay.style, {
      display: 'none', 
      position: 'fixed', 
      top: '0', 
      left: '0',
      width: '100%', 
      height: '100%', 
      backgroundColor: 'rgba(0,0,0,0.5)', 
      zIndex: '999'
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
      display: 'none', 
      position: 'fixed', 
      top: '50%', 
      left: '50%',
      transform: 'translate(-50%, -50%)', 
      backgroundColor: 'white',
      padding: '20px', 
      borderRadius: '8px', 
      boxShadow: '0 0 10px rgba(0,0,0,0.3)',
      zIndex: '1000', 
      height, 
      width, 
      maxWidth, 
      overflow: 'auto'
    });

    const header = document.createElement("div");
    Object.assign(header.style, {
      display: 'flex', 
      justifyContent: 'space-between', 
      alignItems: 'center',
      marginBottom: '20px', 
      borderBottom: '1px solid #eee', 
      paddingBottom: '10px'
    });

    const titleElement = document.createElement("h2");
    titleElement.textContent = title;
    titleElement.style.margin = '0';

    const closeButton = document.createElement("button");
    closeButton.innerHTML = '&times;';
    Object.assign(closeButton.style, {
      background: 'none', 
      border: 'none', 
      fontSize: '24px',
      cursor: 'pointer', 
      color: 'black'
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

// Código principal
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM totalmente carregado - Sistema de estoque iniciado");

  // Verificação de elementos essenciais
  const cadastrarBtn = document.querySelector(".cadastrar");
  const novoBtn = document.querySelector(".novo");
  const pesquisarBtn = document.querySelector(".pesquisar");
  const formulario = document.querySelector(".formulario");

  // Verificação crítica de elementos
  if (!cadastrarBtn || !formulario) {
    console.error("Elementos essenciais não encontrados:", { 
      cadastrarBtn,
      formulario
    });
    alert("Erro crítico: Elementos necessários não encontrados na página. Recarregue a página ou contate o suporte.");
    return;
  }

  console.log("Elementos principais encontrados com sucesso");

  // Inicialização do sistema
  const modalFactory = new ModalFactory();
  let editandoItem = null;
  let estoque = JSON.parse(localStorage.getItem("estoque")) || [];

  // Configuração do botão de pesquisa
  if (pesquisarBtn) {
    pesquisarBtn.addEventListener("click", function(e) {
      e.preventDefault();
      abrirModalPesquisa();
    });
  } else {
    console.warn("Botão de pesquisa não encontrado");
  }

  function abrirModalPesquisa() {
    const pesquisaModal = modalFactory.createModal({
      id: 'modal-pesquisa',
      title: 'Pesquisar Item no Estoque',
      width: '80%',
      maxWidth: '900px',
      content: `
        <div style="margin-bottom: 15px;">
          <input type="text" id="termo-pesquisa" class="form-control" 
              placeholder="Digite ID, nome, aparelho ou descrição..." 
              style="width: 100%; padding: 8px;">
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr>
                <th style="padding: 8px; border: 1px solid #ddd;">ID</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Nome</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Aparelho</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Quantidade</th>
                <th style="padding: 8px; border: 1px solid #ddd;">Ações</th>
              </tr>
            </thead>
            <tbody id="resultados-pesquisa">
              <!-- Resultados serão inseridos aqui -->
            </tbody>
          </table>
        </div>
      `
    });
    
    const termoPesquisa = document.getElementById('termo-pesquisa');
    const resultadosPesquisa = document.getElementById('resultados-pesquisa');
    
    function atualizarResultados() {
      const termo = termoPesquisa.value.toLowerCase();
      resultadosPesquisa.innerHTML = '';
      
      if (estoque.length === 0) {
        resultadosPesquisa.innerHTML = `
          <tr>
            <td colspan="5" style="text-align: center; padding: 10px;">
              Nenhum item cadastrado no estoque
            </td>
          </tr>
        `;
        return;
      }
      
      const resultados = estoque.filter(item => 
        item.id_pecas.toLowerCase().includes(termo) ||
        item.nome.toLowerCase().includes(termo) ||
        (item.aparelho_utilizado && item.aparelho_utilizado.toLowerCase().includes(termo)) ||
        (item.descricao && item.descricao.toLowerCase().includes(termo))
      );
      
      if (resultados.length === 0) {
        resultadosPesquisa.innerHTML = `
          <tr>
            <td colspan="5" style="text-align: center; padding: 10px;">
              Nenhum resultado encontrado
            </td>
          </tr>
        `;
        return;
      }
      
      resultados.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td style="padding: 8px; border: 1px solid #ddd;">${item.id_pecas}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">${item.nome}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">${item.aparelho_utilizado || '-'}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">${item.quantidade}</td>
          <td style="padding: 8px; border: 1px solid #ddd;">
            <button class="btn-editar" data-id="${item.id_pecas}" style="padding: 4px 8px; margin-right: 5px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
              Editar
            </button>
            <button class="btn-excluir" data-id="${item.id_pecas}" style="padding: 4px 8px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
              Excluir
            </button>
          </td>
        `;
        resultadosPesquisa.appendChild(row);
      });
      
      // Adiciona eventos aos botões
      document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', () => editarItem(btn.dataset.id));
      });
      
      document.querySelectorAll('.btn-excluir').forEach(btn => {
        btn.addEventListener('click', () => confirmarExclusao(btn.dataset.id));
      });
    }
    
    function editarItem(id) {
      const item = estoque.find(item => item.id_pecas === id);
      if (item) {
        // Preenche o formulário com os dados do item
        Object.keys(item).forEach(key => {
          const campo = document.getElementById(key);
          if (campo) {
            if (key === 'preco') {
              campo.value = 'R$ ' + parseFloat(item[key]).toFixed(2);
            } else {
              campo.value = item[key];
            }
          }
        });
        
        // Ativa o modo de edição
        toggleModoEdicao(true, item);
        
        // Fecha o modal
        pesquisaModal.close();
      }
    }
    
    function confirmarExclusao(id) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Confirmar exclusão?',
          text: "Esta ação não pode ser desfeita!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, excluir!'
        }).then((result) => {
          if (result.isConfirmed) {
            excluirItem(id);
          }
        });
      } else if (confirm('Tem certeza que deseja excluir este item?')) {
        excluirItem(id);
      }
    }

    function excluirItem(id) {
      estoque = estoque.filter(item => item.id_pecas !== id);
      localStorage.setItem("estoque", JSON.stringify(estoque));
      atualizarResultados();
      
      if (typeof Swal !== 'undefined') {
        Swal.fire('Excluído!', 'Nota fiscal removida com sucesso.', 'success');
      } else {
        alert('Item excluído com sucesso!');
      }
    }

    termoPesquisa.addEventListener('input', atualizarResultados);
    pesquisaModal.show();
    atualizarResultados();
  }

  // Função para alternar entre modo de edição e cadastro
  function toggleModoEdicao(editando, item = null) {
    console.log(`Alternando para modo: ${editando ? "edição" : "cadastro"}`);
    editandoItem = item;

    if (editando) {
      cadastrarBtn.textContent = "Salvar alterações";
      if (novoBtn) novoBtn.textContent = "Cancelar edição";
      
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = true;
        idPecaInput.style.backgroundColor = "#f5f5f5";
        idPecaInput.style.cursor = "not-allowed";
      }
    } else {
      cadastrarBtn.textContent = "Salvar";
      if (novoBtn) novoBtn.textContent = "Novo";
      formulario.reset();
      editandoItem = null;
      
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = false;
        idPecaInput.style.backgroundColor = "";
        idPecaInput.style.cursor = "";
      }
    }
  }

  // Configuração do botão novo/cancelar
  if (novoBtn) {
    novoBtn.addEventListener("click", function(e) {
      e.preventDefault();
      toggleModoEdicao(false);
    });
  }

  // Função para validar campos obrigatórios
  function validarCampos() {
    console.log("Iniciando validação de campos");
    const campos = [
      "id_pecas",
      "nome",
      "aparelho_utilizado",
      "quantidade",
      "preco",
      "data_registro",
      "numero_serie",
      "descricao"
    ];

    for (let id of campos) {
      const campo = document.getElementById(id);
      if (campo && campo.value.trim() === "") {
        const label = campo.previousElementSibling?.innerText || id.replace(/_/g, ' ');
        console.warn(`Campo obrigatório não preenchido: ${label}`);
        
        if (typeof Swal === 'undefined') {
          alert(`Por favor, preencha o campo: ${label}`);
          campo.focus();
          return false;
        }
        
        Swal.fire({
          icon: 'warning',
          title: 'Campo obrigatório',
          text: `Preencha o campo: ${label}`
        });
        campo.focus();
        return false;
      }
    }
    console.log("Todos os campos obrigatórios estão preenchidos");
    return true;
  }

  // Função para salvar ou atualizar item
  function salvarItem() {
    console.log("Iniciando processo de salvamento");
    
    if (!validarCampos()) {
      console.log("Salvamento interrompido: validação falhou");
      return;
    }

    const getSafeValue = (id) => {
      const element = document.getElementById(id);
      if (!element) {
        console.error(`Elemento não encontrado: ${id}`);
        return '';
      }
      return element.value.trim();
    };

    const idPeca = getSafeValue("id_pecas");
    if (!idPeca) {
      console.error("ID da peça é obrigatório");
      alert("ID da peça é obrigatório");
      return;
    }

    if (editandoItem) {
      console.log("Modo edição ativado", editandoItem);
      const index = estoque.findIndex(item => item.id_pecas === editandoItem.id_pecas);

      if (index !== -1) {
        if (idPeca !== editandoItem.id_pecas && estoque.some(item => item.id_pecas === idPeca)) {
          console.warn("Tentativa de usar ID já existente", idPeca);
          
          const message = 'Já existe uma peça com esse ID. Por favor, use outro.';
          if (typeof Swal === 'undefined') {
            alert(message);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'ID já cadastrado',
              text: message
            });
          }
          document.getElementById("id_pecas")?.focus();
          return;
        }

        // Atualiza o item no estoque
        estoque[index] = {
          id_pecas: idPeca,
          id_fornecedor: getSafeValue("id_fornecedor"),
          nome: getSafeValue("nome"),
          aparelho_utilizado: getSafeValue("aparelho_utilizado"),
          quantidade: getSafeValue("quantidade"),
          preco: getSafeValue("preco").replace("R$ ", ""),
          data_registro: getSafeValue("data_registro"),
          status: getSafeValue("status"),
          tipo: getSafeValue("tipo"),
          numero_serie: getSafeValue("numero_serie"),
          descricao: getSafeValue("descricao")
        };

        localStorage.setItem("estoque", JSON.stringify(estoque));
        console.log("Item atualizado com sucesso", estoque[index]);

        const successMessage = 'Item atualizado com sucesso!';
        if (typeof Swal === 'undefined') {
          alert(successMessage);
        } else {
          Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: successMessage
          });
        }

        toggleModoEdicao(false);
      }
    } else {
      console.log("Modo cadastro ativado");
      if (estoque.some(item => item.id_pecas === idPeca)) {
        console.warn("Tentativa de cadastrar ID duplicado", idPeca);
        
        const message = 'Já existe uma peça com esse ID. Por favor, use outro.';
        if (typeof Swal === 'undefined') {
          alert(message);
        } else {
          Swal.fire({
            icon: 'error',
            title: 'ID já cadastrado',
            text: message
          });
        }
        document.getElementById("id_pecas")?.focus();
        return;
      }

      const itemEstoque = {
        id_pecas: idPeca,
        id_fornecedor: getSafeValue("id_fornecedor"),
        nome: getSafeValue("nome"),
        aparelho_utilizado: getSafeValue("aparelho_utilizado"),
        quantidade: getSafeValue("quantidade"),
        preco: getSafeValue("preco").replace("R$ ", ""),
        data_registro: getSafeValue("data_registro"),
        status: getSafeValue("status"),
        tipo: getSafeValue("tipo"),
        numero_serie: getSafeValue("numero_serie"),
        descricao: getSafeValue("descricao")
      };

      estoque.push(itemEstoque);
      localStorage.setItem("estoque", JSON.stringify(estoque));
      console.log("Novo item cadastrado", itemEstoque);

      const successMessage = 'Item cadastrado com sucesso!';
      if (typeof Swal === 'undefined') {
        alert(successMessage);
      } else {
        Swal.fire({
          icon: 'success',
          title: 'Sucesso!',
          text: successMessage
        });
      }

      formulario.reset();
    }
  }

  // Listener para o botão cadastrar
  cadastrarBtn.addEventListener("click", function(e) {
    console.log("Botão cadastrar clicado - Início do processamento");
    e.preventDefault();
    salvarItem();
  });

  // Funções para máscaras e formatação
  function aplicarMascaraValor() {
    console.log("Aplicando máscaras de valor");
    const campos = document.querySelectorAll('.input-valor, #preco');

    campos.forEach(campo => {
      campo.addEventListener('input', formatarValor);
      campo.addEventListener('blur', finalizarFormatacao);
      campo.addEventListener('focus', prepararEdicao);

      if (!campo.value.trim() || campo.value === 'R$ NaN') {
        campo.value = 'R$ 0,00';
      }
    });

    function formatarValor(e) {
      let valor = e.target.value.replace(/\D/g, '');
      
      if (valor === '') {
        e.target.value = 'R$ 0,00';
        return;
      }

      let numero = parseInt(valor, 10);
      if (isNaN(numero)) {
        e.target.value = 'R$ 0,00';
        return;
      }

      valor = (numero / 100).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      e.target.value = 'R$ ' + valor;
    }

    function finalizarFormatacao(e) {
      let valor = e.target.value.replace(/\D/g, '');
      if (valor === '' || parseInt(valor) === 0) {
        e.target.value = 'R$ 0,00';
      }
    }

    function prepararEdicao(e) {
      let valor = e.target.value.replace(/\D/g, '');
      e.target.value = valor === '0' ? '' : valor;
    }
  }

  function configurarCamposNumericos() {
    console.log("Configurando campos numéricos");
    const camposNumericos = ["id_pecas", "id_fornecedor", "quantidade"]; 
    
    camposNumericos.forEach(id => {
      const campo = document.getElementById(id);
      if (campo) {
        campo.addEventListener("keydown", function(e) {
          const teclasPermitidas = [
            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab',
            'Home', 'End'
          ];
          
          if (teclasPermitidas.includes(e.key) || 
              /^[0-9]$/.test(e.key) || 
              (e.key >= '0' && e.key <= '9' && e.key.length === 1)) {
            return;
          }
          
          if (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'x')) {
            return;
          }
          
          e.preventDefault();
        });

        campo.addEventListener("paste", function(e) {
          e.preventDefault();
          const texto = (e.clipboardData || window.clipboardData).getData('text');
          const numeros = texto.replace(/\D/g, '');
          document.execCommand('insertText', false, numeros);
        });

        campo.addEventListener("blur", function() {
          if (campo.value && !/^\d+$/.test(campo.value)) {
            campo.value = campo.value.replace(/\D/g, '');
            if (!campo.value) campo.value = '0';
          }
        });
      }
    });
  }

  // Configuração do botão de impressão
  const btnImprimir = document.getElementById('btn-imprimir');
  if (btnImprimir) {
    btnImprimir.addEventListener('click', function() {
      if (estoque.length === 0) {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'info',
            title: 'Nenhuma NF cadastrada',
            text: 'Não há notas fiscais cadastradas para impressão.'
          });
        } else {
          alert('Não há notas fiscais cadastradas para impressão.');
        }
        return;
      }
      
      const selecionarNFModal = modalFactory.createModal({
        id: 'modal-selecionar-nf',
        title: 'Selecionar Nota Fiscal para Imprimir',
        width: '80%',
        maxWidth: '900px',
        content: `
          <div style="margin-bottom: 15px;">
            <input type="text" id="filtro-nf" class="form-control" 
                placeholder="Filtrar por ID, nome ou data..." style="width: 100%; padding: 8px;">
          </div>
          <div style="max-height: 400px; overflow-y: auto;">
            <div class="nf-list-header" style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; padding: 10px; border-bottom: 1px solid #ddd;">
              <div>ID</div>
              <div>Nome</div>
              <div>Data</div>
              <div>Valor</div>
            </div>
            <div id="lista-nf"></div>
          </div>
        `
      });
      
      const filtroNF = document.getElementById('filtro-nf');
      const listaNF = document.getElementById('lista-nf');
      
      function atualizarListaNF() {
        const termo = filtroNF.value.toLowerCase();
        listaNF.innerHTML = '';
        
        estoque
          .filter(item => 
            item.id_pecas.toLowerCase().includes(termo) ||
            item.nome.toLowerCase().includes(termo) ||
            item.data_registro.toLowerCase().includes(termo)
          )
          .forEach(item => {
            const div = document.createElement('div');
            div.className = 'nf-list-item';
            div.style.display = 'grid';
            div.style.gridTemplateColumns = '1fr 2fr 1fr 1fr';
            div.style.alignItems = 'center';
            div.innerHTML = `
              <div>${item.id_pecas}</div>
              <div>${item.nome}</div>
              <div>${item.data_registro}</div>
              <div>R$ ${parseFloat(item.preco).toFixed(2)}</div>
            `;
            div.addEventListener('click', () => imprimirNF(item));
            listaNF.appendChild(div);
          });
      }
      
      filtroNF.addEventListener('input', atualizarListaNF);
      selecionarNFModal.show();
      atualizarListaNF();
    });
  }
  
  function imprimirNF(item) {
    const previewModal = modalFactory.createModal({
        id: 'modal-preview-nf',
        title: 'Pré-visualização da Nota Fiscal',
        width: '90%',
        maxWidth: '700px',
        height: 'auto', // Alterado para altura automática
        content: `
            <div id="nota-fiscal-preview" style="width: 100%; max-height: 75vh; overflow: hidden; background: white; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                <!-- O conteúdo será gerado dinamicamente -->
            </div>
            <div style="margin-top: 15px; text-align: center; padding: 10px;">
                <button id="btn-imprimir-nf" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                    Imprimir Nota Fiscal
                </button>
                <button id="btn-fechar-preview" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-left: 10px;">
                    Fechar
                </button>
            </div>
        `
    });

    // Gerar o conteúdo da nota fiscal com escala ajustada
    const dataFormatada = new Date(item.data_registro).toLocaleDateString('pt-BR');
    const valorTotal = parseFloat(item.preco) * parseInt(item.quantidade);
    
    const previewContent = `
        <div style="width: 100%; transform: scale(0.8); transform-origin: top center;">
            <style>
                .nf-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                    font-size: 12px;
                }
                .nf-table th, .nf-table td {
                    border: 1px solid #ddd;
                    padding: 5px;
                    text-align: left;
                }
                .nf-table th {
                    background-color: #f2f2f2;
                }
                .text-right {
                    text-align: right;
                }
                .nf-header {
                    border-bottom: 1px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 10px;
                }
                .nf-footer {
                    border-top: 1px solid #000;
                    padding-top: 10px;
                    margin-top: 20px;
                    text-align: center;
                    font-size: 12px;
                }
                h1 {
                    font-size: 18px;
                    margin: 3px 0;
                }
                h3 {
                    font-size: 14px;
                }
                p {
                    margin: 3px 0;
                    font-size: 12px;
                }
            </style>
            
            <div class="nf-header">
                <h1 style="text-align: center;">NOTA FISCAL</h1>
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <div style="width: 60%;">
                        <p><strong>Conserta Tech</strong></p>
                        <p>00.623.904/0001-73</p>
                        <p>Rua Imaginária, 142 - Joinville/SC</p>
                        <p>IE: 123.456.789</p>
                    </div>
                    <div style="width: 35%;">
                        <p><strong>Nº NF:</strong> ${item.id_pecas}</p>
                        <p><strong>Data Emissão:</strong> ${dataFormatada}</p>
                        <p><strong>Série:</strong> ${item.numero_serie || '001'}</p>
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <h3>DADOS DO CLIENTE</h3>
                <p><strong>Nome:</strong> ${item.nome}</p>
                <p><strong>Aparelho:</strong> ${item.aparelho_utilizado || 'Não informado'}</p>
            </div>
            
            <table class="nf-table">
                <thead>
                    <tr>
                        <th width="50%">Descrição</th>
                        <th width="15%">Quantidade</th>
                        <th width="15%">Valor Unitário</th>
                        <th width="20%">Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${item.descricao || 'Serviço técnico/Peça'}</td>
                        <td>${item.quantidade}</td>
                        <td>R$ ${parseFloat(item.preco).toFixed(2)}</td>
                        <td>R$ ${valorTotal.toFixed(2)}</td>
                    </tr>
                </tbody>
            </table>
            
            <div style="margin-top: 10px;">
                <div style="float: right; width: 200px;">
                    <table style="width: 100%; font-size: 12px;">
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td class="text-right">R$ ${valorTotal.toFixed(2)}</td>
                        </tr>
                    </table>
                </div>
                <div style="clear: both;"></div>
            </div>
            
            <div class="nf-footer">
                <p>Conserta Tech - ${new Date().getFullYear()}</p>
                <p>Obrigado pela preferência!</p>
            </div>
        </div>
    `;

    document.getElementById('nota-fiscal-preview').innerHTML = previewContent;

    // Configurar eventos dos botões
    document.getElementById('btn-imprimir-nf').addEventListener('click', function() {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Nota Fiscal ${item.id_pecas}</title>
                <style>
                    body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
                    .page { width: 210mm; min-height: 297mm; margin: 0 auto; padding: 20mm; box-sizing: border-box; }
                    .nf-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
                    .nf-table th, .nf-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .nf-table th { background-color: #f2f2f2; }
                    .text-right { text-align: right; }
                    .nf-header { border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 20px; }
                    .nf-footer { border-top: 2px solid #000; padding-top: 20px; margin-top: 40px; text-align: center; }
                    @media print {
                        body { -webkit-print-color-adjust: exact; }
                        .page { page-break-after: always; }
                    }
                </style>
            </head>
            <body onload="window.print();">
                <div style="width: 210mm; min-height: 297mm; margin: 0 auto; padding: 20mm; box-sizing: border-box; background: white; font-family: Arial, sans-serif;">
                    ${previewContent.replace('transform: scale(0.8);', '').replace(/font-size:\s*\d+px/g, 'font-size: 14px')}
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
    });

    document.getElementById('btn-fechar-preview').addEventListener('click', function() {
        previewModal.close();
    });

    previewModal.show();
}});