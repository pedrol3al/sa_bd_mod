// Função para expandir e recolher submenus com persistência
function toggleSubMenu(buttonId, subMenuId) {
  const button = document.getElementById(buttonId);
  const subMenu = document.getElementById(subMenuId);

  // Verifica se o submenu está no localStorage e o deixa aberto, se necessário
  if (localStorage.getItem(subMenuId) === "open") {
    subMenu.classList.add('active');
  }

  button.addEventListener('click', (event) => {
    event.preventDefault();
    subMenu.classList.toggle('active');

    // Se o submenu estiver aberto, salva no localStorage
    if (subMenu.classList.contains('active')) {
      localStorage.setItem(subMenuId, "open");
    } else {
      localStorage.setItem(subMenuId, "closed");
    }
  });
}

// Chamadas para os submenus
toggleSubMenu('estoque', 'sub-estoque');
toggleSubMenu('orcamento', 'sub-orcamento');


document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".item-menu a");
  
  // Restaurar o estado salvo no localStorage
  const ativoIndex = localStorage.getItem("ativoIndex");
  if (ativoIndex !== null) {
      menuItems[ativoIndex].classList.add("ativo");
  }

  // Adicionar evento de clique para salvar o item clicado
  menuItems.forEach((item, index) => {
      item.addEventListener("click", function () {
          // Remover a classe 'ativo' de todos os itens
          menuItems.forEach((menuItem) => {
              menuItem.classList.remove("ativo");
          });
          
          // Adicionar a classe 'ativo' ao item clicado
          item.classList.add("ativo");

          // Salvar o índice do item no localStorage para persistência
          localStorage.setItem("ativoIndex", index);
      });
  });
});
