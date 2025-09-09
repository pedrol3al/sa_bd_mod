// Aguarda o carregamento completo do DOM antes de executar o código
document.addEventListener("DOMContentLoaded", function () {
  // Cria uma instância da fábrica de modais para criar janelas popup
  const modalFactory = new ModalFactory();
  
  // Seleciona os botões principais da interface
  const cadastrarBtn = document.querySelector(".cadastrar");
  const novoBtn = document.querySelector(".novo");
  const pesquisarBtn = document.querySelector(".pesquisar");
  
  // Variável para controlar se está editando um item existente
  let editandoItem = null;

  // Função para alternar entre modo de edição e cadastro
  function toggleModoEdicao(editando, item = null) {
    editandoItem = item; // Armazena o item sendo editado

    if (editando) {
      // Modo edição: altera textos dos botões
      cadastrarBtn.textContent = "Salvar alterações";
      if (novoBtn) novoBtn.textContent = "Cancelar edição";
      
      // Bloqueia o campo ID durante a edição (não pode alterar ID)
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = true; // Impede edição
        idPecaInput.style.backgroundColor = "#f5f5f5"; // Visual cinza
        idPecaInput.style.cursor = "not-allowed"; // Cursor bloqueado
      }
    } else {
      // Modo cadastro: textos normais dos botões
      cadastrarBtn.textContent = "Salvar";
      if (novoBtn) novoBtn.textContent = "Novo";
      
      // Limpa o formulário e reseta variável de edição
      document.querySelector(".formulario").reset();
      editandoItem = null;
      
      // Libera o campo ID para edição
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = false;
        idPecaInput.style.backgroundColor = ""; // Volta cor normal
        idPecaInput.style.cursor = ""; // Cursor normal
      }
    }
  }

  // Função para validar campos obrigatórios antes de salvar
  function validarCampos() {
    // Lista de IDs dos campos obrigatórios
    const campos = [
      "id_pecas", "id_fornecedor", "nome", "aparelho_utilizado",
      "quantidade", "preco", "data_registro", "status",
      "tipo", "numero_serie", "descricao"
    ];

    // Verifica cada campo da lista
    for (let id of campos) {
      const campo = document.getElementById(id);
      // Se campo existe e está vazio, mostra erro
      if (campo && campo.value.trim() === "") {
        Swal.fire({
          icon: 'warning',
          title: 'Campo obrigatório',
          // Mensagem com nome do campo (pega do label ou do ID)
          text: `Preencha o campo: ${campo.previousElementSibling?.innerText || id.replace(/_/g, ' ')}`
        });
        campo.focus(); // Coloca foco no campo vazio
        return false; // Impede o salvamento
      }
    }
    return true; // Todos os campos preenchidos
  }

  // Função principal para salvar ou atualizar item
  function salvarItem() {
    if (!validarCampos()) return; // Se validação falhar, não continua

    const idPeca = document.getElementById("id_pecas").value.trim();
    // Busca estoque do localStorage ou array vazio se não existir
    let estoque = JSON.parse(localStorage.getItem("estoque")) || [];

    // ========== MODO EDIÇÃO ==========
    if (editandoItem) {
      // Encontra índice do item sendo editado
      const index = estoque.findIndex(item => item.id_pecas === editandoItem.id_pecas);

      if (index !== -1) {
        // Verifica se o novo ID já existe (se foi alterado)
        if (idPeca !== editandoItem.id_pecas && estoque.some(item => item.id_pecas === idPeca)) {
          Swal.fire({
            icon: 'error',
            title: 'ID já cadastrado',
            text: 'Já existe uma peça com esse ID. Por favor, use outro.'
          });
          document.getElementById("id_pecas").focus();
          return; // Impede salvar com ID duplicado
        }

        // Atualiza o item no array estoque
        estoque[index] = {
          id_pecas: idPeca,
          id_fornecedor: document.getElementById("id_fornecedor").value.trim(),
          nome: document.getElementById("nome").value.trim(),
          aparelho_utilizado: document.getElementById("aparelho_utilizado").value.trim(),
          quantidade: document.getElementById("quantidade").value.trim(),
          preco: document.getElementById("preco").value.trim(),
          data_registro: document.getElementById("data_registro").value,
          status: document.getElementById("status").value,
          tipo: document.getElementById("tipo").value.trim(),
          numero_serie: document.getElementById("numero_serie").value.trim(),
          descricao: document.getElementById("descricao").value.trim()
        };

        // Salva array atualizado no localStorage
        localStorage.setItem("estoque", JSON.stringify(estoque));

        // Feedback de sucesso
        Swal.fire({
          icon: 'success',
          title: 'Sucesso!',
          text: 'Item atualizado com sucesso!'
        });

        // Volta para modo cadastro
        toggleModoEdicao(false);
      }
      
    // ========== MODO CADASTRO ==========
    } else {
      // Verifica se ID já existe
      if (estoque.some(item => item.id_pecas === idPeca)) {
        Swal.fire({
          icon: 'error',
          title: 'ID já cadastrado',
          text: 'Já existe uma peça com esse ID. Por favor, use outro.'
        });
        document.getElementById("id_pecas").focus();
        return;
      }

      // Cria novo objeto com dados do formulário
      const itemEstoque = {
        id_pecas: idPeca,
        id_fornecedor: document.getElementById("id_fornecedor").value.trim(),
        nome: document.getElementById("nome").value.trim(),
        aparelho_utilizado: document.getElementById("aparelho_utilizado").value.trim(),
        quantidade: document.getElementById("quantidade").value.trim(),
        preco: document.getElementById("preco").value.trim(),
        data_registro: document.getElementById("data_registro").value,
        status: document.getElementById("status").value,
        tipo: document.getElementById("tipo").value.trim(),
        numero_serie: document.getElementById("numero_serie").value.trim(),
        descricao: document.getElementById("descricao").value.trim()
      };

      // Adiciona novo item ao array
      estoque.push(itemEstoque);
      // Salva no localStorage
      localStorage.setItem("estoque", JSON.stringify(estoque));

      // Feedback de sucesso
      Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: 'Item cadastrado com sucesso!'
      });

      // Limpa formulário
      document.querySelector(".formulario").reset();
    }
  }

  // ========== EVENT LISTENERS DOS BOTÕES ==========

  // Botão Salvar/Salvar alterações
  cadastrarBtn.addEventListener("click", function (e) {
    e.preventDefault(); // Impede submit padrão do formulário
    salvarItem(); // Chama função de salvar
  });

  // Botão Novo/Cancelar
  if (novoBtn) {
    novoBtn.addEventListener("click", function (e) {
      e.preventDefault();

      // Se está editando, pede confirmação para cancelar
      if (editandoItem) {
        Swal.fire({
          title: 'Cancelar edição?',
          text: "Todas as alterações não salvas serão perdidas.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, cancelar',
          cancelButtonText: 'Continuar editando'
        }).then((result) => {
          if (result.isConfirmed) {
            toggleModoEdicao(false); // Volta ao modo cadastro
          }
        });
      } else {
        // Se não está editando, apenas limpa o formulário
        document.querySelector(".formulario").reset();
      }
    });
  }

  // ========== FUNÇÕES GLOBAIS (acessíveis via HTML) ==========

  // Preenche formulário com dados de um item
  window.preencherFormulario = function (item) {
    const campos = [
      "id_pecas", "id_fornecedor", "nome", "aparelho_utilizado",
      "quantidade", "preco", "data_registro", "status",
      "tipo", "numero_serie", "descricao"
    ];
    
    // Para cada campo, preenche com valor do item ou string vazia
    campos.forEach(campo => {
      const input = document.getElementById(campo);
      if (input) input.value = item[campo] || '';
    });
  };

  // Inicia edição de um item
  window.editarItem = function (item) {
    preencherFormulario(item); // Preenche formulário
    toggleModoEdicao(true, item); // Muda para modo edição
  };

  // ========== MODAL DE PESQUISA ==========
  if (pesquisarBtn) {
    // Cria modal de pesquisa personalizado
    const pesquisaModal = modalFactory.createModal({
      id: 'modal-pesquisa-pecas',
      title: 'Pesquisar Peça',
      width: '80%',
      maxWidth: '1000px',
      height: '600px',
      content: `
        <div style="margin-bottom: 15px;">
          <input type="text" id="input-pesquisa" class="form-control" 
              placeholder="Digite o nome ou ID da peça..." style="width: 100%; padding: 8px;">
        </div>
        <div id="resultado-pesquisa" style="margin-top: 15px; max-height: 400px; 
            overflow-y: auto; border-top: 1px solid #ddd; padding-top: 10px;"></div>
      `
    });

    const inputPesquisa = document.getElementById('input-pesquisa');
    const resultado = document.getElementById('resultado-pesquisa');

    // Abre modal ao clicar em Pesquisar
    pesquisarBtn.addEventListener("click", function (e) {
      e.preventDefault();
      pesquisaModal.show(); // Mostra modal
      inputPesquisa.value = ""; // Limpa campo de pesquisa
      resultado.innerHTML = "<p>Digite um termo para buscar.</p>"; // Mensagem inicial
      inputPesquisa.focus(); // Foca no campo de pesquisa
    });

    // Pesquisa em tempo real enquanto digita
    inputPesquisa.addEventListener("input", function () {
      const termo = inputPesquisa.value.trim().toLowerCase(); // Termo em minúsculo
      const estoque = JSON.parse(localStorage.getItem("estoque")) || []; // Busca estoque

      // Atualiza resultados ou mostra mensagem padrão
      resultado.innerHTML = termo === ""
        ? "<p>Digite um termo para buscar.</p>"
        : gerarResultadosPesquisa(estoque, termo);
    });

    // Gera HTML dos resultados da pesquisa
    function gerarResultadosPesquisa(estoque, termo) {
      // Filtra itens que contenham o termo no nome ou ID
      const encontrados = estoque.filter(item =>
        item.nome.toLowerCase().includes(termo) ||
        item.id_pecas.toLowerCase().includes(termo)
      );

      if (encontrados.length === 0) {
        return "<p>Nenhum resultado encontrado.</p>";
      }

      // Constrói HTML para cada item encontrado
      let html = '';
      encontrados.forEach(item => {
        html += `
          <div style="padding: 8px; border-bottom: 1px solid #ccc; cursor: pointer;
              transition: background-color 0.2s; margin-bottom: 10px;"
              onmouseenter="this.style.backgroundColor='#f5f5f5'" // Efeito hover
              onmouseleave="this.style.backgroundColor=''"
              onclick="preencherFormularioEfechar(${JSON.stringify(item).replace(/"/g, '&quot;')})">
              
              <strong>ID:</strong> ${item.id_pecas}<br>
              <strong>Nome:</strong> ${item.nome}<br>
              <strong>Quantidade:</strong> ${item.quantidade}
              
              <div class="btn-group" style="margin-top: 8px; display: flex; gap: 5px;">
                <button class="btn-visualizar" 
                    style="padding: 4px 8px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;"
                    onclick="event.stopPropagation(); visualizarDetalhes(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                    Visualizar
                </button>
                <button class="btn-editar" 
                    style="padding: 4px 8px; background: #FFC107; color: black; border: none; border-radius: 4px; cursor: pointer;"
                    onclick="event.stopPropagation(); editarItem(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                    Editar
                </button>
                <button class="btn-excluir" 
                    style="padding: 4px 8px; background: #F44336; color: white; border: none; border-radius: 4px; cursor: pointer;"
                    onclick="event.stopPropagation(); excluirItem(${JSON.stringify(item).replace(/"/g, '&quot;')})">
                    Excluir
                </button>
              </div>
          </div>
        `;
      });
      return html;
    }

    // Abre modal com detalhes completos do item
    window.visualizarDetalhes = function(item) {
      const detalhesContent = `
        <h3 style="margin-top: 0; color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px;">
          Detalhes da Peça: ${item.nome}
        </h3>
        <div style="margin-top: 15px;">
          ${Object.entries(item).map(([key, val]) => `
            <p style="margin: 8px 0; padding: 5px; background-color: ${Math.random() > 0.5 ? '#f9f9f9' : 'white'};">
              <strong style="text-transform: capitalize;">${key.replace(/_/g, ' ')}:</strong> ${val}
            </p>
          `).join('')}
        </div>
      `;

      const detalhesModal = modalFactory.createModal({
        id: 'modal-detalhes-peca',
        title: 'Detalhes da Peça',
        width: '60%',
        maxWidth: '800px',
        content: detalhesContent
      });

      detalhesModal.show();
    };

    // Exclui item com confirmação
    window.excluirItem = function(item) {
      Swal.fire({
        title: 'Tem certeza?',
        text: `Você está prestes a excluir a peça "${item.nome}" (ID: ${item.id_pecas})`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          let estoque = JSON.parse(localStorage.getItem("estoque")) || [];
          // Filtra removendo o item pelo ID
          estoque = estoque.filter(peca => peca.id_pecas !== item.id_pecas);
          localStorage.setItem("estoque", JSON.stringify(estoque));
          // Atualiza resultados da pesquisa
          inputPesquisa.dispatchEvent(new Event('input'));
          Swal.fire(
            'Excluído!',
            'A peça foi removida do estoque.',
            'success'
          );
        }
      });
    };

    // Preenche formulário e fecha modal de pesquisa
    window.preencherFormularioEfechar = function(item) {
      preencherFormulario(item);
      pesquisaModal.close();
    };
  }
});

