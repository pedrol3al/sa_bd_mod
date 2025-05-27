// Função para expandir e recolher submenus com persistência
function toggleSubMenu(buttonId, subMenuId) {
  const button = document.getElementById(buttonId);       // Obtém o botão que ativa o submenu
  const subMenu = document.getElementById(subMenuId);     // Obtém o submenu em si

  // Se o botão ou submenu não existirem, a função não continua
  if (!button || !subMenu) return;

  // Verifica no localStorage se o submenu deve estar aberto
  if (localStorage.getItem(subMenuId) === "open") {
    subMenu.classList.add('active'); // Se estiver salvo como "open", adiciona a classe para manter aberto
  }

  // Adiciona um evento de clique ao botão para alternar o submenu
  button.addEventListener('click', (event) => {
    event.preventDefault(); // Evita comportamento padrão do botão (ex: redirecionamento)

    // Alterna a classe 'active' (expande ou recolhe o submenu)
    subMenu.classList.toggle('active');

    // Salva no localStorage o estado do submenu (aberto ou fechado)
    if (subMenu.classList.contains('active')) {
      localStorage.setItem(subMenuId, "open");
    } else {
      localStorage.setItem(subMenuId, "closed");
    }
  });
}

// Chama a função de submenu apenas se ele existir (evita erro se o submenu não estiver no HTML)
toggleSubMenu('orcamento', 'sub-orcamento');


// Quando o DOM estiver completamente carregado
document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".item-menu a"); // Seleciona todos os links do menu lateral

  // Verifica no localStorage qual item foi clicado anteriormente
  const ativoHref = localStorage.getItem("ativoHref");
  if (ativoHref) {
    menuItems.forEach((item) => {
      // Se o link atual for o mesmo salvo, aplica a classe 'ativo'
      if (item.getAttribute("href") === ativoHref) {
        item.classList.add("ativo");
      } else {
        item.classList.remove("ativo"); // Remove 'ativo' dos outros
      }
    });
  }

  // Para cada item do menu, adiciona um evento de clique
  menuItems.forEach((item, index) => {
    item.addEventListener("click", function () {
      // Remove a classe 'ativo' de todos os links
      menuItems.forEach((menuItem) => {
        menuItem.classList.remove("ativo");
      });

      // Adiciona a classe 'ativo' apenas ao item clicado
      item.classList.add("ativo");

      // Salva no localStorage o índice do item ativo
      localStorage.setItem("ativoIndex", index);
    });
  });
});


// Segunda verificação quando o DOM estiver carregado (repetição da funcionalidade anterior)
document.addEventListener("DOMContentLoaded", function() {
  // Seleciona todos os itens de menu (elementos com a classe .item-menu)
  const menuItems = document.querySelectorAll('.item-menu');

  // Para cada item do menu, adiciona um evento de clique
  menuItems.forEach(item => {
    item.addEventListener('click', function() {
      // Remove a classe 'ativo' de todos os itens
      menuItems.forEach(i => i.classList.remove('ativo'));

      // Adiciona a classe 'ativo' ao item clicado
      item.classList.add('ativo');
    });
  });
});
