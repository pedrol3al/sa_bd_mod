


document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll('.item-menu > a');
    const subMenus = document.querySelectorAll('.sub-menu a');

    const subEstoque = document.getElementById('sub-estoque');
    const subOrcamento = document.getElementById('sub-orcamento');

    function toggleActiveItem(item) {
        const isActive = item.classList.contains('ativo');

        // Remove todos os destaques
        menuItems.forEach(i => i.classList.remove('ativo'));
        document.querySelectorAll('.sub-menu').forEach(sub => sub.classList.remove('active'));
        subMenus.forEach(link => link.classList.remove('selecionado'));

        if (!isActive) {
            item.classList.add('ativo');
            if (item.id === 'estoque') subEstoque.classList.add('active');
            if (item.id === 'orcamento') subOrcamento.classList.add('active');
        }
    }

    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Se for apenas "#", impede navegação e alterna submenu
            if (!href || href === "#") {
                e.preventDefault();
                toggleActiveItem(this);
            }
            
        });
    });

        //Estilização do site acima, favor não alterar


    subMenus.forEach(subItem => {
        subItem.addEventListener('click', function () {
            subMenus.forEach(i => i.classList.remove('selecionado'));
            this.classList.add('selecionado');
            // Permite navegação normal sem preventDefault()
        });
    });
});
