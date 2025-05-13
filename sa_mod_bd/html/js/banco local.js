// Dados iniciais
if (!localStorage.getItem("usuarios")) {
    const dadosIniciais = [
      { usuario: "joao123", email: "joao@example.com", senha: "senha123" },
      { usuario: "maria456", email: "maria@example.com", senha: "senha456" },
      { usuario: "carlos789", email: "carlos@example.com", senha: "senha789" },
      { usuario: "ana000", email: "ana@example.com", senha: "ana000senha" },
      { usuario: "lucas321", email: "lucas@example.com", senha: "lucassenha" },
      { usuario: "pedro123", email: "pedro@example.com", senha: "pedrolindo123" }
    ];
    localStorage.setItem("usuarios", JSON.stringify(dadosIniciais));
  }
  
  // Função de login
  function fazerLogin() {
    const usuario = document.getElementById("usuario").value;
    const senha = document.getElementById("senha").value;
    const msgErro = document.getElementById("mensagemErro");
  
    const usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");
    const usuarioValido = usuarios.find(
      u => u.usuario === usuario && u.senha === senha
    );
  
    if (usuarioValido) {
      msgErro.style.display = "none"; // Esconde mensagem se estava visível
      window.location.href = "main.html";
    } else {
      msgErro.style.display = "block";
      setTimeout(() => {
        msgErro.style.display = "none"; // some depois de 3 segundos
      }, 2000);
    }
  }
  