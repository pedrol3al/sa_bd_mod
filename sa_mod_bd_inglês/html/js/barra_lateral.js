// Função para expandir e recolher submenus com persistência
function toggleSubMenu(buttonId, subMenuId) {
  const button = document.getElementById(buttonId);
  const subMenu = document.getElementById(subMenuId);

  // Se o submenu não existir, não faz nada (evita problemas)
  if (!button || !subMenu) return;

  if (localStorage.getItem(subMenuId) === "open") {
    subMenu.classList.add('active');
  }

  button.addEventListener('click', (event) => {
    event.preventDefault();
    subMenu.classList.toggle('active');

    if (subMenu.classList.contains('active')) {
      localStorage.setItem(subMenuId, "open");
    } else {
      localStorage.setItem(subMenuId, "closed");
    }
  });
}

// Chamada apenas para submenu existente
toggleSubMenu('orcamento', 'sub-orcamento');

document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".item-menu a");

  // Restaurar o estado salvo no localStorage
  const ativoHref = localStorage.getItem("ativoHref");
  if (ativoHref) {
    menuItems.forEach((item) => {
      if (item.getAttribute("href") === ativoHref) {
        item.classList.add("ativo");
      } else {
        item.classList.remove("ativo");
      }
    });
  }

  menuItems.forEach((item, index) => {
  item.addEventListener("click", function () {
    menuItems.forEach((menuItem) => {
      menuItem.classList.remove("ativo");
    });
    item.classList.add("ativo");
    localStorage.setItem("ativoIndex", index);
  });
});
});

// Aguardar o carregamento completo do DOM
document.addEventListener("DOMContentLoaded", function() {
    // Seleciona todos os itens de menu
    const menuItems = document.querySelectorAll('.item-menu');

    // Iterar sobre os itens e adicionar o evento de clique
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remover a classe 'ativo' de todos os itens
            menuItems.forEach(i => i.classList.remove('ativo'));

            // Adicionar a classe 'ativo' no item clicado
            item.classList.add('ativo');
        });
    });
});
