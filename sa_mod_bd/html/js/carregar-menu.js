
 function carregarMenuLateral() {
  try {
    // Definição do HTML do menu lateral usando template string
    const menuHtml = `
      <nav class="menu-lateral">
        <div class="btn-expandir"></div>

        <div class="top-menu">
          <ul>
            <li class="item-menu">
                <a href="#" class="menu-link" id="fixar_menu">
                    <span class="icon"><i class="bi bi-list"></i></span>
                    <span class="txt-link">Fixar Menu</span>
                </a>
            </li>
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

      // Pega o menu e o botão fixar
      const menu = menuContainer.querySelector('.menu-lateral');
      const botaoFixar = menuContainer.querySelector('#fixar_menu');


botaoFixar.addEventListener('click', (e) => {
  e.preventDefault();
  menu.classList.toggle('fixo');

  // Salva no localStorage se o menu está fixo ou não
  if (menu.classList.contains('fixo')) {
    localStorage.setItem('menuFixo', 'true');
  } else {
    localStorage.setItem('menuFixo', 'false');
  }
});

// Na hora de carregar o menu (ou depois de inserir o menu no DOM):

const menuFixoSalvo = localStorage.getItem('menuFixo');

if (menuFixoSalvo === 'true') {
  menu.classList.add('fixo');
} else {
  menu.classList.remove('fixo');
}


      // Busca o link do orçamento e seu submenu
      const orcamentoLink = menuContainer.querySelector('#orcamento');
      const subOrcamento = menuContainer.querySelector('#sub-orcamento');

      if (orcamentoLink && subOrcamento) {
        orcamentoLink.addEventListener('click', (e) => {
          e.preventDefault();
          subOrcamento.style.display = subOrcamento.style.display === 'none' ? 'block' : 'none';
        });
      } else {
        console.error('Elemento orcamentoLink ou subOrcamento não encontrado!');
      }
    } else {
      console.error('menuContainer não encontrado no DOM!');
    }
  } catch (error) {
    console.error('Erro ao carregar menu lateral:', error);
  }
}

// Quando o DOM estiver completamente carregado
window.addEventListener("DOMContentLoaded", () => {
  // Redirecionamentos para botão sair/fechar
  document.querySelector(".fechar")?.addEventListener("click", () => {
    window.location.href = "https://www.google.com";
  });

  document.querySelector(".sair")?.addEventListener("click", () => {
    window.location.href = "login-estilo.html";
  });

  // Carrega o menu lateral
  carregarMenuLateral();
});
