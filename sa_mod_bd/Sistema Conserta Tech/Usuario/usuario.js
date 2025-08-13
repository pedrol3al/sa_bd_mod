document.addEventListener("DOMContentLoaded", function () {
    // Calendário para data de nascimento
    flatpickr("#dataNascimento_usuario", {
        dateFormat: "d/m/Y",
        maxDate: "today"
    });

    const notyf = new Notyf({
        position: { x: 'center', y: 'top' }
    });

    function conferirCampos() {
        const camposObrigatorios = [
            { id: 'id_adm', nome: 'Id do adminstrador'},
            { id: 'nome_usuario', nome: 'Nome' },
            { id: 'email_usuario', nome: 'Email' },
            { id: 'cpf_usuario', nome: 'CPF' },
            { id: 'dataNascimento_usuario', nome: 'Data de Nascimento' },
            { id: 'sexo_usuario', nome: 'Sexo' },
            { id: 'telefone_usuario', nome: 'Telefone' },
            { id: 'cep_usuario', nome: 'CEP' },
            { id: 'logradouro_usuario', nome: 'Logradouro' },
            { id: 'tipo_casa_usuario', nome: 'Tipo de moradia' },
            { id: 'uf_usuario', nome: 'Estado (UF)' },
            { id: 'numero_usuario', nome: 'Número' },
            { id: 'cidade_usuario', nome: 'Cidade' },
            { id: 'bairro_usuario', nome: 'Bairro' },
            { id: 'foto_usuario', nome: 'Foto do funcionario' },
            { id: 'cargo_usuario', nome: 'Cargo do funcionario'}
        ];

        for (let campo of camposObrigatorios) {
            const elemento = document.getElementById(campo.id);
            if (elemento && elemento.value.trim() === '') {
                notyf.error(`O campo "${campo.nome}" é obrigatório!`);
                elemento.focus();
                return false;
            }
        }

        notyf.success(`Cliente cadastrado!`);
        return true;
    }

    // Máscaras
    $(document).ready(function () {
        $('#cpf_usuario').mask('000.000.000-00');
        $('#telefone_usuario').mask('(00) 00000-0000');
        $('#cep_usuario').mask('00000-000');
    });

    // Expor função para botão
    window.conferirCampos = conferirCampos;
});
