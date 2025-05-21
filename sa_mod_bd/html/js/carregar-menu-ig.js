console.log("carregarMenuLateral foi chamado");

async function carregarMenuLateral() {
  try {
    const menuHtml = ` <nav class="menu-lateral">
  <div class="btn-expandir"></div>

  <div class="top-menu">
    <ul>
      <li class="item-menu">
        <a href="main.html" class="menu-link">
          <span class="icon"><i class="bi bi-house-door"></i></span>
          <span class="txt-link">Home</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="agenda.html" class="menu-link">
          <span class="icon"><i class="bi bi-calendar"></i></span>
          <span class="txt-link">Schedule</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="cliente.html" class="menu-link">
          <span class="icon"><i class="bi bi-person-fill"></i></span>
          <span class="txt-link">Register Client</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="usuario.html" class="menu-link">
          <span class="icon"><i class="bi bi-person-circle"></i></span>
          <span class="txt-link">Register User</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="fornecedor.html" class="menu-link">
          <span class="icon"><i class="bi bi-truck"></i></span>
          <span class="txt-link">Register Supplier</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="estoque_cad.html" class="menu-link">
          <span class="icon"><i class="bi bi-box-seam"></i></span>
          <span class="txt-link">Inventory</span>
        </a>
      </li>
      <li class="item-menu">
        <a href="#" id="orcamento" class="menu-link">
          <span class="icon"><i class="bi bi-receipt-cutoff"></i></span>
          <span class="txt-link">Budget <i class="bi bi-chevron-down"></i></span>
        </a>
        <div id="sub-orcamento" class="sub-menu" style="display: none;">
          <a href="financas.html"><i class="bi bi-circle-fill"></i> Finances</a>
          <a href="emitir_nf.html"><i class="bi bi-circle-fill"></i> Issue Invoice</a>
        </div>
      </li>
      <li class="item-menu">
        <a href="os.html" class="menu-link">
          <span class="icon"><i class="bi bi-tools"></i></span>
          <span class="txt-link">Work Orders</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- Footer -->
  <div class="footer-contato">
    <div class="linha-info">
      <p class="duvidas">Questions?<br><span>Contact us</span></p>
      <p class="telefone">3025-5458</p>
    </div>
    <p class="empresa">Conserta Tech</p>
  </div>
</nav>

    `;
     

    const menuContainer = document.getElementById('menu-container');
    console.log('menuContainer:', menuContainer);

    if (menuContainer) {
      console.log('Inserindo menu no container...');
      menuContainer.innerHTML = menuHtml;

      // Busca dentro do menuContainer
      const orcamentoLink = menuContainer.querySelector('#orcamento');
      const subOrcamento = menuContainer.querySelector('#sub-orcamento');

      console.log('orcamentoLink:', orcamentoLink);
      console.log('subOrcamento:', subOrcamento);

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

window.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".fechar")?.addEventListener("click", () => {
    window.location.href = "https://www.google.com"; // Redireciona para o Google
  });

  document.querySelector(".sair")?.addEventListener("click", () => {
    window.location.href = "login-estilo.html"
  });
});

window.addEventListener('DOMContentLoaded', carregarMenuLateral);
