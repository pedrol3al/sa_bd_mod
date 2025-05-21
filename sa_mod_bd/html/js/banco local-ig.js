if (!localStorage.getItem("usuarios")) {
    const dadosIniciais = [
      { usuario: "joao123", email: "joao@example.com", senha: "senha123" },
      { usuario: "maria456", email: "maria@example.com", senha: "senha456" },
      { usuario: "carlos789", email: "carlos@example.com", senha: "senha789" },
      { usuario: "ana000",  email: "ana@example.com", senha: "ana000senha" },
      { usuario: "lucas321",email: "lucas@example.com", senha: "lucassenha" },
      { usuario: "pedro123",email: "pedro@example.com", senha: "pedrolindo123" }
    ];
    localStorage.setItem("usuarios", JSON.stringify(dadosIniciais));
  }
  document.querySelector('.botao-embora').addEventListener('click', () => {
    window.location.href = "https://www.google.com";
  });
  
  // Exibe mensagem de erro/sucesso
  function exibirMensagem(texto, isError = true) {
    const msg = document.getElementById("mensagemErro");
    if (!msg) return;
  
    msg.textContent = texto;
    msg.style.backgroundColor = isError ? "#ffdddd" : "#ddffdd";
    msg.style.color = isError ? "#990000" : "#006600";
    msg.style.display = "block";
    msg.style.opacity = "1";
    msg.style.transform = "translate(-50%, -50%)";
  
    setTimeout(() => {
      msg.style.opacity = "0";
      msg.style.transform = "translate(-50%, -60%)"; // animação suave para cima
      setTimeout(() => msg.style.display = "none", 300);
    }, 3000);
  }
  
  // LOGIN
  function fazerLogin() {
    const u = document.getElementById("usuario")?.value.trim() || "";
    const s = document.getElementById("senha")?.value        || "";
    const usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");
    if (usuarios.find(x => x.usuario===u && x.senha===s)) {
      window.location.href = "main-ig.html";
    } else exibirMensagem("Incorrect username or password.");
  }
  
  // RECUPERAR: grava e‑mail que veio da verificação
  function recuperarSenha() {
    const email = document.getElementById("email")?.value.trim() || "";
    const usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");
    if (usuarios.find(x => x.email === email)) {
      localStorage.setItem("recoveryEmail", email);
      window.location.href = "at-senha-ig.html";
    } else exibirMensagem("E-mail não encontrado no sistema.");
  }
  
  // ALTERAR SENHA
  function alterarSenha() {
    const nova = document.getElementById("novaSenha")?.value || "";
    const conf = document.getElementById("confirmarSenha")?.value || "";
    const senha = document.getElementById("senhaantiga")?.value || "";
  
    if (!nova || nova !== conf) {
      exibirMensagem("Passwords do not match.");
      return;
    }
  
    const email = localStorage.getItem("recoveryEmail");
    if (!email) {
      exibirMensagem("Internal error. Please try to recover again.");
      return;
    }
  
    let usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");
    const usuario = usuarios.find(u => u.email === email);
  
    if (!usuario) {
      exibirMensagem("User not found.");
      return;
    }
  
    if (nova === senha) {
      exibirMensagem("The new password cannot be the same as the current one.");
      return;
    }
  
    usuarios = usuarios.map(u => {
      if (u.email === email) u.senha = nova;
      return u;
    });
    localStorage.setItem("usuarios", JSON.stringify(usuarios));
    localStorage.removeItem("recoveryEmail");
    exibirMensagem("Password changed successfully!", false);
  
    setTimeout(() => window.location.href = "login-ig.html", 1500);
  }
  