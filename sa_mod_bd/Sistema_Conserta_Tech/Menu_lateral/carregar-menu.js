
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
                <a href="#" id="cliente" class="menu-link">
                  <span class="icon"><i class="bi bi-person-fill"></i></span>
                  <span class="txt-link">Cliente <i class="bi bi-chevron-down"></i></span>
                </a>
                <div id="sub-cliente" class="sub-menu" style="display: none;">
                  <a href="../Cliente/cliente.php"><i class="bi bi-circle-fill"></i>Cadastrar Cliente</a>
                  <a href="../Cliente/buscar_cliente.php"><i class="bi bi-circle-fill"></i>Pesquisar Cliente</a>
                  <a href="../Cliente/alterar_cliente.php"><i class="bi bi-circle-fill"></i> Alterar Cliente</a>
                  <a href="../Cliente/excluir_cliente.php"><i class="bi bi-circle-fill"></i> Excluir Cliente</a>
                </div>
              </li>
             <li class="item-menu">
                <a href="#" id="usuario" class="menu-link">
                  <span class="icon"><i class="bi bi-person-circle"></i></span>
                  <span class="txt-link">Usuário <i class="bi bi-chevron-down"></i></span>
                </a>
                <div id="sub-usuario" class="sub-menu" style="display: none;">
                  <a href="../Usuario/usuario.php"><i class="bi bi-circle-fill"></i>Cadastrar Usuário</a>
                  <a href="../Usuario/buscar_usuario.php"><i class="bi bi-circle-fill"></i>Pesquisar Usuário</a>
                  <a href="../Usuario/alterar_usuario.php"><i class="bi bi-circle-fill"></i> Alterar Usuário</a>
                  <a href="../Usuario/excluir_usuario.php"><i class="bi bi-circle-fill"></i> Excluir Usuário</a>
                </div>
              </li>
              <li class="item-menu">
                <a href="#" id="fornecedor" class="menu-link">
                  <span class="icon"><i class="bi bi-truck"></i></span>
                  <span class="txt-link">Fornecedor <i class="bi bi-chevron-down"></i></span>
                </a>
                <div id="sub-fornecedor" class="sub-menu" style="display: none;">
                  <a href="../Fornecedor/cadastro_fornecedor.php"><i class="bi bi-circle-fill"></i>Cadastrar Fornecedor</a>
                  <a href="../Fornecedor/buscar_fornecedor.php"><i class="bi bi-circle-fill"></i>Pesquisar fornecedor</a>
                  <a href="../Fornecedor/alterar_usuario.php"><i class="bi bi-circle-fill"></i> Alterar fornecedor</a>
                  <a href="../Fornecedor/excluir_usuario.php"><i class="bi bi-circle-fill"></i> Excluir fornecedor</a>
                </div>
              </li>
               <li class="item-menu">
                <a href="#" id="estoque" class="menu-link">
                  <span class="icon"><i class="bi bi-person-fill"></i></span>
                  <span class="txt-link">Estoque <i class="bi bi-chevron-down"></i></span>
             </a>
              <div id="sub-estoque" class="sub-menu" style="display: none;">
              <a href="../Estoque/cadastrar_estoque.php"><i class="bi bi-circle-fill"></i> Cadastrar Estoque</a>
              <a href="../Estoque/buscar_estoque.php"><i class="bi bi-circle-fill"></i> Pesquisar Peças</a>
              <a href="../Estoque/alterar_estoque.php"><i class="bi bi-circle-fill"></i> Alterar Estoque</a>
              <a href="../Estoque/excluir_estoque.php"><i class="bi bi-circle-fill"></i> Excluir Estoque</a>
              </div>
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

  //Criando if para tratar a variavél como html
  if (menuContainer) {
    menuContainer.innerHTML = menuHtml;

    //Comando para que ao clicar na imagem do menu, ele fique fixo em todas as paginas, mesmo após trocar de pagina com ele aberto
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

    // Submenu usuário
    const usuarioLink = menuContainer.querySelector('#usuario');
    const subUsuario = menuContainer.querySelector('#sub-usuario');

    if (usuarioLink && subUsuario) {
      usuarioLink.addEventListener('click', (e) => {
        e.preventDefault();
        subUsuario.style.display = subUsuario.style.display === 'none' ? 'block' : 'none';
      });
    }

        // Submenu fornecedor
        const fornecedorLink = menuContainer.querySelector('#fornecedor');
        const subfornecedor = menuContainer.querySelector('#sub-fornecedor');
    
        if (fornecedorLink && subfornecedor) {
          fornecedorLink.addEventListener('click', (e) => {
            e.preventDefault();
            subfornecedor.style.display = subfornecedor.style.display === 'none' ? 'block' : 'none';
          });
        }

    // Submenu Cliente
    const clienteLink = menuContainer.querySelector('#cliente');
    const subCliente = menuContainer.querySelector('#sub-cliente');

    if (clienteLink && subCliente) {
      clienteLink.addEventListener('click', (e) => {
        e.preventDefault();
        subCliente.style.display = subCliente.style.display === 'none' ? 'block' : 'none';
      });
    }

    // Submenu Estoque
    const estoqueLink = menuContainer.querySelector('#estoque');
    const subEstoque = menuContainer.querySelector('#sub-estoque');

    if (estoqueLink && subEstoque) {
      estoqueLink.addEventListener('click', (e) => {
        e.preventDefault();
        subEstoque.style.display = subEstoque.style.display === 'none' ? 'block' : 'none';
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

