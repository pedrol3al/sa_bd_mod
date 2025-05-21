document.addEventListener("DOMContentLoaded", function () {
    // Botões e formulário
    const botaoCadastrar = document.querySelector(".cadastrar");
    const botaoPesquisar = document.querySelector(".pesquisar");
    const botaoNovo = document.querySelector(".novo");
    const formulario = document.querySelector("form");
  
    // Container da mensagem de erro
    const containerErro = document.createElement("div");
    containerErro.style.backgroundColor = "#f8d7da";
    containerErro.style.color = "#721c24";
    containerErro.style.padding = "10px";
    containerErro.style.marginBottom = "15px";
    containerErro.style.border = "1px solid #f5c6cb";
    containerErro.style.borderRadius = "5px";
    containerErro.style.display = "none"; // Oculto inicialmente
    formulario.insertBefore(containerErro, formulario.firstChild);
  
    // Função para verificar campos vazios
    function camposVazios() {
      const campos = formulario.querySelectorAll("input, select, textarea");
      return Array.from(campos).every((campo) => campo.value.trim() === "");
    }
  
    // Função para exibir mensagem de erro se todos os campos estiverem vazios
    botaoCadastrar.addEventListener("click", function (event) {
      event.preventDefault();
  
      if (camposVazios()) {
        containerErro.textContent = "Preencha todos os campos!";
        containerErro.style.display = "block";
        containerMensagem.style.display = "none"; // Oculta a mensagem de sucesso
        return;
      }
  
      // Caso os campos não estejam vazios, exibe a mensagem de sucesso
      containerMensagem.textContent = "Cliente cadastrado com sucesso!";
      containerMensagem.style.display = "block";
      containerErro.style.display = "none"; // Oculta a mensagem de erro
    });
  
    // Container da mensagem de cadastro
    const containerMensagem = document.createElement("div");
    containerMensagem.style.backgroundColor = "#d4edda";
    containerMensagem.style.color = "#155724";
    containerMensagem.style.padding = "10px";
    containerMensagem.style.marginBottom = "15px";
    containerMensagem.style.border = "1px solid #c3e6cb";
    containerMensagem.style.borderRadius = "5px";
    containerMensagem.style.display = "none"; // Oculta inicialmente
    formulario.insertBefore(containerMensagem, formulario.firstChild);
  
    // Função para limpar o formulário ao clicar em "Novo"
    botaoNovo.addEventListener("click", function (event) {
      event.preventDefault();
      formulario.reset(); // Limpa todos os campos do formulário
      containerMensagem.style.display = "none"; // Oculta a mensagem
    });
  
    // Cria a barra de pesquisa lateral
    const barraPesquisa = document.createElement("div");
    barraPesquisa.style.position = "fixed";
    barraPesquisa.style.top = "0";
    barraPesquisa.style.right = "0";
    barraPesquisa.style.width = "300px";
    barraPesquisa.style.height = "100vh";
    barraPesquisa.style.backgroundColor = "#f4f4f4";
    barraPesquisa.style.padding = "20px";
    barraPesquisa.style.boxShadow = "-2px 0 5px rgba(0,0,0,0.2)";
    barraPesquisa.style.display = "none"; // Inicialmente oculta
  
    // Campo de entrada para pesquisa
    const inputPesquisa = document.createElement("input");
    inputPesquisa.type = "text";
    inputPesquisa.placeholder = "Digite para pesquisar...";
    inputPesquisa.style.width = "100%";
    inputPesquisa.style.padding = "10px";
    inputPesquisa.style.marginBottom = "10px";
    inputPesquisa.style.borderRadius = "4px";
    inputPesquisa.style.border = "1px solid #ccc";
  
    // Botão para fechar a barra de pesquisa
    const botaoFechar = document.createElement("button");
    botaoFechar.textContent = "Fechar";
    botaoFechar.style.marginTop = "10px";
    botaoFechar.style.padding = "8px";
    botaoFechar.style.backgroundColor = "#2196F3";
    botaoFechar.style.color = "white";
    botaoFechar.style.border = "none";
    botaoFechar.style.borderRadius = "4px";
    botaoFechar.style.cursor = "pointer";
  
    // Adiciona os elementos à barra de pesquisa
    barraPesquisa.appendChild(inputPesquisa);
    barraPesquisa.appendChild(botaoFechar);
    document.body.appendChild(barraPesquisa);
  
    // Evento de clique no botão "Pesquisar"
    botaoPesquisar.addEventListener("click", function () {
      barraPesquisa.style.display = "block"; // Mostra a barra de pesquisa
    });
  
    // Evento de clique no botão "Fechar"
    botaoFechar.addEventListener("click", function () {
      barraPesquisa.style.display = "none"; // Oculta a barra de pesquisa
    });
  });
  