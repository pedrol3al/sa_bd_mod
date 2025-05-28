// Mensagem no console para indicar que a função carregarMenuLateral foi chamada
console.log("carregarMenuLateral foi chamado");

// Função assíncrona para carregar o menu lateral na página
async function carregarMenuLateral() {
  try {
    // Definição do HTML do menu lateral usando template string
    const menuHtml = `
      <nav class="menu-lateral">
        <div class="btn-expandir"></div>

        <div class="top-menu">
          <ul>
            <li class="item-menu">
              <a href="main.html" class="menu-link">
                <span class="icon"><i class="bi bi-house-door"></i></span>
                <span class="txt-link">Menu</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="agenda.html" class="menu-link">
                <span class="icon"><i class="bi bi-calendar"></i></span>
                <span class="txt-link">Agenda</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="cliente.html" class="menu-link">
                <span class="icon"><i class="bi bi-person-fill"></i></span>
                <span class="txt-link">Cadastrar Cliente</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="usuario.html" class="menu-link">
                <span class="icon"><i class="bi bi-person-circle"></i></span>
                <span class="txt-link">Cadastro Usuário</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="fornecedor.html" class="menu-link">
                <span class="icon"><i class="bi bi-truck"></i></span>
                <span class="txt-link">Cadastro Fornecedor</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="estoque_cad.html" class="menu-link">
                <span class="icon"><i class="bi bi-box-seam"></i></span>
                <span class="txt-link">Estoque</span>
              </a>
            </li>
            <li class="item-menu">
              <a href="#" id="orcamento" class="menu-link">
                <span class="icon"><i class="bi bi-receipt-cutoff"></i></span>
                <span class="txt-link">Orçamento <i class="bi bi-chevron-down"></i></span>
              </a>
              <div id="sub-orcamento" class="sub-menu" style="display: none;">
                <a href="financas.html"><i class="bi bi-circle-fill"></i> Finanças</a>
                <a href="emitir_nf.html"><i class="bi bi-circle-fill"></i> Emitir NF</a>
              </div>
            </li>
            <li class="item-menu">
              <a href="os.html" class="menu-link">
                <span class="icon"><i class="bi bi-tools"></i></span>
                <span class="txt-link">O.S</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Rodapé -->
        <div class="footer-contato">
          <div class="linha-info">
            <p class="duvidas">Dúvidas?<br><span>Consulte-nos</span></p>
            <p class="telefone">47 93025-5458</p>
          </div>
          <p class="empresa">Conserta tech</p>
        </div> 
      </nav>
    `;

    // Busca o elemento no DOM onde o menu será inserido, pelo ID 'menu-container'
    const menuContainer = document.getElementById('menu-container');
    console.log('menuContainer:', menuContainer);

    // Verifica se o container existe na página
    if (menuContainer) {
      console.log('Inserindo menu no container...');

      // Insere o HTML do menu dentro do container
      menuContainer.innerHTML = menuHtml;

      // Busca dentro do container o link do orçamento e seu submenu
      const orcamentoLink = menuContainer.querySelector('#orcamento');
      const subOrcamento = menuContainer.querySelector('#sub-orcamento');

      console.log('orcamentoLink:', orcamentoLink);
      console.log('subOrcamento:', subOrcamento);

      // Verifica se os elementos foram encontrados
      if (orcamentoLink && subOrcamento) {
        // Adiciona evento de clique para alternar a exibição do submenu de orçamento
        orcamentoLink.addEventListener('click', (e) => {
          e.preventDefault(); // Impede o comportamento padrão do link (navegar)
          // Se o submenu estiver oculto, mostra; se estiver visível, oculta
          subOrcamento.style.display = subOrcamento.style.display === 'none' ? 'block' : 'none';
        });
      } else {
        // Caso não encontre algum dos elementos, exibe erro no console
        console.error('Elemento orcamentoLink ou subOrcamento não encontrado!');
      }
    } else {
      // Caso o container do menu não exista, exibe erro no console
      console.error('menuContainer não encontrado no DOM!');
    }
  } catch (error) {
    // Caso algum erro aconteça dentro do try, ele será capturado e exibido aqui
    console.error('Erro ao carregar menu lateral:', error);
  }
}

// Quando o DOM estiver completamente carregado
window.addEventListener("DOMContentLoaded", () => {
  // Se existir um botão com classe 'fechar', adiciona evento para redirecionar ao Google
  document.querySelector(".fechar")?.addEventListener("click", () => {
    window.location.href = "https://www.google.com"; // Redireciona para o Google
  });

  // Se existir um botão com classe 'sair', adiciona evento para redirecionar para login
  document.querySelector(".sair")?.addEventListener("click", () => {
    window.location.href = "login-estilo.html";
  });
});

// Quando o DOM estiver carregado, chama a função para inserir o menu lateral
window.addEventListener('DOMContentLoaded', carregarMenuLateral);
