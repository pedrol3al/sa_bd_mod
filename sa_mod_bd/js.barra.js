document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll('.item-menu > a');
    const subMenus = document.querySelectorAll('.sub-menu a');

    const estoque = document.getElementById('estoque');
    const orcamento = document.getElementById('orcamento');

    const subEstoque = document.getElementById('sub-estoque');
    const subOrcamento = document.getElementById('sub-orcamento');

    function toggleActiveItem(item) {
        const isActive = item.classList.contains('ativo');

        // Remove todos os destaques
        menuItems.forEach(i => i.classList.remove('ativo'));
        document.querySelectorAll('.sub-menu').forEach(sub => sub.classList.remove('active'));
        document.querySelectorAll('.sub-menu a').forEach(link => link.classList.remove('selecionado'));

        if (!isActive) {
            item.classList.add('ativo');

            if (item === estoque) subEstoque.classList.add('active');
            if (item === orcamento) subOrcamento.classList.add('active');
        }
    }

    // Clique em itens principais (com ou sem submenu)
    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            // Ignora se clicou em um link de submenu
            if (this.closest('.sub-menu')) return;

            const isActive = this.classList.contains('ativo');

            if (isActive) {
                // Desativa item e esconde submenus
                this.classList.remove('ativo');
                document.querySelectorAll('.sub-menu').forEach(sub => sub.classList.remove('active'));
                document.querySelectorAll('.sub-menu a').forEach(link => link.classList.remove('selecionado'));
            } else {
                toggleActiveItem(this);
            }
        });
    });

    // Clique nos submenus
    subMenus.forEach(subItem => {
        subItem.addEventListener('click', function (e) {
            e.preventDefault();

            // Marca apenas o submenu clicado
            subMenus.forEach(i => i.classList.remove('selecionado'));
            this.classList.add('selecionado');
        });
    });
});
