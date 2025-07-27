document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#dataNascimento", {
    dateFormat: "d/m/Y"
  });
});


// Espera até que todo o conteúdo da página esteja carregado
document.addEventListener("DOMContentLoaded", function () {

    // Obtém o select do tipo de pessoa
    const tipoPessoa = document.getElementById("tipo_pessoa");
  
    // Obtém os contêineres dos campos de pessoa física e jurídica
    const camposFisica = document.getElementById("campos-fisica");
    const camposJuridica = document.getElementById("campos-juridica");
  
    // Adiciona um ouvinte de evento ao select, que será executado sempre que o valor mudar
    tipoPessoa.addEventListener("change", function () {
  
      // Pega o valor selecionado no select (fisica, juridica ou vazio)
      const valor = tipoPessoa.value;
  
      // Se o valor for "fisica", mostra os campos da pessoa física e esconde os da jurídica
      if (valor === "fisica") {
        camposFisica.style.display = "block";      // Mostra os campos da pessoa física
        camposJuridica.style.display = "none";     // Esconde os campos da jurídica
  
      // Se o valor for "juridica", mostra os campos da jurídica e esconde os da física
      } else if (valor === "juridica") {
        camposFisica.style.display = "none";       // Esconde os campos da pessoa física
        camposJuridica.style.display = "block";    // Mostra os campos da jurídica
  
      // Se nenhum for selecionado (valor vazio), esconde ambos
      } else {
        camposFisica.style.display = "none";
        camposJuridica.style.display = "none";
      }
    });
  
  });
  