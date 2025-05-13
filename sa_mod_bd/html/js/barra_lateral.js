document.addEventListener('DOMContentLoaded', function() {
  // Seleciona todos os links principais que possuem submenus
  const menuItems = document.querySelectorAll('.item-menu > a');
  
  // Fecha todos os submenus ao iniciar
  const subMenus = document.querySelectorAll('.sub-menu');
  subMenus.forEach(subMenu => {
      subMenu.style.display = 'none'; // Começa escondido
  });

  // Verifica se há estado salvo no localStorage e reabre os submenus correspondentes
  menuItems.forEach(link => {
      const subMenu = link.nextElementSibling;
      if (subMenu && localStorage.getItem(link.id) === "open") {
          link.classList.add('active');
          subMenu.style.display = 'block';
      }
  });

  // Adiciona os eventos de clique nos links principais
  menuItems.forEach(link => {
      link.addEventListener('click', function(event) {
          const subMenu = link.nextElementSibling;

          // Verifica se o submenu existe
          if (subMenu && subMenu.classList.contains('sub-menu')) {
              event.preventDefault(); // Evita o redirecionamento do link principal

              // Fecha todos os submenus abertos, exceto o atual
              subMenus.forEach(menu => {
                  if (menu !== subMenu) {
                      menu.style.display = 'none';
                      const parentLink = menu.previousElementSibling;
                      if (parentLink) {
                          parentLink.classList.remove('active');
                          localStorage.removeItem(parentLink.id);
                      }
                  }
              });

              // Alterna a visibilidade do submenu atual
              if (subMenu.style.display === 'block') {
                  subMenu.style.display = 'none';
                  link.classList.remove('active');
                  localStorage.removeItem(link.id);
              } else {
                  subMenu.style.display = 'block';
                  link.classList.add('active');
                  localStorage.setItem(link.id, "open");
              }
          }
      });
  });
});