// ========== CLASSE ModalFactory ==========
// Responsável por criar e gerenciar modais (janelas popup)
class ModalFactory {
  constructor() {
    this.overlay = this.createOverlay(); // Fundo escuro
    document.body.appendChild(this.overlay);
  }

  // Cria overlay (fundo escuro semi-transparente)
  createOverlay() {
    const overlay = document.createElement("div");
    overlay.id = 'modal-overlay';
    Object.assign(overlay.style, {
      display: 'none', position: 'fixed', top: '0', left: '0',
      width: '100%', height: '100%', backgroundColor: 'rgba(0,0,0,0.5)', zIndex: '999'
    });
    return overlay;
  }

  // Cria modal personalizado com configurações
  createModal({ id = 'custom-modal', title = '', content = '', width = 'auto', height = 'auto', maxWidth = 'none' }) {
    // Remove modal existente com mesmo ID (evita duplicação)
    const existing = document.getElementById(id);
    if (existing) existing.remove();

    // Cria elemento do modal
    const modal = document.createElement("div");
    modal.id = id;
    modal.className = 'custom-modal';
    Object.assign(modal.style, {
      display: 'none', position: 'fixed', top: '50%', left: '50%',
      transform: 'translate(-50%, -50%)', backgroundColor: 'white',
      padding: '20px', borderRadius: '8px', boxShadow: '0 0 10px rgba(0,0,0,0.3)',
      zIndex: '1000', height, width, maxWidth, overflow: 'auto'
    });

    // Cria cabeçalho do modal com título e botão fechar
    const header = document.createElement("div");
    Object.assign(header.style, {
      display: 'flex', justifyContent: 'space-between', alignItems: 'center',
      marginBottom: '20px', borderBottom: '1px solid #eee', paddingBottom: '10px'
    });

    const titleElement = document.createElement("h2");
    titleElement.textContent = title;
    titleElement.style.margin = '0';

    const closeButton = document.createElement("button");
    closeButton.innerHTML = '&times;'; // "X" para fechar
    Object.assign(closeButton.style, {
      background: 'none', border: 'none', fontSize: '24px',
      cursor: 'pointer', color: 'black'
    });

    header.appendChild(titleElement);
    header.appendChild(closeButton);

    // Corpo do modal com conteúdo HTML
    const body = document.createElement("div");
    body.className = 'modal-body';
    body.innerHTML = content;

    modal.appendChild(header);
    modal.appendChild(body);
    document.body.appendChild(modal);

    // Eventos para fechar modal
    closeButton.addEventListener('click', () => this.closeModal(modal));
    this.overlay.addEventListener('click', () => this.closeModal(modal));

    // Retorna interface pública do modal
    return {
      element: modal,
      show: () => this.showModal(modal),
      close: () => this.closeModal(modal),
      updateContent: (newContent) => { body.innerHTML = newContent; }
    };
  }

