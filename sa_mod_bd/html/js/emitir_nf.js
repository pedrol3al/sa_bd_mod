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

  // Listener de teste para o botão cadastrar
  cadastrarBtn.addEventListener("click", function(e) {
    console.log("Botão cadastrar clicado - Início do processamento");
    e.preventDefault();
    salvarItem();
  });

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

  // Função para validar campos obrigatórios (com mais feedback)
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
        
        // Fallback caso SweetAlert2 não esteja disponível
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

  // Função para salvar ou atualizar item (com mais logs)
 function salvarItem() {
    console.log("Iniciando processo de salvamento");
    
    if (!validarCampos()) {
        console.log("Salvamento interrompido: validação falhou");
        return;
    }

    // Verificação segura de todos os campos do formulário
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

    let estoque = JSON.parse(localStorage.getItem("estoque")) || [];
    console.log(`ID da peça: ${idPeca}, Itens no estoque: ${estoque.length}`);

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

  // [Restante do seu código original...]
  // As funções de preencherFormulario, editarItem, pesquisar, etc...
  // permanecem exatamente como no seu código original

  // Inicialização de máscaras e validações
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

  // Inicializa as máscaras e validações
  aplicarMascaraValor();
  configurarCamposNumericos();

  // Configuração do botão de impressão
  const btnImprimir = document.getElementById('btn-imprimir');
  if (btnImprimir) {
    btnImprimir.addEventListener('click', function() {
      const estoque = JSON.parse(localStorage.getItem("estoque")) || [];
      
      if (estoque.length === 0) {
        Swal.fire({
          icon: 'info',
          title: 'Nenhuma NF cadastrada',
          text: 'Não há notas fiscais cadastradas para impressão.'
        });
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
    const printDiv = document.createElement('div');
    printDiv.id = 'nota-fiscal-print';
    
    const dataFormatada = new Date(item.data_registro).toLocaleDateString('pt-BR');
    const valorTotal = parseFloat(item.preco) * parseInt(item.quantidade);
    
    printDiv.innerHTML = `
      <div class="nota-fiscal-container">
        <div class="nota-fiscal-header">
          <h2>NOTA FISCAL</h2>
          <p>Conserta Tech - 00.623.904/0001-73</p>
          <p>Rua Imaginária, 142 - Joinville/SC</p>
          <p>IE: 123.456.789</p>
        </div>
        
        <div class="nota-fiscal-body">
          <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div>
              <p><strong>Número NF:</strong> ${item.id_pecas}</p>
              <p><strong>Data Emissão:</strong> ${dataFormatada}</p>
            </div>
            <div>
              <p><strong>Número Série:</strong> ${item.numero_serie}</p>
            </div>
          </div>
          
          <div class="nota-fiscal-cliente">
            <h3>Dados do Cliente</h3>
            <p><strong>Nome:</strong> ${item.nome}</p>
            <p><strong>Aparelho:</strong> ${item.aparelho_utilizado}</p>
          </div>
          
          <table class="nota-fiscal-table">
            <thead>
              <tr>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Valor Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>${item.descricao || 'Serviço técnico'}</td>
                <td>${item.quantidade}</td>
                <td>R$ ${parseFloat(item.preco).toFixed(2)}</td>
                <td>R$ ${valorTotal.toFixed(2)}</td>
              </tr>
            </tbody>
          </table>
          
          <div style="text-align: right; margin-top: 20px;">
            <p><strong>Valor Total:</strong> R$ ${valorTotal.toFixed(2)}</p>
          </div>
        </div>
        
        <div class="nota-fiscal-footer">
          <p>Conserta Tech - ${new Date().getFullYear()}</p>
          <p>Obrigado pela preferência!</p>
        </div>
      </div>
    `;
    
    document.body.appendChild(printDiv);
    window.print();
    
    setTimeout(() => {
      printDiv.remove();
    }, 1000);
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