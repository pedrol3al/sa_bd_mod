document.addEventListener("DOMContentLoaded", function () {
  // Calendário para data de fundação
  flatpickr("#dataFundacao_forn", {
    dateFormat: "d/m/Y",
    maxDate: "today"
  });

  flatpickr("#dataCadastro_forn", {
    dateFormat: "d/m/Y",
    maxDate: "today"
  });

  const notyf = new Notyf({
    position: { x: "center", y: "top" }
  });

  function conferirCampos() {
    const camposObrigatorios = [
      { id: "razao_social_forn", nome: "Razão Social" },
      { id: "cnpj_forn", nome: "CNPJ" },
      { id: "dataFundacao_forn", nome: "Data de Fundação" },
      { id: "telefone_forn", nome: "Telefone" },
      { id: "email_forn", nome: "Email" },
      { id: "cep_forn", nome: "CEP" },
      { id: "logradouro_forn", nome: "Logradouro" },
      { id: "tipo_estabelecimento_forn", nome: "Tipo de Estabelecimento" },
      { id: "uf_forn", nome: "Estado (UF)" },
      { id: "numero_forn", nome: "Número" },
      { id: "cidade_forn", nome: "Cidade" },
      { id: "bairro_forn", nome: "Bairro" },
      { id: "foto_forn", nome: "Imagem" }
    ];

    for (let campo of camposObrigatorios) {
      const elemento = document.getElementById(campo.id);
      if (elemento && elemento.value.trim() === "") {
        notyf.error(`O campo "${campo.nome}" é obrigatório!`);
        elemento.focus();
        return false;
      }
    }
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

