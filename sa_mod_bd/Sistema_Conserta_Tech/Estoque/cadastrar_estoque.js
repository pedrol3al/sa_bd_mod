document.addEventListener("DOMContentLoaded", function () {
    // Calendário para data de nascimento
    flatpickr("#dataPeca", {
        dateFormat: "d/m/Y",
        maxDate: "today"
    });

    const notyf = new Notyf({
        position: { x: 'center', y: 'top' }
    });

    function conferirCampos() {
        const camposObrigatorios = [
            { id: 'id_usuario', nome: 'Id do usuário'},
            { id: 'nome_peca', nome: 'Nome da peça' },
            { id: 'id_fornecedor', nome: 'Id do fornecedor' },
            { id: 'dataPeca', nome: 'Data de cadastro' },
            { id: 'quantidade', nome: 'Quantidade' },
            { id: 'valor_unit', nome: 'Valor unitáio' },
            { id: 'descricao', nome: 'Descrição' },
            { id: 'foto_peca', nome: 'Foto da peça' },
        ];

        for (let campo of camposObrigatorios) {
            const elemento = document.getElementById(campo.id);
            if (elemento && elemento.value.trim() === '') {
                notyf.error(`O campo "${campo.nome}" é obrigatório!`);
                elemento.focus();
                return false;
            }
        }
        return true;
    }

    // Máscaras

    $(document).ready(function () {
        $('#valor_unit').mask('R$000.000,00', {reverse: true});

    });
    

    // Expor função para botão
    window.conferirCampos = conferirCampos;
});

