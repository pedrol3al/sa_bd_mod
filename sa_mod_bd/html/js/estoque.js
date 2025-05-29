document.addEventListener("DOMContentLoaded", function () {
  const modalFactory = new ModalFactory();
  const cadastrarBtn = document.querySelector(".cadastrar");
  const novoBtn = document.querySelector(".novo");
  const pesquisarBtn = document.querySelector(".pesquisar");
  let editandoItem = null;

  // Função para alternar entre modo de edição e cadastro
  function toggleModoEdicao(editando, item = null) {
    editandoItem = item;

    if (editando) {
      cadastrarBtn.textContent = "Salvar alterações";
      if (novoBtn) novoBtn.textContent = "Cancelar edição";
      
      // Bloquear o campo ID durante a edição
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = true;
        idPecaInput.style.backgroundColor = "#f5f5f5";
        idPecaInput.style.cursor = "not-allowed";
      }
    } else {
      cadastrarBtn.textContent = "Salvar";
      if (novoBtn) novoBtn.textContent = "Novo";
      document.querySelector(".formulario").reset();
      editandoItem = null;
      
      // Liberar o campo ID
      const idPecaInput = document.getElementById("id_pecas");
      if (idPecaInput) {
        idPecaInput.readOnly = false;
        idPecaInput.style.backgroundColor = "";
        idPecaInput.style.cursor = "";
      }
    }
  }

  // Função para validar campos obrigatórios
  function validarCampos() {
    const campos = [
      "id_pecas",
      "id_fornecedor",
      "nome",
      "aparelho_utilizado",
      "quantidade",
      "preco",
      "data_registro",
      "status",
      "tipo",
      "numero_serie",
      "descricao"
    ];

    for (let id of campos) {
      const campo = document.getElementById(id);
      if (campo && campo.value.trim() === "") {
        Swal.fire({
          icon: 'warning',
          title: 'Campo obrigatório',
          text: `Preencha o campo: ${campo.previousElementSibling?.innerText || id.replace(/_/g, ' ')}`
        });
        campo.focus();
        return false;
      }
    }
    return true;
  }

  // Função para salvar ou atualizar item
  function salvarItem() {
    if (!validarCampos()) return;

    const idPeca = document.getElementById("id_pecas").value.trim();
    let estoque = JSON.parse(localStorage.getItem("estoque")) || [];

    if (editandoItem) {
      const index = estoque.findIndex(item => item.id_pecas === editandoItem.id_pecas);

      if (index !== -1) {
        if (idPeca !== editandoItem.id_pecas && estoque.some(item => item.id_pecas === idPeca)) {
          Swal.fire({
            icon: 'error',
            title: 'ID já cadastrado',
            text: 'Já existe uma peça com esse ID. Por favor, use outro.'
          });
          document.getElementById("id_pecas").focus();
          return;
        }

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

        localStorage.setItem("estoque", JSON.stringify(estoque));

        Swal.fire({
          icon: 'success',
          title: 'Sucesso!',
          text: 'Item atualizado com sucesso!'
        });

        toggleModoEdicao(false);
      }
    } else {
      if (estoque.some(item => item.id_pecas === idPeca)) {
        Swal.fire({
          icon: 'error',
          title: 'ID já cadastrado',
          text: 'Já existe uma peça com esse ID. Por favor, use outro.'
        });
        document.getElementById("id_pecas").focus();
        return;
      }

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

      estoque.push(itemEstoque);
      localStorage.setItem("estoque", JSON.stringify(estoque));

      Swal.fire({
        icon: 'success',
        title: 'Sucesso!',
        text: 'Item cadastrado com sucesso!'
      });

      document.querySelector(".formulario").reset();
    }
  }

  // Event listeners para os botões principais
  cadastrarBtn.addEventListener("click", function (e) {
    e.preventDefault();
    salvarItem();
  });

  if (novoBtn) {
    novoBtn.addEventListener("click", function (e) {
      e.preventDefault();

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
            toggleModoEdicao(false);
          }
        });
      } else {
        document.querySelector(".formulario").reset();
      }
    });
  }

  // Função para preencher formulário com dados de um item
  window.preencherFormulario = function (item) {
    const campos = [
      "id_pecas", "id_fornecedor", "nome", "aparelho_utilizado",
      "quantidade", "preco", "data_registro", "status",
      "tipo", "numero_serie", "descricao"
    ];
    
    campos.forEach(campo => {
      const input = document.getElementById(campo);
      if (input) input.value = item[campo] || '';
    });
  };

  // Função para editar um item
  window.editarItem = function (item) {
    preencherFormulario(item);
    toggleModoEdicao(true, item);
  };

  // Configuração do modal de pesquisa
  if (pesquisarBtn) {
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

    pesquisarBtn.addEventListener("click", function (e) {
      e.preventDefault();
      pesquisaModal.show();
      inputPesquisa.value = "";
      resultado.innerHTML = "<p>Digite um termo para buscar.</p>";
      inputPesquisa.focus();
    });

    inputPesquisa.addEventListener("input", function () {
      const termo = inputPesquisa.value.trim().toLowerCase();
      const estoque = JSON.parse(localStorage.getItem("estoque")) || [];

      resultado.innerHTML = termo === ""
        ? "<p>Digite um termo para buscar.</p>"
        : gerarResultadosPesquisa(estoque, termo);
    });

    // Função para gerar resultados da pesquisa
    function gerarResultadosPesquisa(estoque, termo) {
      const encontrados = estoque.filter(item =>
        item.nome.toLowerCase().includes(termo) ||
        item.id_pecas.toLowerCase().includes(termo)
      );

      if (encontrados.length === 0) {
        return "<p>Nenhum resultado encontrado.</p>";
      }

      let html = '';
      encontrados.forEach(item => {
        html += `
          <div style="padding: 8px; border-bottom: 1px solid #ccc; cursor: pointer;
              transition: background-color 0.2s; margin-bottom: 10px;"
              onmouseenter="this.style.backgroundColor='#f5f5f5'"
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

    // Função para visualizar detalhes de um item
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

    // Função para excluir um item
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
          estoque = estoque.filter(peca => peca.id_pecas !== item.id_pecas);
          localStorage.setItem("estoque", JSON.stringify(estoque));
          inputPesquisa.dispatchEvent(new Event('input'));
          Swal.fire(
            'Excluído!',
            'A peça foi removida do estoque.',
            'success'
          );
        }
      });
    };

    // Função para preencher formulário e fechar modal
    window.preencherFormularioEfechar = function(item) {
      preencherFormulario(item);
      pesquisaModal.close();
    };
  }
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
// Aplicar mascaras

document.addEventListener("DOMContentLoaded", function () {
  // ========== APLICA MÁSCARA DE VALOR ==============
  function aplicarMascaraValor() {
    const campos = document.querySelectorAll('.input-valor, #preco'); // Adiciona tanto classes quanto IDs específicos

    campos.forEach(campo => {
      // Adiciona os event listeners
      campo.addEventListener('input', formatarValor);
      campo.addEventListener('blur', finalizarFormatacao);
      campo.addEventListener('focus', prepararEdicao);

      // Preenche com R$ 0,00 ao carregar vazio
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

      // Formata com 2 casas decimais
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

  // Chama a função para aplicar as máscaras
  aplicarMascaraValor();

  // ========== VALIDAÇÃO DE CAMPOS NUMÉRICOS ==============
  const camposNumericos = ["id_pecas", "id_fornecedor"];
  camposNumericos.forEach(id => {
    const campo = document.getElementById(id);
    if (campo) {
      campo.addEventListener("keydown", function(e) {
        const teclasPermitidas = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'];
        if (teclasPermitidas.includes(e.key)) return;
        if (!/^[0-9]$/.test(e.key)) e.preventDefault();
      });
    }
  });

 document.addEventListener("DOMContentLoaded", function () {
  // ========== VALIDAÇÃO DE CAMPOS NUMÉRICOS ==============
  const camposNumericos = ["id_pecas", "id_fornecedor", "quantidade"]; 
  
  camposNumericos.forEach(id => {
    const campo = document.getElementById(id);
    if (campo) {
      // Impede a digitação de caracteres não numéricos
      campo.addEventListener("keydown", function(e) {
        const teclasPermitidas = [
          'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab',
          'Home', 'End'
        ];
        
        // Permite: teclas de controle, números e numpad
        if (teclasPermitidas.includes(e.key) || 
            /^[0-9]$/.test(e.key) || 
            (e.key >= '0' && e.key <= '9' && e.key.length === 1)) {
          return;
        }
        
        // Permite Ctrl+C, Ctrl+V, Ctrl+X
        if (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'x')) {
          return;
        }
        
        // Bloqueia qualquer outra tecla
        e.preventDefault();
      });

      // Validação adicional ao colar conteúdo
      campo.addEventListener("paste", function(e) {
        e.preventDefault();
        const texto = (e.clipboardData || window.clipboardData).getData('text');
        const numeros = texto.replace(/\D/g, '');
        document.execCommand('insertText', false, numeros);
      });

      // Garante que o valor final seja numérico
      campo.addEventListener("blur", function() {
        if (campo.value && !/^\d+$/.test(campo.value)) {
          campo.value = campo.value.replace(/\D/g, '');
          if (!campo.value) campo.value = '0';
        }
      });
    }
  });

 
});
});