  // Mostra modal e overlay
  showModal(modal) {
    modal.style.display = 'block';
    this.overlay.style.display = 'block';
    this.aplicarBlur(); // Aplica efeito blur no fundo
  }

  // Esconde modal e overlay
  closeModal(modal) {
    modal.style.display = 'none';
    this.overlay.style.display = 'none';
    this.removerBlur(); // Remove efeito blur
  }

  // Aplica efeito blur nos elementos de fundo
  aplicarBlur() {
    document.querySelectorAll("#menu-container, .conteudo").forEach(el => {
      el.style.filter = "blur(5px)";
      el.style.pointerEvents = "none"; // Impede interação
      el.style.userSelect = "none"; // Impede seleção de texto
    });
  }

  // Remove efeito blur dos elementos de fundo
  removerBlur() {
    document.querySelectorAll("#menu-container, .conteudo").forEach(el => {
      el.style.filter = "";
      el.style.pointerEvents = "";
      el.style.userSelect = "";
    });
  }
}

// ========== MÁSCARAS E VALIDAÇÕES ==========
document.addEventListener("DOMContentLoaded", function () {
  // Aplica máscara de valor monetário (R$) nos campos
  function aplicarMascaraValor() {
    const campos = document.querySelectorAll('.input-valor, #preco');

    campos.forEach(campo => {
      // Adiciona eventos para formatar durante digitação
      campo.addEventListener('input', formatarValor);
      campo.addEventListener('blur', finalizarFormatacao);
      campo.addEventListener('focus', prepararEdicao);

      // Inicializa com R$ 0,00 se estiver vazio
      if (!campo.value.trim() || campo.value === 'R$ NaN') {
        campo.value = 'R$ 0,00';
      }
    });

    // Formata valor durante digitação
    function formatarValor(e) {
      let valor = e.target.value.replace(/\D/g, ''); // Remove não-dígitos
      
      if (valor === '') {
        e.target.value = 'R$ 0,00';
        return;
      }

      let numero = parseInt(valor, 10);
      if (isNaN(numero)) {
        e.target.value = 'R$ 0,00';
        return;
      }

      // Formata como moeda brasileira (divide por 100 para centavos)
      valor = (numero / 100).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      e.target.value = 'R$ ' + valor;
    }

    // Formatação final quando perde foco
    function finalizarFormatacao(e) {
      let valor = e.target.value.replace(/\D/g, '');
      if (valor === '' || parseInt(valor) === 0) {
        e.target.value = 'R$ 0,00';
      }
    }

    // Prepara campo para edição (remove formatação)
    function prepararEdicao(e) {
      let valor = e.target.value.replace(/\D/g, '');
      e.target.value = valor === '0' ? '' : valor;
    }
  }

  aplicarMascaraValor(); // Aplica máscaras

  // Validação para campos numéricos (apenas números)
  const camposNumericos = ["id_pecas", "id_fornecedor"];
  camposNumericos.forEach(id => {
    const campo = document.getElementById(id);
    if (campo) {
      campo.addEventListener("keydown", function(e) {
        const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
        if (teclasPermitidas.includes(e.key)) return; // Permite teclas de controle
        if (!/^[0-9]$/.test(e.key)) e.preventDefault(); // Bloqueia não-números
      });
    }
  });

  // Validação mais completa para campos numéricos
  document.addEventListener("DOMContentLoaded", function () {
    const camposNumericos = ["id_pecas", "id_fornecedor", "quantidade"]; 
    
    camposNumericos.forEach(id => {
      const campo = document.getElementById(id);
      if (campo) {
        // Impede digitação de caracteres não numéricos
        campo.addEventListener("keydown", function(e) {
          const teclasPermitidas = [
            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab',
            'Home', 'End'
          ];
          
          // Permite: teclas de controle, números do teclado e numpad
          if (teclasPermitidas.includes(e.key) || 
              /^[0-9]$/.test(e.key) || 
              (e.key >= '0' && e.key <= '9' && e.key.length === 1)) {
            return;
          }
          
          // Permite atalhos de copiar/colar/recortar
          if (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'x')) {
            return;
          }
          
          e.preventDefault(); // Bloqueia outras teclas
        });

        // Tratamento especial para colar (Ctrl+V)
        campo.addEventListener("paste", function(e) {
          e.preventDefault(); // Impede colagem padrão
          const texto = (e.clipboardData || window.clipboardData).getData('text');
          const numeros = texto.replace(/\D/g, ''); // Filtra apenas números
          document.execCommand('insertText', false, numeros); // Insere números filtrados
        });

        // Validação final quando perde foco
        campo.addEventListener("blur", function() {
          if (campo.value && !/^\d+$/.test(campo.value)) {
            campo.value = campo.value.replace(/\D/g, ''); // Remove não-números
            if (!campo.value) campo.value = '0'; // Padrão para vazio
          }
        });
      }
    });
  });
});