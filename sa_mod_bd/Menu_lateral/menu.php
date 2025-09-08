<?php
// menu.php - Menu lateral reutilizável
?>

<div id="menu-container">
  <div class="btn-expandir"></div>
  <button class="sair" title="sair da conta"> 
    <img src="../img/logout.png" alt="Sair">
  </button>

  <nav class="menu-lateral">
    <div class="top-menu">
      <ul>
        <button class="fixar-menu" id="fixar_menu">
          <img src="../img/techinho.png" alt="">
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
            <div class="txt-link-container">
              <span class="txt-link">Cliente</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-cliente" class="sub-menu" style="display: none;">
            <a href="../Cliente/cliente.php"><i class="bi bi-circle-fill"></i><span>Cadastrar Cliente</span></a>
            <a href="../Cliente/buscar_cliente.php"><i class="bi bi-circle-fill"></i><span>Pesquisar Cliente</span></a>
          </div>
        </li>

        <li class="item-menu">
          <a href="#" id="usuario" class="menu-link">
            <span class="icon"><i class="bi bi-person-circle"></i></span>
            <div class="txt-link-container">
              <span class="txt-link">Usuário</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-usuario" class="sub-menu" style="display: none;">
            <a href="../Usuario/usuario.php"><i class="bi bi-circle-fill"></i><span>Cadastrar Usuário</span></a>
            <a href="../Usuario/buscar_usuario.php"><i class="bi bi-circle-fill"></i><span>Pesquisar Usuário</span></a>
          </div>
        </li>

        <li class="item-menu">
          <a href="#" id="fornecedor" class="menu-link">
            <span class="icon"><i class="bi bi-truck"></i></span>
            <div class="txt-link-container">
              <span class="txt-link">Fornecedor</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-fornecedor" class="sub-menu" style="display: none;">
            <a href="../Fornecedor/fornecedor.php"><i class="bi bi-circle-fill"></i><span>Cadastrar Fornecedor</span></a>
            <a href="../Fornecedor/buscar_fornecedor.php"><i class="bi bi-circle-fill"></i><span>Pesquisar Fornecedor</span></a>
          </div>
        </li>

        <li class="item-menu">
          <a href="#" id="estoque" class="menu-link">
            <span class="icon"><i class="bi bi-archive"></i></span>
            <div class="txt-link-container">
              <span class="txt-link">Estoque</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-estoque" class="sub-menu" style="display: none;">
            <a href="../Estoque/cadastro_produto.php"><i class="bi bi-circle-fill"></i> Cadastrar Produtos</a>
            <a href="../Estoque/buscar_produto.php"><i class="bi bi-circle-fill"></i> Pesquisar Produtos</a>
          </div>
        </li>

        <li class="item-menu">
          <a href="#" id="orcamento" class="menu-link">
            <span class="icon"><i class="bi bi-receipt-cutoff"></i></span>
            <div class="txt-link-container">
              <span class="txt-link">Orçamento</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-orcamento" class="sub-menu" style="display: none;">
            <a href="../Financas/dashboard.php"><i class="bi bi-circle-fill"></i><span>Finanças</span></a>
            <a href="../Financas/pagamento_os.php"><i class="bi bi-circle-fill"></i><span>Pagamentos</span></a>
          </div>
        </li>

        <li class="item-menu">
          <a href="#" id="os" class="menu-link">
            <span class="icon"><i class="bi bi-clipboard"></i></span>
            <div class="txt-link-container">
              <span class="txt-link">O.S.</span>
              <i class="bi bi-chevron-down"></i>
            </div>
          </a>
          <div id="sub-os" class="sub-menu" style="display: none;">
            <a href="../Ordem_servico/os.php"><i class="bi bi-circle-fill"></i><span>Cadastrar O.S.</span></a>
            <a href="../Ordem_servico/buscar_os.php"><i class="bi bi-circle-fill"></i><span>Pesquisar O.S.</span></a>
          </div>
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
</div>

<link rel="stylesheet" href="css-home-bar.css">

<script>
// Função de interação do menu
document.addEventListener("DOMContentLoaded", () => {
  const menuContainer = document.getElementById('menu-container');
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

  // Função para abrir/fechar submenus
  const toggleSubmenu = (linkId, submenuId) => {
    const link = menuContainer.querySelector(linkId);
    const submenu = menuContainer.querySelector(submenuId);

    if (link && submenu) {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Fecha outros submenus abertos
        document.querySelectorAll('.sub-menu').forEach(otherSubmenu => {
          if (otherSubmenu.id !== submenuId) {
            otherSubmenu.style.display = 'none';
            otherSubmenu.previousElementSibling.classList.remove('active');
          }
        });
        
        // Alterna o submenu atual
        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
        
        // Adiciona/remove classe ativa
        if (submenu.style.display === 'block') {
          link.closest('.item-menu').classList.add('active');
        } else {
          link.closest('.item-menu').classList.remove('active');
        }
      });
    }
  };

  toggleSubmenu('#cliente', '#sub-cliente');
  toggleSubmenu('#usuario', '#sub-usuario');
  toggleSubmenu('#fornecedor', '#sub-fornecedor');
  toggleSubmenu('#estoque', '#sub-estoque');
  toggleSubmenu('#orcamento', '#sub-orcamento');
  toggleSubmenu('#os', '#sub-os');

  // Fecha submenus ao clicar fora
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.item-menu')) {
      document.querySelectorAll('.sub-menu').forEach(submenu => {
        submenu.style.display = 'none';
      });
      document.querySelectorAll('.item-menu').forEach(item => {
        item.classList.remove('active');
      });
    }
  });

  // Botão de sair
  const botaoSair = menuContainer.querySelector(".sair");
  if (botaoSair) {
    botaoSair.addEventListener("click", () => {
      window.location.href = "../index.php";
    });
  }
});
</script>