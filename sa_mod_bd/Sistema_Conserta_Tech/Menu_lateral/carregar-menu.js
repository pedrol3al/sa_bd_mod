
function carregarMenuLateral() {

  // Definição do HTML do menu lateral usando template string
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
            <button class="fixar-menu" id="fixar_menu" >
               <img src="../img/techinho.png" alt="" >
            </button>   
              <li class="item-menu">
                <a href="../Principal/main.php" class="menu-link">
                  <span class="icon"><i class="bi bi-house-door"></i></span>
                  <span class="txt-link">Menu</span>
                </a>
              </li>
              <li class="item-menu">
                <a href="../Agenda/agenda.php" class="menu-link">
                  <span class="icon"><i class="bi bi-calendar"></i></span>
                  <span class="txt-link">Agenda</span>
                </a>
              </li>
              <li class="item-menu">
                <a href="#" id="orcamento" class="menu-link">
                  <span class="icon"><i class="bi bi-person-fill"></i></span>
                  <span class="txt-link">Cliente <i class="bi bi-chevron-down"></i></span>
                </a>
                <div id="sub-orcamento" class="sub-menu" style="display: none;">
                  <a href="../Cliente/cliente.php"><i class="bi bi-circle-fill"></i>Cadastrar Cliente</a>
                  <a href="../Cliente/buscar_cliente.php"><i class="bi bi-circle-fill"></i>Pesquisar Cliente</a>
                  <a href="../Cliente/cadastrar_cliente.php"><i class="bi bi-circle-fill"></i> Alterar Cliente</a>
                  <a href="../Cliente/cadastrar_cliente.php"><i class="bi bi-circle-fill"></i> Excluir Cliente</a>
                </div>
              </li>
              <li class="item-menu">
                <a href="../Usuario/usuario.php" class="menu-link">
                  <span class="icon"><i class="bi bi-person-circle"></i></span>
                  <span class="txt-link">Cadastro Usuário</span>
                </a>
              </li>
              <li class="item-menu"> 
                <a href="../Fornecedor/fornecedor.php" class="menu-link">
                  <span class="icon"><i class="bi bi-truck"></i></span>
                  <span class="txt-link">Cadastro Fornecedor</span>
                </a>
              </li>
              <li class="item-menu">
                <a href="../Estoque/estoque_cad.php" class="menu-link">
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
                  <a href="../Financas/financas.php"><i class="bi bi-circle-fill"></i> Finanças</a>
                  <a href="../Nota_Fiscal/emitir_nf.php"><i class="bi bi-circle-fill"></i> Emitir NF</a>
                </div>
              </li>
              <li class="item-menu">
                <a href="../Ordem_servico/os.php" class="menu-link">
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
              <p class="telefone">(47) 98472-8108</p>
            </div>
            <p class="empresa">Conserta tech</p>
          </div> 
        </nav>
      `;

  const menuContainer = document.getElementById('menu-container'); //Inserindo o menu dentro de uma constante

  if (menuContainer) {
    menuContainer.innerHTML = menuHtml;

    const menu = menuContainer.querySelector('.menu-lateral');
    const botaoFixar = menuContainer.querySelector('#fixar_menu');

    botaoFixar.addEventListener('click', (e) => {
      e.preventDefault();
      menu.classList.toggle('fixo');
      localStorage.setItem('menuFixo', menu.classList.contains('fixo') ? 'true' : 'false');
    });

    const menuFixoSalvo = localStorage.getItem('menuFixo');
    if (menuFixoSalvo === 'true') {
      menu.classList.add('fixo');
    }

    // Submenu Orçamento
    const orcamentoLink = menuContainer.querySelector('#orcamento');
    const subOrcamento = menuContainer.querySelector('#sub-orcamento');

    if (orcamentoLink && subOrcamento) {
      orcamentoLink.addEventListener('click', (e) => {
        e.preventDefault();
        subOrcamento.style.display = subOrcamento.style.display === 'none' ? 'block' : 'none';
      });
    }

    const botaoSair = menuContainer.querySelector(".sair");

    if (botaoSair) {
      botaoSair.addEventListener("click", () => {
        window.location.href = "../Login/index.php";
      });
    }
  }
}

// Espera o DOM estar carregado e então chama a função
window.addEventListener("DOMContentLoaded", () => {
  carregarMenuLateral();
});

