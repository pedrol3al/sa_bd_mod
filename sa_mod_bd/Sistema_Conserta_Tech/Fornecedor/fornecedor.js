document.addEventListener("DOMContentLoaded", function () {
  // Calendário para data de fundação
  flatpickr("#dataFundacao_forn", {
    dateFormat: "d/m/Y",
    maxDate: "today"
  });

  const notyf = new Notyf({
    position: { x: "center", y: "top" }
  });

  function conferirCampos(event) {
    const camposObrigatorios = [
        'razao_social_forn', 'email_forn', 'cnpj_forn', 'dataFundacao_forn',
        'telefone_forn', 'cep_forn', 'logradouro_forn', 'tipo_estabelecimento_forn',
        'numero_forn', 'cidade_forn', 'uf_forn', 'bairro_forn'
    ];

    for (let id of camposObrigatorios) {
        const elemento = document.getElementById(id);
        if (!elemento || elemento.value.trim() === '') {
            notyf.error(`O campo "${id}" é obrigatório!`);
            elemento.focus();
            event.preventDefault(); // impede o submit
            return false;
        }
    }

    notyf.success('Todos os campos preenchidos!');
    // permite o submit
}


  // Máscaras
  $(document).ready(function () {
    $("#cnpj_forn").mask("00.000.000/0000-00");
    $("#telefone_forn").mask("(00) 00000-0000");
    $("#cep_forn").mask("00000-000");
  });

  // Expor função para botão
  window.conferirCampos = conferirCampos;
});

