function carregarMenuLateral() {
  const menuHtml = `
    <div class="btn-expandir"></div>
    <button class="sair" title="sair da conta"> 
      <img src="../img/logout.png" alt="Sair">
    </button>

    <button class="fechar" title="fechar">
      <img src="../img/person-circle.svg" alt="Fechar">
    </button>

    <nav class="menu-lateral">
      <div class="top-menu">
        <ul>
          <button class="fixar-menu" id="fixar_menu">
            <img src="../img/logo.png" alt="">
          </button>

          <!-- Links diretos -->
          <li class="item-menu">
            <a href="../Principal/main.html" class="menu-link">
              <span class="icon"><i class="bi bi-house-door"></i></span>
              <span class="txt-link">Menu</span>
            </a>
          </li>
          <li class="item-menu">
            <a href="../Agenda/agenda.html" class="menu-link">
              <span class="icon"><i class="bi bi-calendar"></i></span>
              <span class="txt-link">Agenda</span>
            </a>
          </li>

          <!-- Cliente (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-person-fill"></i></span>
              <span class="txt-link">Cliente <i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Cliente/cadastrar_cliente.html"><i class="bi bi-circle-fill"></i> Cadastrar Cliente</a>
              <a href="../Cliente/financas.html"><i class="bi bi-circle-fill"></i> Pesquisar Cliente</a>
              <a href="../Cliente/cadastrar_cliente.html"><i class="bi bi-circle-fill"></i> Alterar Cliente</a>
              <a href="../Cliente/cadastrar_cliente.html"><i class="bi bi-circle-fill"></i> Excluir Cliente</a>
            </div>
          </li>

          <!-- Usuário (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-person-circle"></i></span>
              <span class="txt-link">Usuário <i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Usuario/usuario.html"><i class="bi bi-circle-fill"></i> Cadastrar Usuário</a>
              <a href="../Usuario/usuario.html"><i class="bi bi-circle-fill"></i> Pesquisar Usuário</a>
              <a href="../Usuario/usuario.html"><i class="bi bi-circle-fill"></i> Alterar Usuário</a>
              <a href="../Usuario/usuario.html"><i class="bi bi-circle-fill"></i> Excluir Usuário</a>
            </div>
          </li>

          <!-- Fornecedor (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-truck"></i></span>
              <span class="txt-link">Fornecedor<i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Fornecedor/fornecedor.html"><i class="bi bi-circle-fill"></i> Cadastrar Fornecedor</a>
              <a href="../Fornecedor/fornecedor.html"><i class="bi bi-circle-fill"></i> Pesquisar Fornecedor</a>
              <a href="../Fornecedor/fornecedor.html"><i class="bi bi-circle-fill"></i> Alterar Fornecedor</a>
              <a href="../Fornecedor/fornecedor.html"><i class="bi bi-circle-fill"></i> Excluir Fornecedor</a>
            </div>
          </li>

          <!-- Estoque (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-box-seam"></i></span>
              <span class="txt-link">Estoque <i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Estoque/estoque_cad.html"><i class="bi bi-circle-fill"></i> Cadastrar Estoque</a>
              <a href="../Estoque/estoque_cad.html"><i class="bi bi-circle-fill"></i> Pesquisar Estoque</a>
              <a href="../Estoque/estoque_cad.html"><i class="bi bi-circle-fill"></i> Alterar Estoque</a>
              <a href="../Estoque/estoque_cad.html"><i class="bi bi-circle-fill"></i> Excluir Estoque</a>
            </div>
          </li>

          <!-- Orçamento (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-receipt-cutoff"></i></span>
              <span class="txt-link">Orçamento <i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Financas/financas.html"><i class="bi bi-circle-fill"></i> Finanças</a>
              <a href="../Nota_Fiscal/emitir_nf.html"><i class="bi bi-circle-fill"></i> Nota fiscal</a>
            </div>
          </li>

          <!-- O.S (submenu) -->
          <li class="item-menu">
            <a href="#" class="menu-link submenu-toggle">
              <span class="icon"><i class="bi bi-tools"></i></span>
              <span class="txt-link">O.S <i class="bi bi-chevron-down"></i></span>
            </a>
            <div class="sub-menu" style="display:none;">
              <a href="../Ordem_servico/os.html"><i class="bi bi-circle-fill"></i> Cadastrar</a>
              <a href="../Ordem_servico/os.html"><i class="bi bi-circle-fill"></i> Pesquisar</a>
              <a href="../Ordem_servico/os.html"><i class="bi bi-circle-fill"></i> Alterar</a>
              <a href="../Ordem_servico/os.html"><i class="bi bi-circle-fill"></i> Excluir</a>
            </div>
          </li>
        </ul>
      </div>

      <div class="footer-contato">
        <div class="linha-info">
          <p class="duvidas">Dúvidas?<br><span>Consulte-nos</span></p>
          <p class="telefone">(47) 98472-8108</p>
        </div>
        <p class="empresa">Conserta tech</p>
      </div>
    </nav>
  `;

  const menuContainer = document.getElementById('menu-container');

  if (menuContainer) {
    menuContainer.innerHTML = menuHtml;

    const menu = menuContainer.querySelector('.menu-lateral');
    const botaoFixar = menuContainer.querySelector('#fixar_menu');

    // Fixar menu
    botaoFixar.addEventListener('click', (e) => {
      e.preventDefault();
      menu.classList.toggle('fixo');
      localStorage.setItem('menuFixo', menu.classList.contains('fixo') ? 'true' : 'false');
    });

    // Recupera fixo
    const menuFixoSalvo = localStorage.getItem('menuFixo');
    if (menuFixoSalvo === 'true') menu.classList.add('fixo');

    // Toggle genérico para todos os submenus (abre para baixo)
    const toggles = menuContainer.querySelectorAll('.submenu-toggle');
    toggles.forEach((toggle) => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const sub = toggle.nextElementSibling;
        if (!sub) return;
        sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
      });
    });

    // Sair
    const botaoSair = menuContainer.querySelector('.sair');
    if (botaoSair) {
      botaoSair.addEventListener('click', () => {
        window.location.href = '../Login/login.html';
      });
    }

    // (Opcional) fechar janela:
    // const botaoFechar = menuContainer.querySelector('.fechar');
    // if (botaoFechar) botaoFechar.addEventListener('click', () => window.close());
  }
}

window.addEventListener('DOMContentLoaded', carregarMenuLateral);
