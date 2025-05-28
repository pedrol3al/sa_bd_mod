document.addEventListener("DOMContentLoaded", function () {
  const cadastrarBtn = document.querySelector(".cadastrar");
  const novoBtn = document.querySelector(".novo");
  let editandoItem = null;

  function toggleModoEdicao(editando, item = null) {
    editandoItem = item;

    if (editando) {
      cadastrarBtn.textContent = "Salvar alterações";
      if (novoBtn) novoBtn.textContent = "Cancelar edição";
    } else {
      cadastrarBtn.textContent = "Salvar";
      if (novoBtn) novoBtn.textContent = "Novo";
      document.querySelector(".formulario").reset();
      editandoItem = null;
    }
  }

  cadastrarBtn.addEventListener("click", function (e) {
    e.preventDefault();

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
      if (campo.value.trim() === "") {
        Swal.fire({
          icon: 'warning',
          title: 'Campo obrigatório',
          text: `Preencha o campo: ${campo.previousElementSibling.innerText}`
        });
        campo.focus();
        return;
      }
    }

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

  // Função chamada por outro script para editar um item
  window.editarItem = function (item) {
    document.getElementById("id_pecas").value = item.id_pecas;
    document.getElementById("id_fornecedor").value = item.id_fornecedor;
    document.getElementById("nome").value = item.nome;
    document.getElementById("aparelho_utilizado").value = item.aparelho_utilizado;
    document.getElementById("quantidade").value = item.quantidade;
    document.getElementById("preco").value = item.preco;
    document.getElementById("data_registro").value = item.data_registro;
    document.getElementById("status").value = item.status;
    document.getElementById("tipo").value = item.tipo;
    document.getElementById("numero_serie").value = item.numero_serie;
    document.getElementById("descricao").value = item.descricao;

    toggleModoEdicao(true, item);
  };
});



//============================= Pesquisar peças=================================================//
document.addEventListener("DOMContentLoaded", function () {
    // Instância da fábrica de modais
    const modalFactory = new ModalFactory();

    // Criação do modal de pesquisa de peças
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

    // Elementos do modal
    const inputPesquisa = document.getElementById('input-pesquisa');
    const resultado = document.getElementById('resultado-pesquisa');

    // Funções para aplicar/remover blur (podem ser adaptadas para a fábrica se necessário)
    function aplicarBlur() {
        const menu = document.getElementById("menu-container");
        const conteudo = document.querySelector(".conteudo");
        if (menu) menu.style.filter = "blur(5px)";
        if (conteudo) {
            conteudo.style.filter = "blur(5px)";
            conteudo.style.pointerEvents = "none";
            conteudo.style.userSelect = "none";
        }
    }

    function removerBlur() {
        const menu = document.getElementById("menu-container");
        const conteudo = document.querySelector(".conteudo");
        if (menu) menu.style.filter = "";
        if (conteudo) {
            conteudo.style.filter = "";
            conteudo.style.pointerEvents = "";
            conteudo.style.userSelect = "";
        }
    }

    // Evento do botão pesquisar
    const btnPesquisar = document.querySelector(".pesquisar");
    btnPesquisar.addEventListener("click", function (e) {
        e.preventDefault();
        pesquisaModal.show();
        aplicarBlur();
        inputPesquisa.value = "";
        resultado.innerHTML = "<p>Digite um termo para buscar.</p>";
        inputPesquisa.focus();
    });

    // Evento de input para pesquisa
    inputPesquisa.addEventListener("input", function () {
        const termo = inputPesquisa.value.trim().toLowerCase();
        let estoque = JSON.parse(localStorage.getItem("estoque")) || [];

        if (termo === "") {
            resultado.innerHTML = "<p>Digite um termo para buscar.</p>";
            return;
        }

        const resultados = estoque.filter(item =>
            item.nome.toLowerCase().includes(termo) ||
            item.id_pecas.toLowerCase().includes(termo)
        );

        if (resultados.length === 0) {
            resultado.innerHTML = "<p>Nenhum resultado encontrado.</p>";
            return;
        }

        resultado.innerHTML = "";

       // Substitua a parte onde os resultados são exibidos (dentro do forEach) por este código:
resultados.forEach(item => {
    const div = document.createElement("div");
    div.style.cssText = `
        padding: 8px; border-bottom: 1px solid #ccc; cursor: pointer;
        transition: background-color 0.2s; margin-bottom: 10px;
    `;

    div.innerHTML = `
        <strong>ID:</strong> ${item.id_pecas} <br>
        <strong>Nome:</strong> ${item.nome} <br>
        <strong>Quantidade:</strong> ${item.quantidade}
        <div class="btn-group" style="margin-top: 8px; display: flex; gap: 5px;">
            <button class="btn-visualizar" style="padding: 4px 8px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">Visualizar</button>
            <button class="btn-editar" style="padding: 4px 8px; background: #FFC107; color: black; border: none; border-radius: 4px; cursor: pointer;">Editar</button>
            <button class="btn-excluir" style="padding: 4px 8px; background: #F44336; color: white; border: none; border-radius: 4px; cursor: pointer;">Excluir</button>
        </div>
    `;

    div.addEventListener("mouseenter", () => {
        div.style.backgroundColor = "#f5f5f5";
    });

    div.addEventListener("mouseleave", () => {
        div.style.backgroundColor = "";
    });

    // Adiciona os eventos para os botões
    const btnVisualizar = div.querySelector(".btn-visualizar");
    const btnEditar = div.querySelector(".btn-editar");
    const btnExcluir = div.querySelector(".btn-excluir");

    // Impede a propagação do clique para a div pai
    [btnVisualizar, btnEditar, btnExcluir].forEach(btn => {
        btn.addEventListener("click", (e) => e.stopPropagation());
    });

    btnVisualizar.addEventListener("click", () => {
        visualizarDetalhes(item);
    });

    btnEditar.addEventListener("click", () => {
        editarItem(item);
    });

    btnExcluir.addEventListener("click", () => {
        excluirItem(item);
    });

    // Mantém o clique na div para preencher o formulário
    div.addEventListener("click", () => {
        preencherFormulario(item);
        pesquisaModal.close();
        removerBlur();
    });

    resultado.appendChild(div);
});

// Adicione estas funções após a função preencherFormulario:
function visualizarDetalhes(item) {
    const detalhesContent = `
        <h3>Detalhes da Peça</h3>
        <div style="margin-top: 15px;">
            <p><strong>ID:</strong> ${item.id_pecas}</p>
            <p><strong>Nome:</strong> ${item.nome}</p>
            <p><strong>Fornecedor:</strong> ${item.id_fornecedor}</p>
            <p><strong>Aparelho utilizado:</strong> ${item.aparelho_utilizado}</p>
            <p><strong>Quantidade:</strong> ${item.quantidade}</p>
            <p><strong>Preço:</strong> ${item.preco}</p>
            <p><strong>Data de registro:</strong> ${item.data_registro}</p>
            <p><strong>Status:</strong> ${item.status}</p>
            <p><strong>Tipo:</strong> ${item.tipo}</p>
            <p><strong>Número de série:</strong> ${item.numero_serie}</p>
            <p><strong>Descrição:</strong> ${item.descricao}</p>
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
    aplicarBlur();
}

function editarItem(item) {
    // Preenche o formulário e fecha o modal de pesquisa
    preencherFormulario(item);
    pesquisaModal.close();
    removerBlur();
    
    // Aqui você pode adicionar lógica adicional para o modo de edição
    console.log("Editando item:", item);
    // Exemplo: habilitar campos, mudar texto do botão submit, etc.
}

function excluirItem(item) {
    if (confirm(`Tem certeza que deseja excluir a peça "${item.nome}" (ID: ${item.id_pecas})?`)) {
        let estoque = JSON.parse(localStorage.getItem("estoque")) || [];
        estoque = estoque.filter(peca => peca.id_pecas !== item.id_pecas);
        localStorage.setItem("estoque", JSON.stringify(estoque));
        
        // Atualiza a lista de resultados
        const termo = inputPesquisa.value.trim().toLowerCase();
        inputPesquisa.dispatchEvent(new Event('input'));
        
        alert("Peça excluída com sucesso!");
    }
}
    });

    // Preenche o formulário com os dados da peça selecionada (mantido igual)
    function preencherFormulario(item) {
        document.getElementById("id_pecas").value = item.id_pecas;
        document.getElementById("id_fornecedor").value = item.id_fornecedor;
        document.getElementById("nome").value = item.nome;
        document.getElementById("aparelho_utilizado").value = item.aparelho_utilizado;
        document.getElementById("quantidade").value = item.quantidade;
        document.getElementById("preco").value = item.preco;
        document.getElementById("data_registro").value = item.data_registro;
        document.getElementById("status").value = item.status;
        document.getElementById("tipo").value = item.tipo;
        document.getElementById("numero_serie").value = item.numero_serie;
        document.getElementById("descricao").value = item.descricao;
    }
});

// Definição da classe ModalFactory (mantida igual)
class ModalFactory {
    constructor() {
        this.overlay = this.createOverlay();
        document.body.appendChild(this.overlay);
    }

    createOverlay() {
        const overlay = document.createElement("div");
        overlay.id = 'modal-overlay';
        overlay.style.display = 'none';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
        overlay.style.zIndex = '999';
        return overlay;
    }

    createModal(options = {}) {
        const {
            id = 'custom-modal',
            title = '',
            content = '',
            width = 'auto',
            height = 'auto',
            maxWidth = 'none'
        } = options;

        // Remove modal existente com o mesmo ID, se houver
        const existingModal = document.getElementById(id);
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement("div");
        modal.id = id;
        modal.className = 'custom-modal';
        modal.style.display = 'none';
        modal.style.position = 'fixed';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
        modal.style.backgroundColor = 'white';
        modal.style.padding = '20px';
        modal.style.borderRadius = '8px';
        modal.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
        modal.style.zIndex = '1000';
        modal.style.height = height;
        modal.style.width = width;
        modal.style.maxWidth = maxWidth;
        modal.style.overflow = 'auto';

        // Cabeçalho do modal
        const header = document.createElement("div");
        header.style.display = 'flex';
        header.style.justifyContent = 'space-between';
        header.style.alignItems = 'center';
        header.style.marginBottom = '20px';
        header.style.borderBottom = '1px solid #eee';
        header.style.paddingBottom = '10px';

        const titleElement = document.createElement("h2");
        titleElement.textContent = title;
        titleElement.style.margin = '0';

        const closeButton = document.createElement("button");
        closeButton.innerHTML = '&times;';
        closeButton.style.background = 'none';
        closeButton.style.border = 'none';
        closeButton.style.fontSize = '24px';
        closeButton.style.cursor = 'pointer';
        closeButton.style.color = 'black';

        

        header.appendChild(titleElement);
        header.appendChild(closeButton);
        modal.appendChild(header);

        // Corpo do modal
        const body = document.createElement("div");
        body.className = 'modal-body';
        body.innerHTML = content;
        modal.appendChild(body);

        document.body.appendChild(modal);

        // Configura comportamentos
        closeButton.addEventListener('click', () => this.closeModal(modal));
        this.overlay.addEventListener('click', () => this.closeModal(modal));

        return {
            element: modal,
            show: () => this.showModal(modal),
            close: () => this.closeModal(modal),
            updateContent: (newContent) => {
                body.innerHTML = newContent;
            }
        };
    }

    showModal(modal) {
        modal.style.display = 'block';
        this.overlay.style.display = 'block';
    }

    closeModal(modal) {
        modal.style.display = 'none';
        this.overlay.style.display = 'none';
    }
}