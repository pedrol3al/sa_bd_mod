// Função para conferir se os campos estão preenchidos
function conferirCampos() {
    var nome = document.getElementById('nome');
    var senha = document.getElementById('senha');

    const notyf = new Notyf({
        position: { x: 'center', y: 'top' }
    });

    if (!nome || nome.value.trim() === "") {
        notyf.error('Campo de nome deve ser preenchido!');
        return false;
    }

    if (!senha || senha.value.trim() === "") {
        notyf.error('Campo senha deve ser preenchido');
        return false;
    }

    return true; // Campos válidos
}

// Adiciona o evento de clique ao botão "logar"
document.getElementById("logar")?.addEventListener("click", function (event) {
    event.preventDefault(); // Impede envio automático, caso seja <button type="submit">

    if (conferirCampos()) {
        window.location.href = "../Principal/main.html"; // Redireciona somente se a validação for OK
    }
});
