document.addEventListener('DOMContentLoaded', function() {
    const estoqueLink = document.getElementById('estoque');
    const orcamentoLink = document.getElementById('orcamento');

    estoqueLink.addEventListener('click', function(event) {
        event.preventDefault();
        toggleSubMenu('sub-estoque', estoqueLink);
    });

    orcamentoLink.addEventListener('click', function(event) {
        event.preventDefault();
        toggleSubMenu('sub-orcamento', orcamentoLink);
    });

    function toggleSubMenu(subMenuId, linkElement) {
        const subMenu = document.getElementById(subMenuId);
        
        // Alterna a visibilidade do submenu
        subMenu.style.display = (subMenu.style.display === 'block' ? 'none' : 'block');
        
        // Alterna a classe 'active' no link
        linkElement.classList.toggle('active');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const estoqueLink = document.getElementById('estoque');
    const orcamentoLink = document.getElementById('orcamento');

    estoqueLink.addEventListener('click', function(event) {
        event.preventDefault();
        toggleSubMenu('sub-estoque', estoqueLink);
    });

    orcamentoLink.addEventListener('click', function(event) {
        event.preventDefault();
        toggleSubMenu('sub-orcamento', orcamentoLink);
    });

    function toggleSubMenu(subMenuId, linkElement) {
        const subMenu = document.getElementById(subMenuId);
        
        // Verifica se o submenu está aberto ou fechado
        if (subMenu.style.maxHeight) {
            // Se o submenu estiver aberto, fechamos
            subMenu.style.maxHeight = null;
        } else {
            // Caso contrário, abrimos o submenu com uma altura máxima
            subMenu.style.maxHeight = subMenu.scrollHeight + "px";
        }

        // Alterna a classe 'active' no link (para girar o ícone)
        linkElement.classList.toggle('active');
        document.addEventListener('DOMContentLoaded', function() {
            const estoqueLink = document.getElementById('estoque');
            const orcamentoLink = document.getElementById('orcamento');
            
            // Função para garantir que todos os submenus começam fechados
            const allSubMenus = document.querySelectorAll('.sub-menu');
            allSubMenus.forEach(subMenu => {
                subMenu.style.maxHeight = null; // Esconde todos os submenus inicialmente
            });
        
            // Remove a classe 'active' de todos os links de submenu inicialmente
            const allMenuLinks = document.querySelectorAll('.menu-link');
            allMenuLinks.forEach(link => {
                link.classList.remove('active');
            });
        
            estoqueLink.addEventListener('click', function(event) {
                event.preventDefault();
                toggleSubMenu('sub-estoque', estoqueLink);
            });
        
            orcamentoLink.addEventListener('click', function(event) {
                event.preventDefault();
                toggleSubMenu('sub-orcamento', orcamentoLink);
            });
        
            function toggleSubMenu(subMenuId, linkElement) {
                const subMenu = document.getElementById(subMenuId);
                
                // Alterna a visibilidade do submenu
                if (subMenu.style.maxHeight) {
                    subMenu.style.maxHeight = null; // Fecha o submenu
                } else {
                    subMenu.style.maxHeight = subMenu.scrollHeight + "px"; // Abre o submenu
                }
        
                // Alterna a classe 'active' no link para girar o ícone
                linkElement.classList.toggle('active');
            }
        });
        
    }
});

