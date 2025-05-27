// Verifica se ainda não existe o item "usuarios" no localStorage
if (!localStorage.getItem("usuarios")) {
  // Se não existir, cria um array com dados iniciais de usuários
  const dadosIniciais = [
    { usuario: "joao123", email: "joao@example.com", senha: "senha123" },
    { usuario: "maria456", email: "maria@example.com", senha: "senha456" },
    { usuario: "carlos789", email: "carlos@example.com", senha: "senha789" },
    { usuario: "ana000",    email: "ana@example.com",   senha: "ana000senha" },
    { usuario: "lucas321",  email: "lucas@example.com", senha: "lucassenha" },
    { usuario: "pedro123",  email: "pedro@example.com", senha: "pedrolindo123" }
  ];
  // Salva os dados no localStorage como uma string JSON
  localStorage.setItem("usuarios", JSON.stringify(dadosIniciais));
}

// Adiciona um evento de clique no botão com a classe 'botao-embora'
// Quando clicado, redireciona o usuário para o site do Google
document.querySelector('.botao-embora').addEventListener('click', () => {
  window.location.href = "https://www.google.com";
});

// Função que exibe uma mensagem de erro ou sucesso na tela
function exibirMensagem(texto, isError = true) {
  const msg = document.getElementById("mensagemErro"); // Pega o elemento da mensagem
  if (!msg) return; // Se não existir, sai da função

  // Define o texto da mensagem
  msg.textContent = texto;
  // Define o fundo e a cor da mensagem com base se é erro ou não
  msg.style.backgroundColor = isError ? "#ffdddd" : "#ddffdd"; // vermelho para erro, verde para sucesso
  msg.style.color = isError ? "#990000" : "#006600"; // texto vermelho ou verde
  msg.style.display = "block"; // torna visível
  msg.style.opacity = "1"; // opacidade total
  msg.style.transform = "translate(-50%, -50%)"; // posicionamento centralizado

  // Após 3 segundos, esmaece e esconde a mensagem
  setTimeout(() => {
    msg.style.opacity = "0";
    msg.style.transform = "translate(-50%, -60%)"; // animação suave para cima
    setTimeout(() => msg.style.display = "none", 300); // esconde após animação
  }, 3000);
}

// Função de login
function fazerLogin() {
  // Obtém os valores dos campos de usuário e senha
  const u = document.getElementById("usuario")?.value.trim() || "";
  const s = document.getElementById("senha")?.value || "";

  // Recupera os usuários do localStorage (ou array vazio, se não existir)
  const usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");

  // Verifica se há um usuário com login e senha correspondentes
  if (usuarios.find(x => x.usuario === u && x.senha === s)) {
    // Redireciona para a página principal se encontrado
    window.location.href = "main-ig.html";
  } else {
    // Caso contrário, exibe mensagem de erro
    exibirMensagem("Incorrect username or password.");
  }
}

// Função para recuperar senha
function recuperarSenha() {
  // Obtém o e-mail digitado
  const email = document.getElementById("email")?.value.trim() || "";

  // Recupera os usuários do localStorage
  const usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");

  // Verifica se o e-mail existe entre os usuários
  if (usuarios.find(x => x.email === email)) {
    // Salva o e-mail no localStorage para uso posterior
    localStorage.setItem("recoveryEmail", email);
    // Redireciona para a página de alteração de senha
    window.location.href = "at-senha-ig.html";
  } else {
    // Se não encontrado, exibe mensagem de erro
    exibirMensagem("E-mail não encontrado no sistema.");
  }
}

// Função para alterar a senha
function alterarSenha() {
  // Pega os valores dos campos de nova senha, confirmação e senha antiga
  const nova = document.getElementById("novaSenha")?.value || "";
  const conf = document.getElementById("confirmarSenha")?.value || "";
  const senha = document.getElementById("senhaantiga")?.value || "";

  // Verifica se as senhas coincidem e se foram preenchidas
  if (!nova || nova !== conf) {
    exibirMensagem("Passwords do not match.");
    return;
  }

  // Pega o e-mail salvo durante a recuperação
  const email = localStorage.getItem("recoveryEmail");
  if (!email) {
    exibirMensagem("Internal error. Please try to recover again.");
    return;
  }

  // Recupera os usuários
  let usuarios = JSON.parse(localStorage.getItem("usuarios") || "[]");

  // Encontra o usuário pelo e-mail
  const usuario = usuarios.find(u => u.email === email);
  if (!usuario) {
    exibirMensagem("User not found.");
    return;
  }

  // Verifica se a nova senha é diferente da antiga
  if (nova === senha) {
    exibirMensagem("The new password cannot be the same as the current one.");
    return;
  }

  // Atualiza a senha do usuário no array
  usuarios = usuarios.map(u => {
    if (u.email === email) u.senha = nova;
    return u;
  });

  // Salva o array atualizado no localStorage
  localStorage.setItem("usuarios", JSON.stringify(usuarios));

  // Remove o e-mail usado na recuperação
  localStorage.removeItem("recoveryEmail");

  // Exibe mensagem de sucesso
  exibirMensagem("Password changed successfully!", false);

  // Redireciona para a tela de login após 1.5 segundos
  setTimeout(() => window.location.href = "login-ig.html", 1500);
}
